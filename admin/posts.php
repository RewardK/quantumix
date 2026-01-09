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
        ':excerpt_ro' => trim($_POST['excerpt_ro'] ?? ''),
        ':excerpt_en' => trim($_POST['excerpt_en'] ?? ''),
        ':excerpt_de' => trim($_POST['excerpt_de'] ?? ''),
        ':excerpt_fr' => trim($_POST['excerpt_fr'] ?? ''),
        ':content_ro' => trim($_POST['content_ro'] ?? ''),
        ':content_en' => trim($_POST['content_en'] ?? ''),
        ':content_de' => trim($_POST['content_de'] ?? ''),
        ':content_fr' => trim($_POST['content_fr'] ?? ''),
        ':published' => isset($_POST['published']) ? 1 : 0,
    ];
    if ($action === 'edit' && $id) {
        $data[':id'] = $id;
        $db->execute(
            'UPDATE posts SET title_ro = :title_ro, title_en = :title_en, title_de = :title_de, title_fr = :title_fr, slug = :slug,
            excerpt_ro = :excerpt_ro, excerpt_en = :excerpt_en, excerpt_de = :excerpt_de, excerpt_fr = :excerpt_fr,
            content_ro = :content_ro, content_en = :content_en, content_de = :content_de, content_fr = :content_fr, published = :published WHERE id = :id',
            $data
        );
        $message = 'Articol actualizat.';
        Audit::log($db, $currentUser['id'] ?? null, 'update_post', (string)$id);
    } else {
        $db->execute(
            'INSERT INTO posts (title_ro, title_en, title_de, title_fr, slug, excerpt_ro, excerpt_en, excerpt_de, excerpt_fr, content_ro, content_en, content_de, content_fr, published, published_at, created_at)
            VALUES (:title_ro, :title_en, :title_de, :title_fr, :slug, :excerpt_ro, :excerpt_en, :excerpt_de, :excerpt_fr, :content_ro, :content_en, :content_de, :content_fr, :published, NOW(), NOW())',
            $data
        );
        $message = 'Articol creat.';
        Audit::log($db, $currentUser['id'] ?? null, 'create_post', $data[':slug']);
    }
}
if ($action === 'delete' && $id && $csrf->validate($_GET['csrf'] ?? '')) {
    $db->execute('DELETE FROM posts WHERE id = :id', [':id' => $id]);
    $message = 'Articol șters.';
    Audit::log($db, $currentUser['id'] ?? null, 'delete_post', (string)$id);
}
$post = $id ? $db->fetch('SELECT * FROM posts WHERE id = :id', [':id' => $id]) : null;
$posts = $db->fetchAll('SELECT * FROM posts ORDER BY created_at DESC');
?>
<section class="admin-section">
    <h2>Blog</h2>
    <?php if ($message): ?><p class="success"><?= Utils::e($message) ?></p><?php endif; ?>
    <div class="admin-grid">
        <div>
            <h3><?= $action === 'edit' ? 'Editează' : 'Adaugă' ?> articol</h3>
            <form method="post">
                <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
                <input type="text" name="title_ro" placeholder="Titlu RO" value="<?= Utils::e($post['title_ro'] ?? '') ?>" required>
                <input type="text" name="title_en" placeholder="Titlu EN" value="<?= Utils::e($post['title_en'] ?? '') ?>">
                <input type="text" name="title_de" placeholder="Titlu DE" value="<?= Utils::e($post['title_de'] ?? '') ?>">
                <input type="text" name="title_fr" placeholder="Titlu FR" value="<?= Utils::e($post['title_fr'] ?? '') ?>">
                <input type="text" name="slug" placeholder="Slug" value="<?= Utils::e($post['slug'] ?? '') ?>">
                <textarea name="excerpt_ro" placeholder="Excerpt RO" required><?= Utils::e($post['excerpt_ro'] ?? '') ?></textarea>
                <textarea name="excerpt_en" placeholder="Excerpt EN"><?= Utils::e($post['excerpt_en'] ?? '') ?></textarea>
                <textarea name="excerpt_de" placeholder="Excerpt DE"><?= Utils::e($post['excerpt_de'] ?? '') ?></textarea>
                <textarea name="excerpt_fr" placeholder="Excerpt FR"><?= Utils::e($post['excerpt_fr'] ?? '') ?></textarea>
                <textarea name="content_ro" placeholder="Conținut RO" required><?= Utils::e($post['content_ro'] ?? '') ?></textarea>
                <textarea name="content_en" placeholder="Conținut EN"><?= Utils::e($post['content_en'] ?? '') ?></textarea>
                <textarea name="content_de" placeholder="Conținut DE"><?= Utils::e($post['content_de'] ?? '') ?></textarea>
                <textarea name="content_fr" placeholder="Conținut FR"><?= Utils::e($post['content_fr'] ?? '') ?></textarea>
                <label><input type="checkbox" name="published" <?= ($post['published'] ?? 0) ? 'checked' : '' ?>> Publicat</label>
                <button class="btn" type="submit">Salvează</button>
            </form>
        </div>
        <div>
            <h3>Listă articole</h3>
            <table class="admin-table">
                <thead><tr><th>Titlu</th><th>Status</th><th>Acțiuni</th></tr></thead>
                <tbody>
                    <?php foreach ($posts as $row): ?>
                        <tr>
                            <td><?= Utils::e($row['title_ro']) ?></td>
                            <td><?= $row['published'] ? 'Publicat' : 'Draft' ?></td>
                            <td>
                                <a href="/admin/posts.php?action=edit&id=<?= $row['id'] ?>">Edit</a>
                                <a href="/admin/posts.php?action=delete&id=<?= $row['id'] ?>&csrf=<?= $csrf->token() ?>" onclick="return confirm('Ștergi?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
