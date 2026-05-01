<?php
// =========================================================
// AJAX endpoint : recherche / filtrage des produits
// Renvoie du JSON
// =========================================================
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

$q        = trim($_GET['q']        ?? '');
$category = trim($_GET['category'] ?? '');

$sql    = "SELECT id, name, description, price, image, category, stock FROM products WHERE 1=1";
$params = [];

if ($q !== '') {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $like = "%$q%";
    $params[] = $like;
    $params[] = $like;
}
if ($category !== '' && $category !== 'all') {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$sql .= " ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode([
    'ok'       => true,
    'count'    => $stmt->rowCount(),
    'products' => $stmt->fetchAll(),
], JSON_UNESCAPED_UNICODE);
