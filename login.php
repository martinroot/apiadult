<?php
declare(strict_types=1);
require __DIR__ . '/app.php';
start_session();
if (current_user()) redirect('/account.php');
$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = strtolower(trim($_POST['email'] ?? ''));
    $pass  = $_POST['password'] ?? '';
    $row = db()->prepare('SELECT * FROM users WHERE email=? AND status="active"');
    $row->execute([$email]);
    $u = $row->fetch();
    if (!$u || !password_verify($pass, $u['password_hash'])) {
        $error = 'Invalid email or password.';
    } else {
        $token = bin2hex(random_bytes(32));
        db()->prepare('INSERT INTO sessions(id,user_id,expires_at) VALUES(?,?,DATE_ADD(NOW(), INTERVAL 30 DAY))')
            ->execute([hash('sha256', $token), $u['id']]);
        db()->prepare('UPDATE users SET last_login_at=NOW() WHERE id=?')->execute([$u['id']]);
        setcookie('aa_session', $token, [
            'expires' => time() + 60 * 60 * 24 * 30,
            'path' => '/',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        $next = $_GET['next'] ?? '/account.php';
        redirect(str_starts_with($next, '/') && !str_starts_with($next, '//') ? $next : '/account.php');
    }
}
require __DIR__ . '/layout.php';
page_start('Sign in', 'Sign in to your APIAdult account.');
?>
<section class="wrap" style="max-width:420px">
  <h1 class="h2">Sign in</h1>
  <?php if ($error): ?><p class="mut" style="color:#ff8b8b"><?= h($error) ?></p><?php endif; ?>
  <form method="post" class="card" style="display:grid;gap:12px;margin:18px 0">
    <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
    <label>Email<input type="email" name="email" required value="<?= h($email) ?>" autocomplete="email"></label>
    <label>Password<input type="password" name="password" required autocomplete="current-password"></label>
    <button class="btn primary" type="submit">Sign in</button>
  </form>
  <p class="mut">No account? <a href="/register.php">Create one</a>.</p>
</section>
<?php page_end(); ?>
