<?php
// layout.php — общий каркас страниц apiadult.online
function page_start(string $title, string $desc = '', bool $toc = false): void {
    ?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= htmlspecialchars($title) ?> — APIAdult</title>
<?php if ($desc): ?><meta name="description" content="<?= htmlspecialchars($desc) ?>"><?php endif; ?>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/assets/style.css">
<script defer src="https://vibemetrics.click/tracker.js" data-site-id="apiadult-online" data-site-key="V1ieNx3t_9Gg9tCmM0B68bnP_d-B6RuVcAztVERvWGg"></script>
</head>
<body>
<header class="nav">
  <div class="nav-inner">
    <a class="brand" href="/"><span class="brand-mark">A</span>API<b>ADULT</b></a>
    <nav>
      <a href="/models.php" <?= basename($_SERVER['PHP_SELF'])==='models.php'?'class="act"':'' ?>>Models</a>
      <a href="/pricing.php" <?= basename($_SERVER['PHP_SELF'])==='pricing.php'?'class="act"':'' ?>>Pricing</a>
      <a href="/docs/" <?= strpos($_SERVER['REQUEST_URI'],'/docs')===0?'class="act"':'' ?>>Docs</a>
      <a href="https://t.me/+apiadult" target="_blank" rel="noopener">Telegram</a>
    </nav>
    <?php if (function_exists('current_user') && current_user()): ?>
      <a class="cta" href="/account.php">Dashboard</a>
    <?php else: ?>
      <a class="cta" href="/login.php">Sign in</a>
    <?php endif; ?>
  </div>
</header>
<main>
<?php
}
function page_end(): void {
?>
</main>
<footer>
  <div class="foot-inner">
    <div>
      <div class="brand"><span class="brand-mark">A</span>API<b>ADULT</b></div>
      <p class="mut">Uncensored AI models for adults. One API.<br>1000 credits = $1 · pay as you go.</p>
    </div>
    <div>
      <b>Product</b>
      <a href="/models.php">Models</a>
      <a href="/pricing.php">Pricing</a>
      <a href="/docs/">Documentation</a>
    </div>
    <div>
      <b>Developers</b>
      <a href="/docs/#quickstart">Quickstart</a>
      <a href="/docs/#reference">API Reference</a>
      <a href="/v1/models">Status / v1</a>
    </div>
    <div>
      <b>Legal</b>
      <a href="/legal/terms.php">Terms of Service</a>
      <a href="/legal/privacy.php">Privacy Policy</a>
    </div>
  </div>
  <div class="foot-copy mut">© <?= date('Y') ?> apiadult.online · Adults only (18+)</div>
</footer>
</body>
</html>
<?php
}
