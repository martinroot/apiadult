<?php
declare(strict_types=1);
require __DIR__ . '/app.php';
$u = require_user();

$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    if ($action === 'create_key') {
        $name = trim($_POST['name'] ?? 'default');
        $name = mb_substr($name, 0, 80) ?: 'default';
        $r = issue_key((int)$u['id'], $name);
        $notice = '<div class="card" style="border-color:#4caf50"><b>New key created</b><br><code class="inline" style="word-break:break-all">' . h($r['key']) . '</code><br><span class="mut">Shown once — copy it now.</span></div>';
    } elseif ($action === 'revoke_key') {
        $id = (int)($_POST['id'] ?? 0);
        db()->prepare('UPDATE api_keys SET revoked_at=NOW() WHERE id=? AND user_id=?')->execute([$id, $u['id']]);
        $notice = '<p class="mut">Key revoked.</p>';
    }
}
$keys = db()->prepare('SELECT id,name,prefix,last_used_at,revoked_at,created_at FROM api_keys WHERE user_id=? ORDER BY id DESC');
$keys->execute([$u['id']]);
$keys = $keys->fetchAll();
$tasks = db()->prepare('SELECT task_id,model,status,cost_cents,created_at FROM tasks WHERE user_id=? ORDER BY id DESC LIMIT 20');
$tasks->execute([$u['id']]);
$tasks = $tasks->fetchAll();
$spend = db()->prepare('SELECT COALESCE(SUM(delta_cents),0) FROM credit_ledger WHERE user_id=?');
$spend->execute([$u['id']]);
$spent = (int)$spend->fetchColumn();

require __DIR__ . '/layout.php';
page_start('Dashboard', 'Manage your API keys and tasks.');
?>
<section class="wrap">
  <h1 class="h2">Dashboard</h1>
  <p class="mut">Signed in as <b><?= h($u['email']) ?></b> · <a href="/logout.php">Sign out</a></p>
  <?php if (isset($_GET['welcome'])): ?><p class="mut">Welcome! Create your first API key below.</p><?php endif; ?>
  <?= $notice ?>

  <h2 class="h3" style="margin-top:24px">API keys</h2>
  <form method="post" style="display:flex;gap:8px;margin:12px 0">
    <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
    <input type="hidden" name="action" value="create_key">
    <input name="name" placeholder="Key name" maxlength="80" value="default">
    <button class="btn primary" type="submit">Create key</button>
  </form>
  <?php if (!$keys): ?><p class="mut">No keys yet.</p><?php else: ?>
  <div class="card">
    <?php foreach ($keys as $k): ?>
      <div style="display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px solid #ffffff14">
        <div><code class="inline"><?= h($k['prefix']) ?>…</code> <span class="mut"><?= h($k['name']) ?></span>
          <div class="mut" style="font-size:.85em">created <?= h($k['created_at']) ?><?= $k['last_used_at'] ? ' · last used ' . h($k['last_used_at']) : '' ?><?= $k['revoked_at'] ? ' · <b>revoked</b>' : '' ?></div>
        </div>
        <?php if (!$k['revoked_at']): ?>
        <form method="post"><input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
          <input type="hidden" name="action" value="revoke_key"><input type="hidden" name="id" value="<?= (int)$k['id'] ?>">
          <button class="btn" type="submit">Revoke</button></form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <h2 class="h3" style="margin-top:24px">Usage</h2>
  <p class="mut">Credits balance: <b><?= (int)$u['credits'] ?></b> · spent: <b><?= $spent ?></b> credits</p>
  <?php if (!$tasks): ?><p class="mut">No tasks yet.</p><?php else: ?>
  <div class="card">
    <?php foreach ($tasks as $t): ?>
      <div style="padding:6px 0"><code class="inline"><?= h($t['task_id']) ?></code> · <?= h($t['model']) ?> · <b><?= h($t['status']) ?></b> · <?= (int)$t['cost_cents'] ?> cr · <?= h($t['created_at']) ?></div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
  <p class="mut" style="margin-top:16px">Docs: <a href="/docs/">quickstart</a> · <a href="/pricing.php">pricing</a></p>
</section>
<?php page_end(); ?>
