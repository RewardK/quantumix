<?php
require_once __DIR__ . '/partials/header.php';
$auth->requireRole(['admin']);
$message = '';
$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);
$currentUser = $auth->user();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $csrf->validate($_POST['csrf'] ?? '')) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'client';
    if ($action === 'create') {
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
        $db->execute(
            'INSERT INTO users (name, email, password_hash, role, created_at) VALUES (:name, :email, :password_hash, :role, NOW())',
            [':name' => $name, ':email' => $email, ':password_hash' => $password, ':role' => $role]
        );
        $userId = (int)$db->lastInsertId();
        $token = bin2hex(random_bytes(32));
        $db->execute(
            'INSERT INTO email_verifications (user_id, token, created_at) VALUES (:user_id, :token, NOW())',
            [':user_id' => $userId, ':token' => $token]
        );
        $verifyLink = Utils::baseUrl($config) . '/verify.php?token=' . $token;
        Mailer::send($email, 'Confirmă emailul Quantumix', 'Confirmă emailul accesând: ' . $verifyLink, $config['mail']['from']);
        $message = 'Utilizator creat.';
        Audit::log($db, $currentUser['id'] ?? null, 'create_user', $email);
    }
    if ($action === 'edit' && $id) {
        $db->execute(
            'UPDATE users SET name = :name, email = :email, role = :role WHERE id = :id',
            [':name' => $name, ':email' => $email, ':role' => $role, ':id' => $id]
        );
        $message = 'Utilizator actualizat.';
        Audit::log($db, $currentUser['id'] ?? null, 'update_user', (string)$id);
    }
}
if ($action === 'delete' && $id && $csrf->validate($_GET['csrf'] ?? '')) {
    $db->execute('DELETE FROM users WHERE id = :id', [':id' => $id]);
    $message = 'Utilizator șters.';
    Audit::log($db, $currentUser['id'] ?? null, 'delete_user', (string)$id);
}
$user = $id ? $db->fetch('SELECT * FROM users WHERE id = :id', [':id' => $id]) : null;
$users = $db->fetchAll('SELECT * FROM users ORDER BY created_at DESC');
?>
<section class="admin-section">
    <h2>Utilizatori</h2>
    <?php if ($message): ?><p class="success"><?= Utils::e($message) ?></p><?php endif; ?>
    <div class="admin-grid">
        <div>
            <h3><?= $action === 'edit' ? 'Editează' : 'Adaugă' ?> utilizator</h3>
            <form method="post">
                <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
                <input type="text" name="name" placeholder="Nume" value="<?= Utils::e($user['name'] ?? '') ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?= Utils::e($user['email'] ?? '') ?>" required>
                <?php if ($action === 'create' || !$action): ?>
                    <input type="password" name="password" placeholder="Parolă" required>
                <?php endif; ?>
                <select name="role">
                    <?php foreach (['admin', 'editor', 'client'] as $roleOption): ?>
                        <option value="<?= $roleOption ?>" <?= ($user['role'] ?? '') === $roleOption ? 'selected' : '' ?>><?= ucfirst($roleOption) ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn" type="submit" formaction="/admin/users.php?action=<?= $action === 'edit' ? 'edit&id=' . $id : 'create' ?>">Salvează</button>
            </form>
        </div>
        <div>
            <h3>Listă utilizatori</h3>
            <table class="admin-table">
                <thead><tr><th>Nume</th><th>Email</th><th>Rol</th><th>Acțiuni</th></tr></thead>
                <tbody>
                    <?php foreach ($users as $row): ?>
                        <tr>
                            <td><?= Utils::e($row['name']) ?></td>
                            <td><?= Utils::e($row['email']) ?></td>
                            <td><?= Utils::e($row['role']) ?></td>
                            <td>
                                <a href="/admin/users.php?action=edit&id=<?= $row['id'] ?>">Edit</a>
                                <a href="/admin/users.php?action=delete&id=<?= $row['id'] ?>&csrf=<?= $csrf->token() ?>" onclick="return confirm('Ștergi?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
