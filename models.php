<?php require __DIR__.'/layout.php';
require_once __DIR__.'/models_data.php';
$cat = trim((string)($_GET['cat'] ?? ''));
$models = aasite_models();
if ($cat && !in_array($cat, aasite_cats(), true)) $cat = '';
$shown = $cat ? array_values(array_filter($models, fn($m) => $m['cat'] === $cat)) : $models;
$counts = [];
foreach ($models as $m) $counts[$m['cat']] = ($counts[$m['cat']] ?? 0) + 1;
page_start('Every uncensored AI model. One API.', 'Catalog of uncensored models: chat, image, image editing, face swap, video and speech.');
?>
<section class="wrap">
  <h1 class="h2">Every uncensored AI model. One API.</h1>
  <p class="mut" style="margin:-8px 0 20px">
    <a href="/models.php" <?= $cat===''?'style="color:#fff"':'' ?>>All <?= count($models) ?></a>
    <?php foreach (aasite_cats() as $c): ?>
      &nbsp;·&nbsp; <a href="/models.php?cat=<?= urlencode($c) ?>" <?= $cat===$c?'style="color:#fff"':'' ?>><?= $c ?> <?= $counts[$c] ?></a>
    <?php endforeach; ?>
  </p>
  <div class="grid">
    <?php foreach ($shown as $m): ?>
    <div class="card">
      <?php if ($m['badge']): ?><span class="badge <?= $m['badge']==='Borderline'?'b2':'' ?>"><?= htmlspecialchars($m['badge']) ?></span><?php endif; ?>
      <h3><?= htmlspecialchars($m['name']) ?></h3>
      <p><?= htmlspecialchars($m['desc']) ?></p>
      <div class="price"><?= htmlspecialchars($m['price']) ?></div>
      <div class="prov">by <?= htmlspecialchars($m['prov']) ?></div>
      <?php $slug = strtolower(preg_replace('/[^a-z0-9]+/i','-',preg_replace('/^Z-Image Spicy Pro$/i','z-image-spicy-pro',preg_replace('/^Wan 3.0 Spicy$/i','w3.0-spicy',preg_replace('/^MiniMax H3 Spicy$/i','minimax-h3-spicy',$m['name']))))); ?>
      <?php if (in_array($slug, ['w3.0-spicy','z-image-spicy-pro','minimax-h3-spicy'], true)): ?>
        <a class="more" href="/model/<?= $slug ?>">Details & samples →</a>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php page_end();
