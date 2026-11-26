<?php
declare(strict_types=1);
require __DIR__ . '/app.php';
$u = current_user();
if (!$u) { header('Location: /login.php?next=/playground_submit.php'); exit; }
$key = aa_session_key();
$model = preg_replace('/[^a-z0-9.\-]/i', '', $_POST['model'] ?? '');
$prompt = trim((string)($_POST['prompt'] ?? ''));
if ($model === '' || $prompt === '') api_error('invalid_request', 400, 'model and prompt required');
$body = json_encode(['prompt' => $prompt], JSON_UNESCAPED_UNICODE);
[$code, $out] = aa_proxy('POST', '/' . $model, $body, 'application/json',
                         ['Idempotency-Key: aa_pg_' . hash('sha256', $u['id'] . $model . $prompt)]);
http_response_code($code ?: 502);
header('Content-Type: application/json; charset=utf-8');
echo $out;
