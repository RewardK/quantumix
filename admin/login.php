<?php
require_once __DIR__ . '/../core/bootstrap.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($csrf->validate($_POST['csrf'] ?? '')) {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($auth->attempt($email, $password)) {
            Utils::redirect('/admin/dashboard.php');
        }
        $error = 'Date invalide.';
    } else {
        $error = 'Token invalid.';
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-login">
<div class="login-card">
    <h1>Admin Login</h1>
    <?php if ($error): ?>
        <p class="error"><?= Utils::e($error) ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Parolă" required>
        <button class="btn" type="submit">Autentificare</button>
    </form>
</div>
</body>
</html>
