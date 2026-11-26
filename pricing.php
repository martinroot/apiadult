<?php require __DIR__.'/layout.php';
page_start('API Pricing — Pay-Per-Use Credits', 'Same list price for every account. Failed tasks are refunded in full.');
?>
<section class="wrap">
  <h1 class="h2">Simple pricing, precise framing</h1>
  <p class="mut" style="margin-top:-6px">1000 credits = $1. Pay only for what you use, or top up in volume for bonus credits.</p>

  <div class="tiers" style="margin-top:24px">
    <div class="tier">
      <h3>Pay As You Go</h3>
      <ul>
        <li>Usage-based · auto top-ups from $10</li>
        <li>1,000 credits = $1</li>
        <li>Choose your own top-up amount</li>
        <li>No commitment — change or disable anytime</li>
      </ul>
      <p style="margin-top:16px"><a class="btn primary" href="/keys.php">Get started</a></p>
    </div>
    <div class="tier pop">
      <div class="pop-tag">MOST POPULAR</div>
      <h3>Volume</h3>
      <ul>
        <li>Bonus credits on larger top-ups</li>
        <li>Invoicing and committed-use terms</li>
        <li>Higher rate limits · priority support</li>
      </ul>
      <p style="margin-top:16px"><a class="btn ghost" href="https://t.me/+apiadult">Contact sales</a></p>
    </div>
  </div>

  <h2 class="h2">Video generation — per second</h2>
  <table class="tbl">
    <tr><th>Model</th><th>480p</th><th>720p</th><th>768p</th><th>1080p</th><th>2K</th><th>4K</th><th>Min / task</th></tr>
    <tr><td>Wan 2.7</td><td class="num">—</td><td class="num">$0.26</td><td class="num">—</td><td class="num">$0.40</td><td class="num">—</td><td class="num">—</td><td class="num">$0.52</td></tr>
    <tr><td>Wan 2.2</td><td class="num">$0.08</td><td class="num">$0.16</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.40</td></tr>
    <tr><td>Seedance 2.0</td><td class="num">$0.14</td><td class="num">$0.304</td><td class="num">—</td><td class="num">$0.748</td><td class="num">—</td><td class="num">—</td><td class="num">$0.56</td></tr>
    <tr><td>Seedance 2.0 Fast</td><td class="num">$0.112 → <b>$0.053</b></td><td class="num">$0.24 → <b>$0.113</b></td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.448 → <b>$0.212</b></td></tr>
    <tr><td>Seedance 2.0 Mini</td><td class="num">$0.08 → <b>$0.03</b></td><td class="num">$0.16 → <b>$0.06</b></td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.32 → <b>$0.12</b></td></tr>
    <tr><td>Seedance 2.5</td><td class="num">$0.2056</td><td class="num">$0.4624</td><td class="num">—</td><td class="num">$1.1372</td><td class="num">—</td><td class="num">—</td><td class="num">$0.823</td></tr>
    <tr><td>MiniMax H3</td><td class="num">$0.08 → <b>$0.02</b></td><td class="num">—</td><td class="num">$0.12 → <b>$0.03</b></td><td class="num">$0.16 → <b>$0.04</b></td><td class="num">$0.05 → <b>$0.10</b>*</td><td class="num">—</td><td class="num">$0.40 → <b>$0.10</b></td></tr>
    <tr><td>Berry 1.0</td><td class="num">$0.10 → <b>$0.075</b></td><td class="num">$0.20 → <b>$0.15</b></td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.40 → <b>$0.30</b></td><td class="num">$0.20 → <b>$0.15</b></td></tr>
    <tr><td>Berry 1.0 Turbo</td><td class="num">$0.136 → <b>$0.102</b></td><td class="num">$0.28 → <b>$0.21</b></td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.56 → <b>$0.42</b></td><td class="num">$0.272 → <b>$0.204</b></td></tr>
    <tr><td>Berry 1.0 Pro</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.36 → <b>$0.27</b></td><td class="num">$0.40 → <b>$0.30</b></td><td class="num">$0.46 → <b>$0.345</b></td><td class="num">$0.72 → <b>$0.54</b></td></tr>
    <tr><td>Berry 1.0 Pro Turbo</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.52 → <b>$0.39</b></td><td class="num">$0.56 → <b>$0.42</b></td><td class="num">$0.62 → <b>$0.465</b></td><td class="num">$1.04 → <b>$0.78</b></td></tr>
    <tr><td>Wan 3.0</td><td class="num">—</td><td class="num">$0.075</td><td class="num">—</td><td class="num">$0.15</td><td class="num">—</td><td class="num">—</td><td class="num">$0.15</td></tr>
    <tr><td>Wan 3.0 Pro</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.27</td><td class="num">$0.30</td><td class="num">$0.345</td><td class="num">$0.54</td></tr>
    <tr><td>Wan 3.0 Prime</td><td class="num">$0.102</td><td class="num">$0.21</td><td class="num">—</td><td class="num">$0.42</td><td class="num">—</td><td class="num">—</td><td class="num">$0.204</td></tr>
    <tr><td>Wan 3.0 Prime Pro</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.39</td><td class="num">$0.42</td><td class="num">$0.465</td><td class="num">$0.78</td></tr>
    <tr><td>Lime 1.0</td><td class="num">$0.045</td><td class="num">$0.06</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.225</td></tr>
    <tr><td>Wan Animate</td><td class="num">$0.0795</td><td class="num">$0.165</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">—</td><td class="num">$0.08</td></tr>
  </table>
  <p class="mut" style="font-size:12.5px">«list → pay» — действующая скидка от прайса. * — сверяйте точную сетку MiniMax H3 в спецификации модели.</p>

  <h2 class="h2">Images &amp; flat-rate</h2>
  <table class="tbl">
    <tr><th>Model</th><th>Unit</th><th>Price</th></tr>
    <tr><td>Z-Image Pro Spicy</td><td>per image</td><td class="num">$0.03</td></tr>
    <tr><td>Z-Image Spicy</td><td>per image</td><td class="num">$0.026</td></tr>
    <tr><td>Seedream 5.0 Pro Spicy</td><td>per image (gen &amp; edit)</td><td class="num">$0.12 (list $0.18)</td></tr>
    <tr><td>Seedream 5.0 Lite Spicy</td><td>per image (gen &amp; edit)</td><td class="num">$0.06 (list $0.07)</td></tr>
    <tr><td>Qwen Image Edit Spicy</td><td>per image</td><td class="num">$0.08</td></tr>
    <tr><td>Face Swap Spicy</td><td>per image</td><td class="num">$0.026</td></tr>
    <tr><td>Head Swap</td><td>per image</td><td class="num">$0.02</td></tr>
    <tr><td>Siren 1.0 Spicy</td><td>per audio minute</td><td class="num">$0.04</td></tr>
  </table>

  <h2 class="h2">Chat — per 1M tokens</h2>
  <table class="tbl">
    <tr><th>Model</th><th>Price</th></tr>
    <tr><td>Silly 1.0 Lite</td><td class="num">from $0.30</td></tr>
    <tr><td>Qwen 3.8 27B Spicy</td><td class="num">from $0.80</td></tr>
    <tr><td>Silly 2.0 (GLM-5.3 base)</td><td class="num">from $9.00</td></tr>
  </table>
  <p class="mut">Same list price for every account — no negotiated per-model rates. Failed tasks are refunded in full.</p>
</section>
<?php page_end();
