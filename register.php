<?php
// =========================================================
// Traitement de l'inscription utilisateur
// =========================================================
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../html/auth.php');
    exit;
}

$name     = trim($_POST['name']     ?? '');
$email    = trim($_POST['email']    ?? '');
$password = $_POST['password']      ?? '';
$confirm  = $_POST['confirm']       ?? '';

$errors = [];

if ($name === '' || mb_strlen($name) < 2) {
    $errors[] = "Le nom doit contenir au moins 2 caracteres.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'adresse email est invalide.";
}
if (strlen($password) < 6) {
    $errors[] = "Le mot de passe doit contenir au moins 6 caracteres.";
}
if ($password !== $confirm) {
    $errors[] = "Les mots de passe ne correspondent pas.";
}

// Verifier l'unicite de l'email
if (empty($errors)) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = "Cet email est deja utilise.";
    }
}

if (!empty($errors)) {
    $_SESSION['flash_error'] = implode('<br>', $errors);
    header('Location: ../html/auth.php?tab=register');
    exit;
}

// INSERT en base
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $hash]);

$_SESSION['user_id']   = (int)$pdo->lastInsertId();
$_SESSION['user_name'] = $name;

header('Location: ../html/products.php');
exit;
