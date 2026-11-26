<?php require __DIR__.'/../layout.php'; page_start('Get started with APIAdult', 'One endpoint for uncensored models: chat, image, video, voice.'); ?>
<div class="docs">
  <aside>
    <b style="color:#fff">Documentation</b>
    <a href="#quickstart">Get started</a>
    <a href="#lifecycle">Task lifecycle</a>
    <a href="#reference">API Reference</a>
    <a href="#errors">Errors &amp; retries</a>
    <a href="#billing">Credits &amp; billing</a>
  </aside>
  <article>
    <h1>Get started with APIAdult</h1>
    <p>Uncensored models for <b>chat, image, video and voice</b> behind one OpenAI-style endpoint. Keys are server-side secrets — never ship them to a browser or an app.</p>

    <h2 id="quickstart">Quickstart</h2>
    <p>1. Get a key on the <a href="/keys.php">keys page</a>. 2. Submit your first task:</p>
<pre>export APIADULT_KEY="aal_live_..."

curl https://apiadult.online/v1/images \
  -H "Authorization: Bearer $APIADULT_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "model": "z-image-pro",
    "prompt": "cinematic portrait, night city",
    "width": 1024,
    "height": 1024
  }'</pre>
    <p>The API returns a task envelope:</p>
<pre>{
  "ok": true,
  "task_id": "tsk_01J...",
  "status": "queued"
}</pre>

    <h2 id="lifecycle">Task lifecycle</h2>
    <p>Generation is asynchronous. Create a task, then poll until a terminal status:</p>
<pre># poll status
curl https://apiadult.online/v1/tasks/tsk_01J... \
  -H "Authorization: Bearer $APIADULT_KEY"</pre>
    <p>Statuses: <code class="inline">queued → processing → done | failed | cancelled | expired</code>.
    On <code class="inline">done</code> the payload carries a local <code class="inline">result_url</code> mirrored on this CDN — provider URLs are temporary, the mirror is permanent. On <code class="inline">failed</code> the task is refunded in full and you can retry for free.</p>

    <h2 id="reference">API Reference</h2>
    <table class="tbl">
      <tr><th>Endpoint</th><th>Purpose</th></tr>
      <tr><td><code class="inline">GET /v1/models</code></td><td>List available models and live pricing</td></tr>
      <tr><td><code class="inline">POST /v1/&lt;model&gt;</code></td><td>Submit a generation task (model-specific endpoint)</td></tr>
      <tr><td><code class="inline">POST /v1/tasks</code></td><td>Submit a task with an explicit model + input</td></tr>
      <tr><td><code class="inline">POST /v1/uploads</code></td><td>Multipart image upload → public URL usable as task input</td></tr>
      <tr><td><code class="inline">GET /v1/tasks/&lt;id&gt;</code></td><td>Poll task status and result</td></tr>
      <tr><td><code class="inline">DELETE /v1/tasks/&lt;id&gt;</code></td><td>Cancel a task</td></tr>
      <tr><td><code class="inline">GET /v1/balance</code></td><td>Credits remaining</td></tr>
    </table>
    <p>All endpoints require <code class="inline">Authorization: Bearer &lt;key&gt;</code>. Send <code class="inline">Idempotency-Key</code> on task creation to make retries safe.</p>

    <h2 id="errors">Errors &amp; retries</h2>
<pre>{
  "error": {
    "type": "rate_limit_exceeded",
    "code": 429,
    "message": "Slow down: 60 tasks/min per key."
  }
}</pre>
    <p>Retry safely: 429 and 5xx with exponential backoff and jitter; keep request bodies identical and reuse the same <code class="inline">Idempotency-Key</code>. 4xx do not warrant a retry.</p>

    <h2 id="billing">Credits &amp; billing</h2>
    <p>1,000 credits = $1. Credit cost of each model is published on <a href="/pricing.php">pricing</a>. Balance and spend history are in your <a href="/account.php">dashboard</a>. Failed tasks are refunded automatically once — no duplicate refunds for retried tasks with the same idempotency key.</p>

    <h2>Content policy</h2>
    <p>Adults only (18+). Illegal content, minors, real people's non-consensual imagery are prohibited and permanently banned. See <a href="/legal/terms.php">Terms</a>.</p>
  </article>
</div>
<?php page_end();
