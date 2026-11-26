<?php
declare(strict_types=1);
require __DIR__ . '/app.php';
$u = require_user();
require __DIR__ . '/layout.php';
page_start('Playground', 'Generate images and video from the dashboard.');
?>
<section class="wrap">
  <h1 class="h2">Playground</h1>
  <p class="mut">Pick a model, describe what you want, and submit — the task appears in your dashboard.</p>
  <form id="pg" class="card" style="display:grid;gap:12px">
    <label>Model<select name="model" id="pg-model"></select></label>
    <label>Prompt<textarea name="prompt" id="pg-prompt" rows="4" required></textarea></label>
    <button class="btn primary" type="submit">Generate</button>
  </form>
  <pre id="pg-out" class="mut"></pre>
<script>
fetch('/v1/models').then(r=>r.json()).then(j=>{
  const s=document.getElementById('pg-model');
  (j.data||[]).forEach(m=>{const o=document.createElement('option');o.value=m.id;o.textContent=m.id+' ('+m.modal+')';s.appendChild(o)});
});
document.getElementById('pg').addEventListener('submit', async e=>{
  e.preventDefault();
  const out=document.getElementById('pg-out');
  out.textContent='Submitting…';
  const fd=new FormData(e.target);
  const r=await fetch('/playground_submit.php',{method:'POST',body:fd});
  const j=await r.json();
  out.textContent=JSON.stringify(j,null,2);
});
</script>
</section>
<?php page_end(); ?>
