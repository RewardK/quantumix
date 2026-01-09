<?php
require_once __DIR__ . '/partials/header.php';
$team = $db->fetchAll('SELECT * FROM team_members ORDER BY created_at DESC');
$timeline = $db->fetchAll('SELECT * FROM timelines ORDER BY year ASC');
?>
<section class="page-hero">
    <div class="container">
        <h1>Despre Quantumix</h1>
        <p>Suntem o echipă de specialiști în software, securitate și infrastructură cloud. Livrăm soluții end-to-end pentru companii ambițioase.</p>
    </div>
</section>

<section class="section">
    <div class="container grid-2">
        <div>
            <h2>Misiune</h2>
            <p>Construim produse digitale robuste, cu focus pe calitate, securitate și experiența utilizatorului.</p>
        </div>
        <div>
            <h2>Viziune</h2>
            <p>Să devenim partenerul preferat al companiilor care își doresc transformare digitală reală.</p>
        </div>
    </div>
</section>

<section class="section dark">
    <div class="container">
        <h2>Timeline</h2>
        <div class="timeline">
            <?php foreach ($timeline as $item): ?>
                <div class="timeline-item">
                    <span><?= Utils::e($item['year']) ?></span>
                    <p><?= Utils::e($item['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2>Echipa noastră</h2>
        <div class="grid-3">
            <?php foreach ($team as $member): ?>
                <div class="card">
                    <img src="/uploads/<?= Utils::e($member['photo']) ?>" alt="<?= Utils::e($member['name']) ?>" loading="lazy">
                    <h3><?= Utils::e($member['name']) ?></h3>
                    <p><?= Utils::e($member['role']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
