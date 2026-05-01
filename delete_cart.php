<?php
// =========================================================
// AJAX endpoint : suppression d'un article du panier
// =========================================================
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['ok' => false, 'error' => 'auth']);
    exit;
}

$cart_id = (int)($_POST['cart_id'] ?? 0);
$user_id = (int)$_SESSION['user_id'];

$stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$stmt->execute([$cart_id, $user_id]);

echo json_encode(['ok' => true, 'removed' => $stmt->rowCount()]);
