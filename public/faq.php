<?php
require_once __DIR__ . '/partials/header.php';
$faqs = $db->fetchAll('SELECT * FROM faqs ORDER BY position ASC');
?>
<section class="page-hero">
    <div class="container">
        <h1>FAQ</h1>
        <p>Întrebări frecvente despre colaborarea cu Quantumix.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="accordion">
            <?php foreach ($faqs as $faq): ?>
                <div class="accordion-item">
                    <button type="button" class="accordion-header"><?= Utils::e($faq['question']) ?></button>
                    <div class="accordion-body">
                        <p><?= Utils::e($faq['answer']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
