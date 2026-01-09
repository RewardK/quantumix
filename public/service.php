<?php
require_once __DIR__ . '/partials/header.php';
$serviceModule = new Service($db);
$slug = $_GET['slug'] ?? '';
$service = $serviceModule->findBySlug($slug);
if (!$service) {
    http_response_code(404);
    echo '<div class="container section"><h1>Serviciu indisponibil</h1></div>';
    require_once __DIR__ . '/partials/footer.php';
    exit;
}
?>
<section class="page-hero">
    <div class="container">
        <h1><?= Utils::e($i18n->t(['ro' => $service['name_ro'], 'en' => $service['name_en'], 'de' => $service['name_de'], 'fr' => $service['name_fr']])) ?></h1>
        <p><?= Utils::e($i18n->t(['ro' => $service['description_ro'], 'en' => $service['description_en'], 'de' => $service['description_de'], 'fr' => $service['description_fr']])) ?></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <h2>Beneficii</h2>
        <ul class="bullet-list">
            <?php foreach (explode(',', $service['benefits']) as $benefit): ?>
                <li><?= Utils::e(trim($benefit)) ?></li>
            <?php endforeach; ?>
        </ul>
        <a class="btn" href="/contact.php">Solicită ofertă</a>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
