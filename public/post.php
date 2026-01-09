<?php
require_once __DIR__ . '/partials/header.php';
$blogModule = new Blog($db);
$slug = $_GET['slug'] ?? '';
$post = $blogModule->findBySlug($slug);
if (!$post) {
    http_response_code(404);
    echo '<div class="container section"><h1>Articol indisponibil</h1></div>';
    require_once __DIR__ . '/partials/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($csrf->validate($_POST['csrf'] ?? '')) {
        $name = trim($_POST['name'] ?? '');
        $message = trim($_POST['message'] ?? '');
        if ($name && $message) {
            $blogModule->addComment((int)$post['id'], $name, $message);
        }
    }
    Utils::redirect('/post.php?slug=' . urlencode($slug));
}
$comments = $blogModule->comments((int)$post['id']);
?>
<section class="page-hero">
    <div class="container">
        <h1><?= Utils::e($i18n->t(['ro' => $post['title_ro'], 'en' => $post['title_en'], 'de' => $post['title_de'], 'fr' => $post['title_fr']])) ?></h1>
        <p><?= Utils::e($i18n->t(['ro' => $post['excerpt_ro'], 'en' => $post['excerpt_en'], 'de' => $post['excerpt_de'], 'fr' => $post['excerpt_fr']])) ?></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <article class="prose">
            <?= nl2br(Utils::e($i18n->t(['ro' => $post['content_ro'], 'en' => $post['content_en'], 'de' => $post['content_de'], 'fr' => $post['content_fr']])) ) ?>
        </article>
    </div>
</section>
<section class="section dark">
    <div class="container">
        <h2>Comentarii</h2>
        <div class="comments">
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <strong><?= Utils::e($comment['name']) ?></strong>
                    <p><?= Utils::e($comment['message']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="post" class="form">
            <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
            <input type="text" name="name" placeholder="Nume" required>
            <textarea name="message" placeholder="Mesaj" required></textarea>
            <button class="btn" type="submit">Trimite</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
