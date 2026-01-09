<?php
require_once __DIR__ . '/partials/header.php';
$token = $_GET['token'] ?? '';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($csrf->validate($_POST['csrf'] ?? '')) {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $rows = $db->fetchAll('SELECT * FROM password_resets');
        $matched = null;
        foreach ($rows as $row) {
            if (password_verify($token, $row['token_hash'])) {
                $matched = $row;
                break;
            }
        }
        if ($matched) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $db->execute('UPDATE users SET password_hash = :hash WHERE id = :id', [':hash' => $hash, ':id' => $matched['user_id']]);
            $db->execute('DELETE FROM password_resets WHERE user_id = :id', [':id' => $matched['user_id']]);
            $message = 'Parola a fost actualizată.';
        } else {
            $message = 'Token invalid.';
        }
    }
}
?>
<section class="page-hero">
    <div class="container">
        <h1>Setează o parolă nouă</h1>
    </div>
</section>
<section class="section">
    <div class="container form-card">
        <?php if ($message): ?>
            <p class="success"><?= Utils::e($message) ?></p>
        <?php endif; ?>
        <form method="post" class="form">
            <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
            <input type="hidden" name="token" value="<?= Utils::e($token) ?>">
            <input type="password" name="password" placeholder="Parolă nouă" required>
            <button class="btn" type="submit">Actualizează</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
