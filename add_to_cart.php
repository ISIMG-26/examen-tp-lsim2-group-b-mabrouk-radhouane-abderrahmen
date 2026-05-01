<?php
// =========================================================
// AJAX endpoint : ajout d'un produit au panier
// =========================================================
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['ok' => false, 'error' => 'auth']);
    exit;
}

$product_id = (int)($_POST['product_id'] ?? 0);
$quantity   = max(1, (int)($_POST['quantity'] ?? 1));
$user_id    = (int)$_SESSION['user_id'];

if ($product_id <= 0) {
    echo json_encode(['ok' => false, 'error' => 'invalid_product']);
    exit;
}

// Verifier le produit
$stmt = $pdo->prepare("SELECT id, stock FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();
if (!$product) {
    echo json_encode(['ok' => false, 'error' => 'not_found']);
    exit;
}

// Si deja dans le panier => UPDATE quantite, sinon INSERT
$stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->execute([$user_id, $product_id]);
$row = $stmt->fetch();

if ($row) {
    $newQty = (int)$row['quantity'] + $quantity;
    $upd = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $upd->execute([$newQty, $row['id']]);
} else {
    $ins = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $ins->execute([$user_id, $product_id, $quantity]);
}

// Recuperer le total d'articles
$count = $pdo->prepare("SELECT COALESCE(SUM(quantity),0) FROM cart WHERE user_id = ?");
$count->execute([$user_id]);
$total = (int)$count->fetchColumn();

echo json_encode(['ok' => true, 'cart_total' => $total]);
