<?php
require_once __DIR__ . '/partials/header.php';
$messages = $db->fetchAll('SELECT * FROM contact_messages ORDER BY created_at DESC');
?>
<section class="admin-section">
    <h2>Mesaje contact</h2>
    <table class="admin-table">
        <thead><tr><th>Nume</th><th>Email</th><th>Mesaj</th><th>Data</th></tr></thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?= Utils::e($message['name']) ?></td>
                    <td><?= Utils::e($message['email']) ?></td>
                    <td><?= Utils::e($message['message']) ?></td>
                    <td><?= Utils::e($message['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
