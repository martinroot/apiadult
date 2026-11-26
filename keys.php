<?php
require __DIR__ . '/layout.php';
page_start('Get your API key', 'Sign up and create a key in your dashboard.');
?>
<section class="wrap" style="max-width:560px">
  <h1 class="h2">Get your API key</h1>
  <p class="mut">Create an account, sign in, then generate a key in your dashboard — no waiting, no manual requests.</p>
  <div class="card" style="margin:20px 0">
    <p><a class="btn primary" href="/register.php">Create account</a> <a class="btn" href="/login.php">Sign in</a></p>
    <p class="mut">Already signed in? Open your <a href="/account.php">dashboard</a> to create and manage keys.</p>
  </div>
  <p class="mut">1000 credits = $1 · pay as you go · failed tasks refunded in full.</p>
</section>
<?php page_end();
