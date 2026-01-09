<?php
require_once __DIR__ . '/partials/header.php';
$stats = [
    'users' => $db->fetch('SELECT COUNT(*) as total FROM users')['total'],
    'services' => $db->fetch('SELECT COUNT(*) as total FROM services')['total'],
    'projects' => $db->fetch('SELECT COUNT(*) as total FROM projects')['total'],
    'posts' => $db->fetch('SELECT COUNT(*) as total FROM posts')['total'],
    'messages' => $db->fetch('SELECT COUNT(*) as total FROM contact_messages')['total'],
];
?>
<section class="admin-section">
    <h2>Dashboard</h2>
    <div class="admin-grid">
        <?php foreach ($stats as $label => $value): ?>
            <div class="stat-card">
                <h3><?= Utils::e(ucfirst($label)) ?></h3>
                <p><?= Utils::e((string)$value) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
