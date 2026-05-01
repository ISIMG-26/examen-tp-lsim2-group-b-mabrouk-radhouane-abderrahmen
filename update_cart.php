<?php
// =========================================================
// AJAX endpoint : mise a jour de la quantite d'un article
// =========================================================
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['ok' => false, 'error' => 'auth']);
    exit;
}

$cart_id  = (int)($_POST['cart_id']  ?? 0);
$quantity = max(1, (int)($_POST['quantity'] ?? 1));
$user_id  = (int)$_SESSION['user_id'];

$stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
$stmt->execute([$quantity, $cart_id, $user_id]);

echo json_encode(['ok' => true]);
