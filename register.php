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
    $pass2 = $_POST['password2'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email address.';
    } elseif (strlen($pass) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($pass !== $pass2) {
        $error = 'Passwords do not match.';
    } else {
        try {
            $hash = password_hash($pass, PASSWORD_ARGON2ID);
            db()->prepare('INSERT INTO users(email,password_hash) VALUES(?,?)')->execute([$email, $hash]);
            $uid = (int)db()->lastInsertId();
            $token = bin2hex(random_bytes(32));
            db()->prepare('INSERT INTO sessions(id,user_id,expires_at) VALUES(?,?,DATE_ADD(NOW(), INTERVAL 30 DAY))')
                ->execute([hash('sha256', $token), $uid]);
            setcookie('aa_session', $token, [
                'expires' => time() + 60 * 60 * 24 * 30,
                'path' => '/',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            redirect('/account.php?welcome=1');
        } catch (PDOException $e) {
            $error = str_contains($e->getMessage(), 'Duplicate')
                ? 'This email is already registered. <a href="/login.php">Sign in</a>.'
                : 'Registration failed. Please try again.';
        }
    }
}
require __DIR__ . '/layout.php';
page_start('Sign up', 'Create your APIAdult account and get an API key.');
?>
<section class="wrap" style="max-width:420px">
  <h1 class="h2">Create account</h1>
  <?php if ($error): ?><p class="mut" style="color:#ff8b8b"><?= $error ?></p><?php endif; ?>
  <form method="post" class="card" style="display:grid;gap:12px;margin:18px 0">
    <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
    <label>Email<input type="email" name="email" required value="<?= h($email) ?>" autocomplete="email"></label>
    <label>Password<input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
    <label>Repeat password<input type="password" name="password2" required minlength="8" autocomplete="new-password"></label>
    <button class="btn primary" type="submit">Create account</button>
  </form>
  <p class="mut">Already have an account? <a href="/login.php">Sign in</a>.</p>
</section>
<?php page_end(); ?>
