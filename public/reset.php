<?php
require_once __DIR__ . '/partials/header.php';
$info = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($csrf->validate($_POST['csrf'] ?? '')) {
        $email = trim($_POST['email'] ?? '');
        $user = $db->fetch('SELECT * FROM users WHERE email = :email', [':email' => $email]);
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $hash = password_hash($token, PASSWORD_DEFAULT);
            $db->execute('DELETE FROM password_resets WHERE user_id = :user_id', [':user_id' => $user['id']]);
            $db->execute(
                'INSERT INTO password_resets (user_id, token_hash, created_at) VALUES (:user_id, :token_hash, NOW())',
                [':user_id' => $user['id'], ':token_hash' => $hash]
            );
            $resetLink = Utils::baseUrl($config) . '/reset_confirm.php?token=' . $token;
            Mailer::send($email, 'Resetare parolă Quantumix', 'Accesează linkul: ' . $resetLink, $config['mail']['from']);
        }
        $info = 'Dacă adresa există, vei primi un email cu instrucțiuni.';
    }
}
?>
<section class="page-hero">
    <div class="container">
        <h1>Resetare parolă</h1>
    </div>
</section>
<section class="section">
    <div class="container form-card">
        <?php if ($info): ?>
            <p class="success"><?= Utils::e($info) ?></p>
        <?php endif; ?>
        <form method="post" class="form">
            <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
            <input type="email" name="email" placeholder="Email" required>
            <button class="btn" type="submit">Trimite link</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
