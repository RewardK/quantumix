<?php
require_once __DIR__ . '/partials/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($csrf->validate($_POST['csrf'] ?? '')) {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($auth->attempt($email, $password)) {
            Utils::redirect('/dashboard.php');
        }
        $error = 'Date de autentificare invalide.';
    } else {
        $error = 'Token invalid.';
    }
}
?>
<section class="page-hero">
    <div class="container">
        <h1>Autentificare</h1>
    </div>
</section>
<section class="section">
    <div class="container form-card">
        <?php if ($error): ?>
            <p class="error"><?= Utils::e($error) ?></p>
        <?php endif; ?>
        <form method="post" class="form">
            <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Parolă" required>
            <button class="btn" type="submit">Loghează-te</button>
        </form>
        <div class="form-links">
            <a href="/reset.php">Ai uitat parola?</a>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
