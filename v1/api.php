<?php
// /v1 — gateway каркас. Провайдеры не подключены: отвечает валидным API-контрактом.
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Idempotency-Key');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') { http_response_code(204); exit; }

$path   = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/', '/');
$path   = preg_replace('#^/v1#', '', $path);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$auth   = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

function j(array $a, int $code = 200): never {
    http_response_code($code);
    echo json_encode($a, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}
function err(string $type, int $code, string $msg): never {
    j(['error' => ['type' => $type, 'code' => $code, 'message' => $msg]], $code);
}

require __DIR__.'/../models_data.php';

if ($path === '' || $path === '/models') {
    if ($method !== 'GET') err('method_not_allowed', 405, 'Use GET.');
    $models = aasite_models();
    j(['ok' => true,
       'object' => 'list',
       'data' => array_map(fn($m) => [
           'id'      => strtolower(preg_replace('/[^a-z0-9]+/i', '-', $m['name'])),
           'name'    => $m['name'],
           'category'=> $m['cat'],
           'price'   => $m['price'],
           'status'  => 'announced',
       ], $models),
       'note' => 'Gateway is in setup: task endpoints will begin routing once provider credentials are configured.']);
}

// Всё остальное требует ключ
if (!preg_match('/^Bearer\s+(\S+)$/i', $auth, $mm)) {
    err('authentication_error', 401, 'Provide Authorization: Bearer <key>.');
}
$key = $mm[1];

if ($path === '/balance') {
    j(['ok' => true, 'key' => substr($key, 0, 10) . '…', 'credits' => 0,
       'note' => 'Billing activates together with task routing.']);
}

if (in_array($path, ['/images', '/videos', '/chat/completions'], true) && $method === 'POST') {
    err('service_unavailable', 503,
        'Gateway is provisioned but providers are not connected yet. Model routing starts after upstream credentials are configured.');
}

if (preg_match('#^/tasks/[\w-]+$#', $path)) {
    j(['ok' => true, 'task_id' => basename($path), 'status' => 'expired',
       'note' => 'No task recorded under this key.']);
}

err('not_found', 404, "Unknown endpoint $method $path. See /docs/.");
