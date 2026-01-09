<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../modules/Service.php';
require_once __DIR__ . '/../../modules/Project.php';
require_once __DIR__ . '/../../modules/Blog.php';
require_once __DIR__ . '/../../modules/Page.php';

$lang = $i18n->current();
$baseUrl = Utils::baseUrl($config);
?>
<!DOCTYPE html>
<html lang="<?= Utils::e($lang) ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Utils::e($config['site']['name']) ?></title>
    <meta name="description" content="Quantumix - servicii software & IT pentru companii care vor performanță.">
    <link rel="stylesheet" href="/assets/css/style.min.css">
    <script defer src="/assets/js/main.min.js"></script>
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="/">Quantumix</a>
        <nav class="main-nav">
            <a href="/">Home</a>
            <a href="/about.php">Despre</a>
            <a href="/services.php">Servicii</a>
            <a href="/projects.php">Portofoliu</a>
            <a href="/blog.php">Blog</a>
            <a href="/contact.php">Contact</a>
            <a href="/faq.php">FAQ</a>
        </nav>
        <div class="header-actions">
            <a class="btn-outline" href="/login.php">Client Login</a>
            <div class="lang-switch">
                <a href="?lang=ro">RO</a>
                <a href="?lang=en">EN</a>
                <a href="?lang=de">DE</a>
                <a href="?lang=fr">FR</a>
            </div>
        </div>
    </div>
</header>
<main>
