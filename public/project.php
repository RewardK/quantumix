<?php
require_once __DIR__ . '/partials/header.php';
$projectModule = new Project($db);
$slug = $_GET['slug'] ?? '';
$project = $projectModule->findBySlug($slug);
if (!$project) {
    http_response_code(404);
    echo '<div class="container section"><h1>Proiect indisponibil</h1></div>';
    require_once __DIR__ . '/partials/footer.php';
    exit;
}
$images = $projectModule->images((int)$project['id']);
?>
<section class="page-hero">
    <div class="container">
        <h1><?= Utils::e($i18n->t(['ro' => $project['name_ro'], 'en' => $project['name_en'], 'de' => $project['name_de'], 'fr' => $project['name_fr']])) ?></h1>
        <p><?= Utils::e($i18n->t(['ro' => $project['description_ro'], 'en' => $project['description_en'], 'de' => $project['description_de'], 'fr' => $project['description_fr']])) ?></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2>Galerie</h2>
        <div class="grid-3">
            <?php foreach ($images as $image): ?>
                <img src="/uploads/<?= Utils::e($image['file']) ?>" alt="<?= Utils::e($i18n->t(['ro' => $project['name_ro'], 'en' => $project['name_en'], 'de' => $project['name_de'], 'fr' => $project['name_fr']])) ?>" loading="lazy">
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
