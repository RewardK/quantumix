<?php
require_once __DIR__ . '/partials/header.php';

$serviceModule = new Service($db);
$blogModule = new Blog($db);
$cached = $cache->get('homepage', 300);
if ($cached) {
    $services = $cached['services'];
    $posts = $cached['posts'];
    $testimonials = $cached['testimonials'];
    $techLogos = $cached['techLogos'];
} else {
    $services = $serviceModule->all();
    $posts = $blogModule->posts(3, 0);
    $testimonials = $db->fetchAll('SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 3');
    $techLogos = $db->fetchAll('SELECT * FROM tech_logos ORDER BY name ASC');
    $cache->set('homepage', [
        'services' => $services,
        'posts' => $posts,
        'testimonials' => $testimonials,
        'techLogos' => $techLogos,
    ]);
}
?>
<section class="hero">
    <div class="container hero-grid">
        <div>
            <h1>Quantumix — tehnologie care accelerează afacerea ta</h1>
            <p>Construim platforme software sigure, scalabile și ușor de extins, cu focus pe rezultate și experiență utilizator.</p>
            <div class="hero-actions">
                <a class="btn" href="/contact.php">Programează o consultanță</a>
                <a class="btn-outline" href="/services.php">Vezi servicii</a>
            </div>
        </div>
        <div class="hero-card">
            <h3>Insight rapid</h3>
            <ul>
                <li>+120 proiecte livrate</li>
                <li>15+ ani experiență</li>
                <li>99.9% uptime pe soluțiile noastre</li>
            </ul>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2>Servicii</h2>
        <div class="grid-3">
            <?php foreach ($services as $service): ?>
                <div class="card">
                    <h3><?= Utils::e($i18n->t(['ro' => $service['name_ro'], 'en' => $service['name_en'], 'de' => $service['name_de'], 'fr' => $service['name_fr']])) ?></h3>
                    <p><?= Utils::e(substr($i18n->t(['ro' => $service['description_ro'], 'en' => $service['description_en'], 'de' => $service['description_de'], 'fr' => $service['description_fr']]), 0, 120)) ?>...</p>
                    <a href="/service.php?slug=<?= Utils::e($service['slug']) ?>">Detalii</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section dark">
    <div class="container">
        <h2>Ce spun clienții</h2>
        <div class="grid-3">
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="card">
                    <p>“<?= Utils::e($testimonial['message']) ?>”</p>
                    <strong><?= Utils::e($testimonial['name']) ?></strong>
                    <span><?= Utils::e($testimonial['company']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2>Ultimele articole</h2>
        <div class="grid-3">
            <?php foreach ($posts as $post): ?>
                <div class="card">
                    <h3><?= Utils::e($i18n->t(['ro' => $post['title_ro'], 'en' => $post['title_en'], 'de' => $post['title_de'], 'fr' => $post['title_fr']])) ?></h3>
                    <p><?= Utils::e(substr($i18n->t(['ro' => $post['excerpt_ro'], 'en' => $post['excerpt_en'], 'de' => $post['excerpt_de'], 'fr' => $post['excerpt_fr']]), 0, 120)) ?>...</p>
                    <a href="/post.php?slug=<?= Utils::e($post['slug']) ?>">Citește</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section tech">
    <div class="container">
        <h2>Tehnologii</h2>
        <div class="tech-logos">
            <?php foreach ($techLogos as $logo): ?>
                <div class="tech-logo">
                    <img src="/uploads/<?= Utils::e($logo['file']) ?>" alt="<?= Utils::e($logo['name']) ?>" loading="lazy">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
