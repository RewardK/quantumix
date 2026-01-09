<?php
require_once __DIR__ . '/../core/bootstrap.php';
$token = $_SERVER['HTTP_X_API_TOKEN'] ?? '';
if (!hash_equals($config['security']['api_token'], $token)) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
$projects = $db->fetchAll('SELECT id, name_ro, name_en, name_de, name_fr, slug, category, description_ro, description_en, description_de, description_fr FROM projects');
header('Content-Type: application/json');
echo json_encode(['data' => $projects]);
