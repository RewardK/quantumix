<?php
require_once __DIR__ . '/../core/bootstrap.php';
header('Content-Type: application/xml');
$base = Utils::baseUrl($config);
$urls = [
    '/', '/about.php', '/services.php', '/projects.php', '/blog.php', '/contact.php', '/faq.php', '/terms.php'
];
$services = $db->fetchAll('SELECT slug FROM services');
$projects = $db->fetchAll('SELECT slug FROM projects');
$posts = $db->fetchAll('SELECT slug FROM posts WHERE published = 1');

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($urls as $url): ?>
        <url><loc><?= Utils::e($base . $url) ?></loc></url>
    <?php endforeach; ?>
    <?php foreach ($services as $service): ?>
        <url><loc><?= Utils::e($base . '/service.php?slug=' . $service['slug']) ?></loc></url>
    <?php endforeach; ?>
    <?php foreach ($projects as $project): ?>
        <url><loc><?= Utils::e($base . '/project.php?slug=' . $project['slug']) ?></loc></url>
    <?php endforeach; ?>
    <?php foreach ($posts as $post): ?>
        <url><loc><?= Utils::e($base . '/post.php?slug=' . $post['slug']) ?></loc></url>
    <?php endforeach; ?>
</urlset>
