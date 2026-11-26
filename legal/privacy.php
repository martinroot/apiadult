<?php require __DIR__.'/../layout.php'; page_start('Privacy Policy'); ?>
<section class="wrap" style="max-width:760px">
  <h1 class="h2">Privacy Policy</h1>
  <p class="mut">Effective: <?= date('Y-m-d') ?></p>
  <p>We store: account email, API key hashes (never plaintext), request logs (timestamps, endpoint, task id, credits spent) and user prompts only for abuse investigation and refund processing.</p>
  <p>We do not sell data. Prompts and generations are never used for advertising. Requests are routed to upstream model providers strictly to fulfil the task.</p>
  <p>Data deletion requests: support via Telegram. Logs older than 180 days are purged automatically.</p>
</section>
<?php page_end();
