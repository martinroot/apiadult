<?php
declare(strict_types=1);
// /v1 — OpenAI-compatible gateway. Authenticates local keys, proxies to HotAPI.
require __DIR__ . '/../app.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Idempotency-Key');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') { http_response_code(204); exit; }

$path   = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/', '/');
$path   = preg_replace('#^/v1/?#', '/', $path);
$path   = $path === '' ? '/' : $path;
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$rid    = req_id();
$UPSTREAM = rtrim(aa_env('AA_UPSTREAM_BASE', 'https://api.hotapi.ai'), '/');
$UPSTREAM_KEY = aa_env('AA_UPSTREAM_KEY');

// Public: model catalogue mirrored from HotAPI (no auth needed on their side)
if ($path === '/models' && $method === 'GET') {
    $cache = '/tmp/apiadult_models.json';
    $raw = (is_file($cache) && time() - filemtime($cache) < 300) ? file_get_contents($cache) : null;
    if ($raw === null) {
        $ch = curl_init("$UPSTREAM/v1/models");
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 15,
                                CURLOPT_FOLLOWLOCATION => true, CURLOPT_USERAGENT => 'apiadult-gateway/1.0']);
        $raw = curl_exec($ch); curl_close($ch);
        if ($raw && json_decode($raw, true)) file_put_contents($cache, $raw);
    }
    if ($raw) {
        header('Content-Type: application/json; charset=utf-8');
        echo $raw; exit;
    }
    require_once __DIR__ . '/../models_data.php';
    json_out(['object' => 'list', 'data' => array_map(fn($m) => [
        'id' => strtolower(preg_replace('/[^a-z0-9]+/i', '-', $m['name'])),
        'object' => 'model', 'owned_by' => 'apiadult', 'modal' => $m['cat'] ?? 'video',
    ], aasite_models())]);
}

$key = bearer_key();
if (!$key) api_error('authentication_error', 401, 'Provide Authorization: Bearer aal_live_…', $rid);
$owner = key_owner($key);
if (!$owner) api_error('authentication_error', 401, 'Invalid or revoked API key', $rid);

if (!$UPSTREAM_KEY) {
    api_error('service_unavailable', 503, 'Upstream provider key is not configured on the server', $rid);
}

function proxy(string $upstream, string $method, string $path, string $upstreamKey, array $extraHeaders = []): array {
    $url = $upstream . '/v1' . $path;
    $headers = ['Authorization: Bearer ' . $upstreamKey,
                'Content-Type: application/json',
                'Accept: application/json',
                'User-Agent: apiadult-gateway/1.0'];
    foreach ($extraHeaders as $h) $headers[] = $h;
    $body = file_get_contents('php://input');
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => in_array($method, ['POST', 'PUT', 'PATCH'], true) ? ($body ?: '{}') : null,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_FOLLOWLOCATION => true,
    ]);
    $resp = curl_exec($ch);
    if ($resp === false) {
        $e = curl_error($ch); curl_close($ch);
        return [0, '', 'upstream error: ' . $e];
    }
    $hlen = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $head = substr($resp, 0, $hlen);
    $out  = substr($resp, $hlen);
    curl_close($ch);
    $reqid = '';
    if (preg_match('/^x-request-id:\s*(\S+)/mi', $head, $m)) $reqid = trim($m[1]);
    return [$code, $out, $reqid];
}

// Allowed proxy paths
$allowed = $method === 'GET'
    ? ['/balance', '/usage', '/tasks', '/face-assets']
    : ['/tasks', '/tasks/results/bulk-delete', '/uploads', '/uploads/delete'];
$isModelPost = $method === 'POST' && preg_match('#^/[a-z0-9.\-]+(?:/[a-z0-9\-]+)?$#', $path);
$isTaskGet   = $method === 'GET'  && preg_match('#^/tasks/[\w\-]+$#', $path);
$isTaskDel   = $method === 'DELETE' && preg_match('#^/tasks/[\w\-]+$#', $path);
$isAssetDel  = $method === 'DELETE' && preg_match('#^/face-assets(?:/[\w\-]+)?$#', $path);
if (!in_array($path, $allowed, true) && !$isModelPost && !$isTaskGet && !$isTaskDel && !$isAssetDel) {
    api_error('not_found', 404, "Unknown endpoint $method $path. See /docs/.", $rid);
}

$idem = $_SERVER['HTTP_IDEMPOTENCY_KEY'] ?? '';
if ($idem === '') $idem = 'aa_' . hash('sha256', $owner['id'] . $path . file_get_contents('php://input'));
[$code, $out, $upstreamRid] = proxy($UPSTREAM, $method, $path, $UPSTREAM_KEY, ['Idempotency-Key: ' . $idem]);

// Mirror created tasks locally
if ($method === 'POST') {
    $json = json_decode($out, true);
    if (is_array($json) && (isset($json['id']) || isset($json['task_id']))) {
        $tid = $json['id'] ?? $json['task_id'];
        $in = json_decode(file_get_contents('php://input'), true);
        $model = $json['model'] ?? ($in['model'] ?? 'unknown');
        db()->prepare('INSERT IGNORE INTO tasks(user_id,api_key_id,task_id,model,status,request_json,result_json)
                       VALUES(?,?,?,?,?,?,?)')
           ->execute([$owner['id'], $owner['key_id'], $tid, $model, $json['status'] ?? 'queued',
                      file_get_contents('php://input'), $out]);
    }
}

http_response_code($code ?: 502);
if (str_contains($out, '"error"') && $upstreamRid) {
    $j = json_decode($out, true);
    if (is_array($j) && isset($j['error']) && is_array($j['error'])) {
        $j['error']['request_id'] = $j['error']['request_id'] ?? $upstreamRid;
        $out = json_encode($j, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
header('Content-Type: application/json; charset=utf-8');
echo $out ?: json_encode(['error' => ['type' => 'upstream_error', 'message' => 'Empty upstream response', 'request_id' => $rid]]);
