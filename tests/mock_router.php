<?php
if (str_starts_with(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/v1/')) {
    require __DIR__ . '/mock_upstream.php';
    return true;
}
return false;
