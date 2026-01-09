<?php
require_once __DIR__ . '/partials/header.php';
$logs = $db->fetchAll('SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT 100');
?>
<section class="admin-section">
    <h2>Audit actions</h2>
    <table class="admin-table">
        <thead><tr><th>User</th><th>Acțiune</th><th>Detalii</th><th>Data</th></tr></thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= Utils::e($log['user_id']) ?></td>
                    <td><?= Utils::e($log['action']) ?></td>
                    <td><?= Utils::e($log['details']) ?></td>
                    <td><?= Utils::e($log['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
