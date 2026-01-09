<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../modules/Service.php';
require_once __DIR__ . '/../../modules/Project.php';
require_once __DIR__ . '/../../modules/Blog.php';
$auth->requireRole(['admin', 'editor']);
$user = $auth->user();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Quantumix</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
<header class="admin-header">
    <h1>Quantumix Admin</h1>
    <nav>
        <a href="/admin/dashboard.php">Dashboard</a>
        <a href="/admin/users.php">Utilizatori</a>
        <a href="/admin/services.php">Servicii</a>
        <a href="/admin/projects.php">Proiecte</a>
        <a href="/admin/posts.php">Blog</a>
        <a href="/admin/pages.php">Pagini</a>
        <a href="/admin/messages.php">Mesaje</a>
        <a href="/admin/newsletter.php">Newsletter</a>
        <a href="/admin/settings.php">Setări</a>
        <a href="/admin/media.php">Media</a>
        <a href="/admin/backup.php">Backup</a>
        <a href="/admin/logs.php">Loguri</a>
        <a href="/logout.php">Logout</a>
    </nav>
    <div class="admin-user"><?= Utils::e($user['name']) ?> (<?= Utils::e($user['role']) ?>)</div>
</header>
<main class="admin-main">
