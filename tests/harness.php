<?php
declare(strict_types=1);
require __DIR__ . '/../app.php';

$passed = 0;
$failed = 0;

function t(string $name, callable $fn): void {
    global $passed, $failed;
    try {
        $fn();
        $passed++;
        echo "ok   - $name\n";
    } catch (Throwable $e) {
        $failed++;
        echo "FAIL - $name: " . $e->getMessage() . "\n";
    }
}

function eq(mixed $expected, mixed $actual, string $msg = ''): void {
    if ($expected !== $actual) {
        throw new RuntimeException($msg . ' expected ' . var_export($expected, true)
            . ', got ' . var_export($actual, true));
    }
}

function ok(bool $cond, string $msg): void {
    if (!$cond) throw new RuntimeException($msg);
}

function test_email(): string {
    return 't_' . bin2hex(random_bytes(6)) . '@apiadult.online';
}

function make_user(array $over = []): array {
    $email = $over['email'] ?? test_email();
    db()->prepare('INSERT INTO users(email,password_hash,credits) VALUES(?,?,?)')
       ->execute([$email, password_hash('TestPass123!', PASSWORD_ARGON2ID), $over['credits'] ?? 0]);
    $id = (int)db()->lastInsertId();
    return ['id' => $id, 'email' => $email];
}

function cleanup_test_users(): void {
    db()->prepare("DELETE FROM users WHERE email LIKE 't\\_%' ESCAPE '\\\\'")->execute();
}

register_shutdown_function('cleanup_test_users');
