<?php
require_once __DIR__ . '/partials/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $csrf->validate($_POST['csrf'] ?? '')) {
    $email = trim($_POST['email'] ?? '');
    if ($email) {
        $db->execute('INSERT INTO newsletter_subscribers (email, created_at) VALUES (:email, NOW())', [':email' => $email]);
        $message = 'Abonat adăugat.';
    }
}
$subscribers = $db->fetchAll('SELECT * FROM newsletter_subscribers ORDER BY created_at DESC');
?>
<section class="admin-section">
    <h2>Newsletter</h2>
    <?php if ($message): ?><p class="success"><?= Utils::e($message) ?></p><?php endif; ?>
    <form method="post" class="form-inline">
        <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
        <input type="email" name="email" placeholder="Email" required>
        <button class="btn" type="submit">Adaugă</button>
    </form>
    <table class="admin-table">
        <thead><tr><th>Email</th><th>Data</th></tr></thead>
        <tbody>
            <?php foreach ($subscribers as $subscriber): ?>
                <tr>
                    <td><?= Utils::e($subscriber['email']) ?></td>
                    <td><?= Utils::e($subscriber['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
