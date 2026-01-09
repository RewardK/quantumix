<?php
require_once __DIR__ . '/partials/header.php';
$terms = $db->fetch('SELECT * FROM pages WHERE slug = "terms"');
?>
<section class="page-hero">
    <div class="container">
        <h1>Terms & Privacy</h1>
    </div>
</section>
<section class="section">
    <div class="container prose">
        <?= nl2br(Utils::e($i18n->t(['ro' => $terms['content_ro'] ?? '', 'en' => $terms['content_en'] ?? '', 'de' => $terms['content_de'] ?? '', 'fr' => $terms['content_fr'] ?? '']))) ?>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
