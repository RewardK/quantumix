<?php
require_once __DIR__ . '/partials/header.php';
$projectModule = new Project($db);
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
        ':category' => trim($_POST['category'] ?? ''),
        ':description_ro' => trim($_POST['description_ro'] ?? ''),
        ':description_en' => trim($_POST['description_en'] ?? ''),
        ':description_de' => trim($_POST['description_de'] ?? ''),
        ':description_fr' => trim($_POST['description_fr'] ?? ''),
    ];
    if ($action === 'edit' && $id) {
        $projectModule->update($id, $data);
        $message = 'Proiect actualizat.';
        Audit::log($db, $currentUser['id'] ?? null, 'update_project', (string)$id);
    } else {
        $projectModule->create($data);
        $message = 'Proiect creat.';
        Audit::log($db, $currentUser['id'] ?? null, 'create_project', $data[':slug']);
    }
}
if ($action === 'delete' && $id && $csrf->validate($_GET['csrf'] ?? '')) {
    $projectModule->delete($id);
    $message = 'Proiect șters.';
    Audit::log($db, $currentUser['id'] ?? null, 'delete_project', (string)$id);
}
$project = $id ? $db->fetch('SELECT * FROM projects WHERE id = :id', [':id' => $id]) : null;
$projects = $projectModule->all();
?>
<section class="admin-section">
    <h2>Proiecte</h2>
    <?php if ($message): ?><p class="success"><?= Utils::e($message) ?></p><?php endif; ?>
    <div class="admin-grid">
        <div>
            <h3><?= $action === 'edit' ? 'Editează' : 'Adaugă' ?> proiect</h3>
            <form method="post">
                <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
                <input type="text" name="name_ro" placeholder="Nume RO" value="<?= Utils::e($project['name_ro'] ?? '') ?>" required>
                <input type="text" name="name_en" placeholder="Nume EN" value="<?= Utils::e($project['name_en'] ?? '') ?>">
                <input type="text" name="name_de" placeholder="Nume DE" value="<?= Utils::e($project['name_de'] ?? '') ?>">
                <input type="text" name="name_fr" placeholder="Nume FR" value="<?= Utils::e($project['name_fr'] ?? '') ?>">
                <input type="text" name="slug" placeholder="Slug" value="<?= Utils::e($project['slug'] ?? '') ?>">
                <input type="text" name="category" placeholder="Categorie" value="<?= Utils::e($project['category'] ?? '') ?>">
                <textarea name="description_ro" placeholder="Descriere RO" required><?= Utils::e($project['description_ro'] ?? '') ?></textarea>
                <textarea name="description_en" placeholder="Descriere EN"><?= Utils::e($project['description_en'] ?? '') ?></textarea>
                <textarea name="description_de" placeholder="Descriere DE"><?= Utils::e($project['description_de'] ?? '') ?></textarea>
                <textarea name="description_fr" placeholder="Descriere FR"><?= Utils::e($project['description_fr'] ?? '') ?></textarea>
                <button class="btn" type="submit">Salvează</button>
            </form>
        </div>
        <div>
            <h3>Listă proiecte</h3>
            <table class="admin-table">
                <thead><tr><th>Nume</th><th>Categorie</th><th>Acțiuni</th></tr></thead>
                <tbody>
                    <?php foreach ($projects as $row): ?>
                        <tr>
                            <td><?= Utils::e($row['name_ro']) ?></td>
                            <td><?= Utils::e($row['category']) ?></td>
                            <td>
                                <a href="/admin/projects.php?action=edit&id=<?= $row['id'] ?>">Edit</a>
                                <a href="/admin/projects.php?action=delete&id=<?= $row['id'] ?>&csrf=<?= $csrf->token() ?>" onclick="return confirm('Ștergi?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
