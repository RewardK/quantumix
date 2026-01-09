<?php
require_once __DIR__ . '/partials/header.php';
$serviceModule = new Service($db);
$services = $serviceModule->all();
?>
<section class="page-hero">
    <div class="container">
        <h1>Serviciile noastre</h1>
        <p>Strategie, dezvoltare și mentenanță pentru produse software de top.</p>
    </div>
</section>
<section class="section">
    <div class="container grid-3">
        <?php foreach ($services as $service): ?>
            <div class="card">
                <h3><?= Utils::e($i18n->t(['ro' => $service['name_ro'], 'en' => $service['name_en'], 'de' => $service['name_de'], 'fr' => $service['name_fr']])) ?></h3>
                <p><?= Utils::e(substr($i18n->t(['ro' => $service['description_ro'], 'en' => $service['description_en'], 'de' => $service['description_de'], 'fr' => $service['description_fr']]), 0, 150)) ?>...</p>
                <ul>
                    <?php foreach (explode(',', $service['benefits']) as $benefit): ?>
                        <li><?= Utils::e(trim($benefit)) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a class="btn-outline" href="/service.php?slug=<?= Utils::e($service['slug']) ?>">Detalii</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
