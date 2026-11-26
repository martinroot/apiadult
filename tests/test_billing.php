<?php
declare(strict_types=1);
require __DIR__ . '/harness.php';

t('aa_charge is idempotent per ref', function () {
    $u = make_user(['credits' => 0]);
    aa_charge($u['id'], -130, 'task', 'task_a');
    aa_charge($u['id'], -130, 'task', 'task_a');
    $row = db()->prepare('SELECT credits FROM users WHERE id=?');
    $row->execute([$u['id']]);
    eq(-130, (int)$row->fetchColumn());
});

t('aa_mirror_task stores status and charges cost', function () {
    $u = make_user(['credits' => 1000]);
    $owner = ['id' => $u['id'], 'key_id' => null];
    db()->prepare('INSERT INTO tasks(user_id,task_id,model,status) VALUES(?,?,?,?)')
       ->execute([$u['id'], 'task_b', 'z-image-spicy', 'queued']);
    aa_mirror_task($owner, 'task_b', ['status' => 'succeeded', 'cost_micros' => 26000,
                                      'result' => ['url' => 'https://example/x.png']]);
    $row = db()->prepare('SELECT status,result_json FROM tasks WHERE user_id=? AND task_id=?');
    $row->execute([$u['id'], 'task_b']);
    $r = $row->fetch();
    eq('succeeded', $r['status']);
    ok(str_contains($r['result_json'], 'example/x.png'), 'result not mirrored');
    $b = db()->prepare('SELECT credits FROM users WHERE id=?');
    $b->execute([$u['id']]);
    eq(997, (int)$b->fetchColumn());       // 26000 micros = 3 credits
});
