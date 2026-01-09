<?php
require_once __DIR__ . '/partials/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $csrf->validate($_POST['csrf'] ?? '')) {
    if (!empty($_FILES['file']['name'])) {
        $name = basename($_FILES['file']['name']);
        $target = __DIR__ . '/../uploads/' . $name;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            $db->execute('INSERT INTO media (file, created_at) VALUES (:file, NOW())', [':file' => $name]);
            $message = 'Fișier încărcat.';
            $user = $auth->user();
            Audit::log($db, $user['id'] ?? null, 'upload_media', $name);
        }
    }
}
$media = $db->fetchAll('SELECT * FROM media ORDER BY created_at DESC');
?>
<section class="admin-section">
    <h2>Media Manager</h2>
    <?php if ($message): ?><p class="success"><?= Utils::e($message) ?></p><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
        <input type="file" name="file" required>
        <button class="btn" type="submit">Upload</button>
    </form>
    <div class="media-grid">
        <?php foreach ($media as $item): ?>
            <div>
                <img src="/uploads/<?= Utils::e($item['file']) ?>" alt="Media" loading="lazy">
                <p><?= Utils::e($item['file']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
