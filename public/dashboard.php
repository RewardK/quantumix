<?php
require_once __DIR__ . '/partials/header.php';
if (!$auth->check()) {
    Utils::redirect('/login.php');
}
$user = $auth->user();
$projects = $db->fetchAll('SELECT * FROM projects ORDER BY created_at DESC LIMIT 5');
?>
<section class="page-hero">
    <div class="container">
        <h1>Bun venit, <?= Utils::e($user['name']) ?></h1>
        <p>Panoul tău de client Quantumix.</p>
        <a class="btn-outline" href="/logout.php">Logout</a>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2>Proiecte recente</h2>
        <div class="grid-3">
            <?php foreach ($projects as $project): ?>
                <div class="card">
                    <h3><?= Utils::e($project['name_ro']) ?></h3>
                    <p><?= Utils::e(substr($project['description_ro'], 0, 100)) ?>...</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
