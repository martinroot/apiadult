<?php
declare(strict_types=1);
// app.php — shared bootstrap: DB, session helpers, auth, JSON responses.
// DB credentials are read from env (set in php-fpm pool), never committed.

const AA_ENV_FILE = '/home/apiadult/.config/apiadult/credentials.env';

function aa_env(string $name, string $default = ''): string {
    static $env = null;
    if ($env === null) {
        $env = [];
        $f = AA_ENV_FILE;
        if (is_readable($f)) {
            foreach (file($f, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(ltrim($line), '#') || !str_contains($line, '=')) continue;
                [$k, $v] = explode('=', $line, 2);
                $env[trim($k)] = trim($v, " \t\r\n\"'");
            }
        }
    }
    $v = getenv($name);
    if ($v !== false && $v !== '') return $v;
    return $env[$name] ?? $default;
}

function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;
    $host = aa_env('AA_DB_HOST', '127.0.0.1');
    $name = aa_env('AA_DB_NAME', 'apiadult');
    $user = aa_env('AA_DB_USER', 'apiadult');
    $pass = aa_env('AA_DB_PASS');
    $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}

function json_out(array $data, int $code = 200): never {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function api_error(string $type, int $code, string $message, ?string $requestId = null): never {
    $e = ['type' => $type, 'code' => $code, 'message' => $message];
    if ($requestId) $e['request_id'] = $requestId;
    json_out(['error' => $e], $code);
}

function req_id(): string {
    return 'req_' . bin2hex(random_bytes(8));
}

function start_session(): void {
    if (session_status() !== PHP_SESSION_NONE) return;
    session_set_cookie_params([
        'lifetime' => 60 * 60 * 24 * 30,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function current_user(): ?array {
    start_session();
    $token = $_COOKIE['aa_session'] ?? '';
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) return null;
    $row = db()->prepare('SELECT u.* FROM sessions s JOIN users u ON u.id=s.user_id
                          WHERE s.id=? AND s.expires_at > NOW() AND u.status="active"');
    $row->execute([hash('sha256', $token)]);
    return $row->fetch() ?: null;
}

function require_user(): array {
    $u = current_user();
    if (!$u) {
        header('Location: /login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/'));
        exit;
    }
    return $u;
}

function csrf_token(): string {
    start_session();
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function csrf_check(): void {
    start_session();
    $got = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $got)) {
        http_response_code(403);
        exit('CSRF token mismatch');
    }
}

function redirect(string $path): never {
    header('Location: ' . $path);
    exit;
}

function generate_key(): string {
    // aal_live_<48 hex> — 56 chars, recognizable prefix
    return 'aal_live_' . bin2hex(random_bytes(24));
}

function issue_key(int $userId, string $name): array {
    $key = generate_key();
    $prefix = substr($key, 0, 16);
    $hash = hash('sha256', $key);
    db()->prepare('INSERT INTO api_keys(user_id,name,prefix,key_hash) VALUES(?,?,?,?)')
       ->execute([$userId, $name, $prefix, $hash]);
    return ['key' => $key, 'prefix' => $prefix];
}

function key_owner(string $key): ?array {
    if (!preg_match('/^aal_live_[a-f0-9]{48}$/', $key)) return null;
    $row = db()->prepare('SELECT u.*, k.id AS key_id FROM api_keys k
                          JOIN users u ON u.id=k.user_id
                          WHERE k.key_hash=? AND k.revoked_at IS NULL AND u.status="active"');
    $row->execute([hash('sha256', $key)]);
    $r = $row->fetch();
    if ($r) {
        db()->prepare('UPDATE api_keys SET last_used_at=NOW() WHERE id=?')->execute([$r['key_id']]);
    }
    return $r ?: null;
}

function bearer_key(): ?string {
    $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/^Bearer\s+(aal_live_[A-Za-z0-9]+)$/i', $auth, $m)) return $m[1];
    return null;
}

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
