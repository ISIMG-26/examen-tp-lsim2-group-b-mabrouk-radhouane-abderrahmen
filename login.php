<?php
// =========================================================
// Traitement de la connexion utilisateur
// =========================================================
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../html/auth.php');
    exit;
}

$email    = trim($_POST['email']    ?? '');
$password = $_POST['password']      ?? '';

if ($email === '' || $password === '') {
    $_SESSION['flash_error'] = "Veuillez remplir tous les champs.";
    header('Location: ../html/auth.php');
    exit;
}

$stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['flash_error'] = "Email ou mot de passe incorrect.";
    header('Location: ../html/auth.php');
    exit;
}

$_SESSION['user_id']   = (int)$user['id'];
$_SESSION['user_name'] = $user['name'];

header('Location: ../html/products.php');
exit;
