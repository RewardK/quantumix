<?php
require_once __DIR__ . '/../core/bootstrap.php';
$token = $_SERVER['HTTP_X_API_TOKEN'] ?? '';
if (!hash_equals($config['security']['api_token'], $token)) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
$posts = $db->fetchAll('SELECT id, title_ro, title_en, title_de, title_fr, slug, excerpt_ro, excerpt_en, excerpt_de, excerpt_fr, published_at FROM posts WHERE published = 1');
header('Content-Type: application/json');
echo json_encode(['data' => $posts]);
