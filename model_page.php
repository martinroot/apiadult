<?php
declare(strict_types=1);
require_once __DIR__.'/layout.php';
require_once __DIR__.'/models_hub.php';

$slug = (string)($_GET['slug'] ?? '');
$hub = models_hub();
if (!isset($hub[$slug])) { http_response_code(404); echo '404'; exit; }
$m = $hub[$slug];
page_start($m['name'], $m['desc']);
?>

<section class="mhero">
  <div class="mhero-txt">
    <?php if ($m['badge']): ?><span class="badge"><?= htmlspecialchars($m['badge']) ?></span><?php endif; ?>
    <h1><?= htmlspecialchars($m['name']) ?></h1>
    <p class="mut prov">by <?= htmlspecialchars($m['prov']) ?> · <?= htmlspecialchars($m['cat']) ?></p>
    <p class="tagline"><?= htmlspecialchars($m['tagline']) ?></p>
    <div class="actions" style="justify-content:flex-start">
      <a class="btn primary" href="/keys.php">Try <?= strtok($m['name'],' ') ?> →</a>
      <a class="btn ghost" href="/models.php">All models</a>
    </div>
    <p class="mprice"><?= htmlspecialchars($m['price']) ?></p>
  </div>
  <div class="mhero-media <?= $m['hero']['type']==='video' ? 'vid' : '' ?>">
    <?php if ($m['hero']['type']==='video'): ?>
      <video src="<?= $m['hero']['src'] ?>" autoplay muted loop playsinline></video>
    <?php else: ?>
      <img src="<?= $m['hero']['src'] ?>" alt="<?= htmlspecialchars($m['name']) ?>">
    <?php endif; ?>
  </div>
</section>

<section class="wrap">
  <p class="mdesc"><?= htmlspecialchars($m['desc']) ?></p>

  <h2 class="h2" style="margin-top:30px">Six numbers that matter</h2>
  <div class="stats">
    <?php foreach ($m['stats'] as [$big,$label,$txt]): ?>
      <div class="stat"><div class="stat-big"><?= htmlspecialchars($big) ?></div>
        <div class="stat-lbl"><?= htmlspecialchars($label) ?></div>
        <div class="stat-txt"><?= htmlspecialchars($txt) ?></div></div>
    <?php endforeach; ?>
  </div>
</section>

<?php foreach ($m['features'] as $f): ?>
<section class="feat <?= $f['media']['type']==='video'?'feat-vid':'' ?>">
  <div class="feat-txt">
    <h3><?= htmlspecialchars($f['title']) ?></h3>
    <p><?= htmlspecialchars($f['desc']) ?></p>
  </div>
  <div class="feat-media">
    <?php if ($f['media']['type']==='video'): ?>
      <video src="<?= $f['media']['src'] ?>" autoplay muted loop playsinline></video>
    <?php else: ?>
      <img src="<?= $f['media']['src'] ?>" alt="" loading="lazy">
    <?php endif; ?>
  </div>
</section>
<?php endforeach; ?>

<section class="wrap">
  <h2 class="h2">Built for</h2>
  <div class="grid">
    <?php foreach ($m['usecases'] as [$t,$d]): ?>
      <div class="card"><h3><?= htmlspecialchars($t) ?></h3><p><?= htmlspecialchars($d) ?></p></div>
    <?php endforeach; ?>
  </div>

  <h2 class="h2" style="margin-top:36px">How to generate</h2>
  <p class="mut"><?= htmlspecialchars($m['howto']) ?></p>
<pre><?= htmlspecialchars($m['code']) ?></pre>

  <h2 class="h2" style="margin-top:36px">Samples</h2>
  <div class="gal">
    <?php foreach ($m['gallery'] as $g): ?>
      <?php if ($g['type']==='video'): ?>
        <video src="<?= $g['src'] ?>" muted loop playsinline preload="metadata"></video>
      <?php else: ?>
        <img src="<?= $g['src'] ?>" alt="" loading="lazy">
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <div class="cta-band">
    <div><b><?= htmlspecialchars($m['name']) ?></b><span class="mut"> — <?= htmlspecialchars($m['price']) ?></span></div>
    <a class="btn primary" href="/keys.php">Start generating</a>
  </div>
</section>
<?php page_end();
