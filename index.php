<?php require __DIR__.'/layout.php';
require_once __DIR__.'/models_data.php';

$catalog = [
 ['Wan 3.0 Spicy','Unrestricted text / keyframe / reference video, up to 30s, audio built-in','from $0.075 / sec',['type'=>'video','src'=>'/media/prev/w30_14.mp4','poster'=>'/media/prev/w30_14.jpg'],'w3.0-spicy'],
 ['Seedance 2.5','Flagship video — 4–30s with synced audio','from $0.2056 / sec',null,null],
 ['MiniMax H3 Spicy','Uncensored 5–15s clips, generated audio included','from $0.02 / sec',['type'=>'video','src'=>'/media/prev/minimax_11.mp4','poster'=>'/media/prev/minimax_11.jpg'],'minimax-h3-spicy'],
 ['Berry 1.0','Unrestricted 2K/4K masters, 2–30s','from $0.075 / sec',null,null],
 ['Z-Image Spicy Pro','Text-to-image up to 2560px, byte-exact seeding','$0.03 / image',['type'=>'image','src'=>'/media/zimage/02.jpg'],'z-image-spicy-pro'],
 ['Z-Image Spicy','Uncensored text-to-image','$0.026 / image',null,null],
 ['Seedream 5.0 Pro','Top-tier uncensored image generation & editing','$0.12 / image',null,null],
 ['Seedream 5.0 Lite','Fast uncensored image generation & editing','$0.06 / image',null,null],
 ['Qwen Image Edit','Prompt-based image editing','$0.08 / image',null,null],
 ['Face Swap Spicy','One-call face swap','$0.026 / image',null,null],
 ['Head Swap','Whole-head replacement from two images','$0.02 / image',null,null],
 ['Siren 1.0','Expressive speech — breath, pauses and tone','$0.04 / min',null,null],
 ['Silly 1.0 Lite','Budget character chat with image understanding','from $0.30 / 1M tok',null,null],
 ['Silly 2.0','Premium roleplay chat on GLM-5.3 base','from $9.00 / 1M tok',null,null],
 ['Qwen 3.8 27B','Uncensored chat with reasoning','from $0.80 / 1M tok',null,null],
 ['Wan Animate','Reference-driven motion transfer','from $0.0795 / sec',null,null],
 ['Lime 1.0','Image-to-video with native audio','from $0.045 / sec',null,null],
 ['Wan 2.2','Lighter Wan for high-volume jobs','from $0.08 / sec',null,null],
 ['Seedance 2.0 Fast','Previous-gen, tuned for speed','from $0.053 / sec',null,null],
 ['Seedance 2.0 Mini','Lowest cost per second','from $0.03 / sec',null,null],
];

$showcase = [];
// все спарсенное медиа в карусель: клипы (превью+постер) и стиллы
foreach (['10','11','12','13','14','15','16','17','18'] as $n) {
    $showcase[] = ['type'=>'video','src'=>"/media/prev/w30_$n.mp4",'poster'=>"/media/prev/w30_$n.jpg",'tag'=>'Wan 3.0'];
}
foreach (['01','02','03','04','05','06','07','08','09'] as $n) {
    $showcase[] = ['type'=>'image','src'=>"/media/w30/$n.jpg",'tag'=>'Wan 3.0'];
}
foreach (['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20'] as $n) {
    if (file_exists("/var/www/apiadult.online/media/zimage/$n.jpg"))
        $showcase[] = ['type'=>'image','src'=>"/media/zimage/$n.jpg",'tag'=>'Z-Image Pro'];
}
foreach (['09','10','11','12','13','14','15','16'] as $n) {
    $showcase[] = ['type'=>'video','src'=>"/media/prev/minimax_$n.mp4",'poster'=>"/media/prev/minimax_$n.jpg",'tag'=>'MiniMax H3'];
}
foreach (['01','02','03','04','05','06','07','08'] as $n) {
    $showcase[] = ['type'=>'image','src'=>"/media/minimax/$n.jpg",'tag'=>'MiniMax H3'];
}
page_start('Uncensored AI API — NSFW Chat, Image, Video & Voice', 'Production-grade uncensored AI models for image, video, voice and chat through one developer-first endpoint.');
?>
<section class="hero">
  <h1>Uncensored AI Models.<br><em>One API.</em></h1>
  <p class="sub">Plug into production-grade uncensored models for image, video, voice and chat through one developer-first endpoint.</p>
  <div class="actions">
    <a class="btn primary" href="/keys.php">Get API key &rarr;</a>
    <a class="btn ghost" href="/models.php">Explore models</a>
  </div>

  <div class="sh-wrap">
    <button class="sh-arrow left" type="button" aria-label="Scroll left">&#8592;</button>
    <div class="showcase" id="showcase">
    <?php foreach ($showcase as $s2): ?>
      <figure class="sh-item">
        <?php if ($s2['type']==='video'): ?>
          <video src="<?= $s2['src'] ?>" poster="<?= $s2['poster'] ?>" muted loop playsinline preload="none" data-autoplay></video>
        <?php else: ?>
          <img src="<?= $s2['src'] ?>" alt="" loading="lazy">
        <?php endif; ?>
        <figcaption><?= $s2['tag'] ?></figcaption>
      </figure>
    <?php endforeach; ?>
  </div>
    <button class="sh-arrow right" type="button" aria-label="Scroll right">&#8594;</button>
  </div>
