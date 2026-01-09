<?php
require_once __DIR__ . '/partials/header.php';
$message = '';
$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);
$currentUser = $auth->user();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $csrf->validate($_POST['csrf'] ?? '')) {
    $data = [
        ':title_ro' => trim($_POST['title_ro'] ?? ''),
        ':title_en' => trim($_POST['title_en'] ?? ''),
        ':title_de' => trim($_POST['title_de'] ?? ''),
        ':title_fr' => trim($_POST['title_fr'] ?? ''),
        ':slug' => Utils::slug($_POST['slug'] ?? $_POST['title_ro'] ?? ''),
        ':content_ro' => trim($_POST['content_ro'] ?? ''),
        ':content_en' => trim($_POST['content_en'] ?? ''),
        ':content_de' => trim($_POST['content_de'] ?? ''),
        ':content_fr' => trim($_POST['content_fr'] ?? ''),
    ];
    if ($action === 'edit' && $id) {
        $data[':id'] = $id;
        $db->execute(
            'UPDATE pages SET title_ro = :title_ro, title_en = :title_en, title_de = :title_de, title_fr = :title_fr, slug = :slug,
            content_ro = :content_ro, content_en = :content_en, content_de = :content_de, content_fr = :content_fr WHERE id = :id',
            $data
        );
        $message = 'Pagină actualizată.';
        Audit::log($db, $currentUser['id'] ?? null, 'update_page', (string)$id);
    } else {
        $db->execute(
            'INSERT INTO pages (title_ro, title_en, title_de, title_fr, slug, content_ro, content_en, content_de, content_fr, created_at)
            VALUES (:title_ro, :title_en, :title_de, :title_fr, :slug, :content_ro, :content_en, :content_de, :content_fr, NOW())',
            $data
        );
        $message = 'Pagină creată.';
        Audit::log($db, $currentUser['id'] ?? null, 'create_page', $data[':slug']);
    }
}
if ($action === 'delete' && $id && $csrf->validate($_GET['csrf'] ?? '')) {
    $db->execute('DELETE FROM pages WHERE id = :id', [':id' => $id]);
    $message = 'Pagină ștearsă.';
    Audit::log($db, $currentUser['id'] ?? null, 'delete_page', (string)$id);
}
$page = $id ? $db->fetch('SELECT * FROM pages WHERE id = :id', [':id' => $id]) : null;
$pages = $db->fetchAll('SELECT * FROM pages ORDER BY created_at DESC');
?>
<section class="admin-section">
    <h2>Pagini CMS</h2>
    <?php if ($message): ?><p class="success"><?= Utils::e($message) ?></p><?php endif; ?>
    <div class="admin-grid">
        <div>
            <h3><?= $action === 'edit' ? 'Editează' : 'Adaugă' ?> pagină</h3>
            <form method="post">
                <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
                <input type="text" name="title_ro" placeholder="Titlu RO" value="<?= Utils::e($page['title_ro'] ?? '') ?>" required>
                <input type="text" name="title_en" placeholder="Titlu EN" value="<?= Utils::e($page['title_en'] ?? '') ?>">
                <input type="text" name="title_de" placeholder="Titlu DE" value="<?= Utils::e($page['title_de'] ?? '') ?>">
                <input type="text" name="title_fr" placeholder="Titlu FR" value="<?= Utils::e($page['title_fr'] ?? '') ?>">
                <input type="text" name="slug" placeholder="Slug" value="<?= Utils::e($page['slug'] ?? '') ?>">
                <textarea name="content_ro" placeholder="Conținut RO" required><?= Utils::e($page['content_ro'] ?? '') ?></textarea>
                <textarea name="content_en" placeholder="Conținut EN"><?= Utils::e($page['content_en'] ?? '') ?></textarea>
                <textarea name="content_de" placeholder="Conținut DE"><?= Utils::e($page['content_de'] ?? '') ?></textarea>
                <textarea name="content_fr" placeholder="Conținut FR"><?= Utils::e($page['content_fr'] ?? '') ?></textarea>
                <button class="btn" type="submit">Salvează</button>
            </form>
        </div>
        <div>
            <h3>Listă pagini</h3>
            <table class="admin-table">
                <thead><tr><th>Titlu</th><th>Slug</th><th>Acțiuni</th></tr></thead>
                <tbody>
                    <?php foreach ($pages as $row): ?>
                        <tr>
                            <td><?= Utils::e($row['title_ro']) ?></td>
                            <td><?= Utils::e($row['slug']) ?></td>
                            <td>
                                <a href="/admin/pages.php?action=edit&id=<?= $row['id'] ?>">Edit</a>
                                <a href="/admin/pages.php?action=delete&id=<?= $row['id'] ?>&csrf=<?= $csrf->token() ?>" onclick="return confirm('Ștergi?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
