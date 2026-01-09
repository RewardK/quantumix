<?php
require_once __DIR__ . '/partials/header.php';
$serviceModule = new Service($db);
$message = '';
$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);
$currentUser = $auth->user();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $csrf->validate($_POST['csrf'] ?? '')) {
    $data = [
        ':name_ro' => trim($_POST['name_ro'] ?? ''),
        ':name_en' => trim($_POST['name_en'] ?? ''),
        ':name_de' => trim($_POST['name_de'] ?? ''),
        ':name_fr' => trim($_POST['name_fr'] ?? ''),
        ':slug' => Utils::slug($_POST['slug'] ?? $_POST['name_ro'] ?? ''),
        ':icon' => trim($_POST['icon'] ?? ''),
        ':description_ro' => trim($_POST['description_ro'] ?? ''),
        ':description_en' => trim($_POST['description_en'] ?? ''),
        ':description_de' => trim($_POST['description_de'] ?? ''),
        ':description_fr' => trim($_POST['description_fr'] ?? ''),
        ':benefits' => trim($_POST['benefits'] ?? ''),
    ];
    if ($action === 'edit' && $id) {
        $serviceModule->update($id, $data);
        $message = 'Serviciu actualizat.';
        Audit::log($db, $currentUser['id'] ?? null, 'update_service', (string)$id);
    } else {
        $serviceModule->create($data);
        $message = 'Serviciu creat.';
        Audit::log($db, $currentUser['id'] ?? null, 'create_service', $data[':slug']);
    }
}
if ($action === 'delete' && $id && $csrf->validate($_GET['csrf'] ?? '')) {
    $serviceModule->delete($id);
    $message = 'Serviciu șters.';
    Audit::log($db, $currentUser['id'] ?? null, 'delete_service', (string)$id);
}
$service = $id ? $db->fetch('SELECT * FROM services WHERE id = :id', [':id' => $id]) : null;
$services = $serviceModule->all();
?>
<section class="admin-section">
    <h2>Servicii</h2>
    <?php if ($message): ?><p class="success"><?= Utils::e($message) ?></p><?php endif; ?>
    <div class="admin-grid">
        <div>
            <h3><?= $action === 'edit' ? 'Editează' : 'Adaugă' ?> serviciu</h3>
            <form method="post">
                <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
                <input type="text" name="name_ro" placeholder="Nume RO" value="<?= Utils::e($service['name_ro'] ?? '') ?>" required>
                <input type="text" name="name_en" placeholder="Nume EN" value="<?= Utils::e($service['name_en'] ?? '') ?>">
                <input type="text" name="name_de" placeholder="Nume DE" value="<?= Utils::e($service['name_de'] ?? '') ?>">
                <input type="text" name="name_fr" placeholder="Nume FR" value="<?= Utils::e($service['name_fr'] ?? '') ?>">
                <input type="text" name="slug" placeholder="Slug" value="<?= Utils::e($service['slug'] ?? '') ?>">
                <input type="text" name="icon" placeholder="Icon (clasă CSS)" value="<?= Utils::e($service['icon'] ?? '') ?>">
                <textarea name="description_ro" placeholder="Descriere RO" required><?= Utils::e($service['description_ro'] ?? '') ?></textarea>
                <textarea name="description_en" placeholder="Descriere EN"><?= Utils::e($service['description_en'] ?? '') ?></textarea>
                <textarea name="description_de" placeholder="Descriere DE"><?= Utils::e($service['description_de'] ?? '') ?></textarea>
                <textarea name="description_fr" placeholder="Descriere FR"><?= Utils::e($service['description_fr'] ?? '') ?></textarea>
                <textarea name="benefits" placeholder="Beneficii (separate prin virgulă)"><?= Utils::e($service['benefits'] ?? '') ?></textarea>
                <button class="btn" type="submit">Salvează</button>
            </form>
        </div>
        <div>
            <h3>Listă servicii</h3>
            <table class="admin-table">
                <thead><tr><th>Nume</th><th>Slug</th><th>Acțiuni</th></tr></thead>
                <tbody>
                    <?php foreach ($services as $row): ?>
                        <tr>
                            <td><?= Utils::e($row['name_ro']) ?></td>
                            <td><?= Utils::e($row['slug']) ?></td>
                            <td>
                                <a href="/admin/services.php?action=edit&id=<?= $row['id'] ?>">Edit</a>
                                <a href="/admin/services.php?action=delete&id=<?= $row['id'] ?>&csrf=<?= $csrf->token() ?>" onclick="return confirm('Ștergi?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