</section>

<section class="wrap">
  <h2 class="h2">Models</h2>
  <div class="catgrid">
    <?php foreach ($catalog as [$name,$desc,$price,$media,$slug]): ?>
      <div class="catcard">
        <div class="catthumb">
          <?php if ($media && $media['type']==='video'): ?>
            <video src="<?= $media['src'] ?>" poster="<?= $media['poster'] ?? '' ?>" muted loop playsinline preload="none" data-autoplay></video>
          <?php elseif ($media): ?>
            <img src="<?= $media['src'] ?>" alt="" loading="lazy">
          <?php else: ?>
            <div class="noimg"><span><?= strtok($name, ' ') ?></span></div>
          <?php endif; ?>
        </div>
        <div class="catmeta">
          <h3><?= htmlspecialchars($name) ?></h3>
          <p><?= htmlspecialchars($desc) ?></p>
          <div class="catrow"><span class="price"><?= htmlspecialchars($price) ?></span>
          <?php if ($slug): ?><a class="more" href="/model/<?= $slug ?>">samples &rarr;</a><?php endif; ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <p style="margin-top:18px"><a class="btn ghost" href="/models.php">All models &rarr;</a></p>
</section>

<section class="wrap">
  <div class="h2">Simple, transparent pricing</div>
  <div class="tiers">
    <div class="tier">
      <h3>Pay As You Go</h3>
      <p class="mut">Only pay for what you use. Auto top-up from $10.</p>
      <ul>
        <li>1,000 credits = $1</li>
        <li>Automatic top-ups when balance runs low</li>
        <li>No commitment — disable anytime</li>
      </ul>
      <p style="margin-top:16px"><a class="btn primary" href="/keys.php">Get started</a></p>
    </div>
    <div class="tier pop">
      <div class="pop-tag">MOST POPULAR</div>
      <h3>Volume</h3>
      <p class="mut">Bonus credits on larger top-ups, invoicing, higher limits.</p>
      <ul>
        <li>Everything in Pay As You Go</li>
        <li>Bonus credits on larger top-ups</li>
        <li>Invoicing and committed-use terms</li>
        <li>Higher rate limits &middot; priority support</li>
      </ul>
      <p style="margin-top:16px"><a class="btn ghost" href="https://t.me/+apiadult">Contact sales</a></p>
    </div>
  </div>
  <p class="mut">Prices in USD. Failed tasks are refunded in full — every retry is free.</p>
</section>

<section class="wrap">
  <div class="h2">Start in one request</div>
<pre>curl https://apiadult.online/v1/images \
  -H "Authorization: Bearer ***" \
  -H "Content-Type: application/json" \
  -d '{"model":"z-image-pro","prompt":"...","width":1024,"height":1024}'</pre>
  <p class="mut">Asynchronous task lifecycle: submit &rarr; poll &rarr; download. Read the <a href="/docs/">docs</a>.</p>
</section>

<script>
(function(){
  var wrap = document.getElementById('showcase');
  var step = 200;
  document.querySelectorAll('.sh-arrow').forEach(function(btn){
    btn.addEventListener('click', function(){
      wrap.scrollBy({left: btn.classList.contains('left') ? -step : step, behavior: 'smooth'});
    });
  });
})();

(function(){
  var vs = document.querySelectorAll('video[data-autoplay]');
  if (!('IntersectionObserver' in window)) return;
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      var v = e.target;
      if (e.isIntersecting) { v.play().catch(function(){}); }
      else { v.pause(); }
    });
  }, {threshold: 0.25});
  vs.forEach(function(v){ io.observe(v); });
})();
</script>
<?php page_end();
