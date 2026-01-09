<?php
require_once __DIR__ . '/partials/header.php';
$blogModule = new Blog($db);
$page = max(1, (int)($_GET['page'] ?? 1));
$search = trim($_GET['q'] ?? '');
$limit = 6;
$offset = ($page - 1) * $limit;
$posts = $blogModule->posts($limit, $offset, $search ?: null);
$total = $blogModule->count($search ?: null);
$pages = (int)ceil($total / $limit);
?>
<section class="page-hero">
    <div class="container">
        <h1>Blog & News</h1>
        <form class="search" method="get">
            <input type="text" name="q" value="<?= Utils::e($search) ?>" placeholder="Caută articol...">
            <button class="btn" type="submit">Caută</button>
        </form>
    </div>
</section>
<section class="section">
    <div class="container grid-3">
        <?php foreach ($posts as $post): ?>
            <div class="card">
                <h3><?= Utils::e($i18n->t(['ro' => $post['title_ro'], 'en' => $post['title_en'], 'de' => $post['title_de'], 'fr' => $post['title_fr']])) ?></h3>
                <p><?= Utils::e($i18n->t(['ro' => $post['excerpt_ro'], 'en' => $post['excerpt_en'], 'de' => $post['excerpt_de'], 'fr' => $post['excerpt_fr']])) ?></p>
                <a href="/post.php?slug=<?= Utils::e($post['slug']) ?>">Citește</a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pagination container">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a class="<?= $i === $page ? 'active' : '' ?>" href="/blog.php?page=<?= $i ?>&q=<?= urlencode($search) ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
