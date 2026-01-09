<?php
require_once __DIR__ . '/partials/header.php';
$pageModule = new Page($db);
$slug = $_GET['slug'] ?? '';
$page = $pageModule->findBySlug($slug);
if (!$page) {
    http_response_code(404);
    echo '<div class="container section"><h1>Pagină indisponibilă</h1></div>';
    require_once __DIR__ . '/partials/footer.php';
    exit;
}
?>
<section class="page-hero">
    <div class="container">
        <h1><?= Utils::e($i18n->t(['ro' => $page['title_ro'], 'en' => $page['title_en'], 'de' => $page['title_de'], 'fr' => $page['title_fr']])) ?></h1>
    </div>
</section>
<section class="section">
    <div class="container prose">
        <?= nl2br(Utils::e($i18n->t(['ro' => $page['content_ro'], 'en' => $page['content_en'], 'de' => $page['content_de'], 'fr' => $page['content_fr']])) ) ?>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
