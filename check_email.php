<?php
// =========================================================
// AJAX endpoint : verification d'unicite de l'email
// =========================================================
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

$email = trim($_GET['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'available' => false, 'reason' => 'invalid']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

echo json_encode([
    'ok'        => true,
    'available' => !$stmt->fetch(),
]);
