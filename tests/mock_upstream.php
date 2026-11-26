<?php
declare(strict_types=1);
header('Content-Type: application/json');
echo json_encode([
    'ok' => true,
    'method' => $_SERVER['REQUEST_METHOD'],
    'path' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? '',
    'auth' => $_SERVER['HTTP_AUTHORIZATION'] ?? '',
    'idem' => $_SERVER['HTTP_IDEMPOTENCY_KEY'] ?? '',
    'body' => file_get_contents('php://input'),
    'files' => array_map(fn($f) => ['name' => $f['name'], 'size' => $f['size']], $_FILES),
    'post' => $_POST,
]);
