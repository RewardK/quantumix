<?php
require_once __DIR__ . '/partials/header.php';
$projectModule = new Project($db);
$projects = $projectModule->all();
$categories = array_unique(array_column($projects, 'category'));
?>
<section class="page-hero">
    <div class="container">
        <h1>Portofoliu</h1>
        <p>Proiecte livrate în fintech, retail, health tech și industrii emergente.</p>
        <div class="filter">
            <button data-filter="all">Toate</button>
            <?php foreach ($categories as $category): ?>
                <button data-filter="<?= Utils::e($category) ?>"><?= Utils::e($category) ?></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section">
    <div class="container grid-3" id="project-grid">
        <?php foreach ($projects as $project): ?>
            <div class="card" data-category="<?= Utils::e($project['category']) ?>">
                <h3><?= Utils::e($i18n->t(['ro' => $project['name_ro'], 'en' => $project['name_en'], 'de' => $project['name_de'], 'fr' => $project['name_fr']])) ?></h3>
                <p><?= Utils::e(substr($i18n->t(['ro' => $project['description_ro'], 'en' => $project['description_en'], 'de' => $project['description_de'], 'fr' => $project['description_fr']]), 0, 120)) ?>...</p>
                <a href="/project.php?slug=<?= Utils::e($project['slug']) ?>">Detalii</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
