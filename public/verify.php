<?php
require_once __DIR__ . '/partials/header.php';
$token = $_GET['token'] ?? '';
$message = 'Token invalid.';
if ($token) {
    $row = $db->fetch('SELECT * FROM email_verifications');
    if ($row && hash_equals($row['token'], $token)) {
        $db->execute('UPDATE users SET email_verified_at = NOW() WHERE id = :id', [':id' => $row['user_id']]);
        $db->execute('DELETE FROM email_verifications WHERE user_id = :id', [':id' => $row['user_id']]);
        $message = 'Email confirmat.';
    }
}
?>
<section class="page-hero">
    <div class="container">
        <h1>Confirmare email</h1>
        <p><?= Utils::e($message) ?></p>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
