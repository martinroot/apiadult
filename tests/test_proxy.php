<?php
declare(strict_types=1);
putenv('AA_UPSTREAM_BASE=http://127.0.0.1:8892');
putenv('AA_UPSTREAM_KEY=test-upstream-key');
require __DIR__ . '/harness.php';

t('aa_proxy() exists', function () {
    ok(function_exists('aa_proxy'), 'aa_proxy() not defined in app.php');
});

t('aa_proxy forwards method, path, auth and body', function () {
    [$code, $out] = aa_proxy('POST', '/tasks', '{"model":"z-image-spicy"}', 'application/json');
    eq(200, $code);
    $j = json_decode($out, true);
    ok(is_array($j), 'upstream response is not JSON: ' . $out);
    eq('POST', $j['method']);
    eq('/v1/tasks', $j['path']);
    eq('Bearer test-upstream-key', $j['auth']);
    eq('{"model":"z-image-spicy"}', $j['body']);
});

t('aa_proxy keeps multipart content type and raw body', function () {
    $boundary = '----aaTestBoundary';
    $body = "--$boundary\r\nContent-Disposition: form-data; name=\"file\"; filename=\"a.bin\"\r\n"
          . "Content-Type: application/octet-stream\r\n\r\nABC\r\n--$boundary--\r\n";
    [$code, $out] = aa_proxy('POST', '/uploads', $body, "multipart/form-data; boundary=$boundary");
    eq(200, $code);
    $j = json_decode($out, true);
    ok(str_starts_with($j['content_type'], 'multipart/form-data'), 'content-type lost: ' . $j['content_type']);
    $names = array_column($j['files'] ?? [], 'name');
    ok(in_array('a.bin', $names, true), 'multipart file lost: ' . json_encode($j['files'] ?? []));
});
