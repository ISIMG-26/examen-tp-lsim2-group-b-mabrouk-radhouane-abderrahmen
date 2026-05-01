<?php
session_start();
$flash = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_error']);
$tab   = $_GET['tab'] ?? 'login';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Connexion / Inscription</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="../index.php" class="logo">Tech<span>Zone</span></a>
        <nav class="main-nav">
            <ul>
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="products.php">Produits</a></li>
                <li><a href="cart.php">Panier <span id="cart-badge" class="badge">0</span></a></li>
                <li><a href="about.html">A propos</a></li>
                <li><a href="auth.php" class="btn active">Connexion</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container auth-page">
    <h1>Bienvenue sur TechZone</h1>

    <?php if ($flash): ?>
        <div class="alert alert-error"><?= $flash ?></div>
    <?php endif; ?>

    <div class="auth-tabs">
        <button class="tab-btn <?= $tab === 'login'    ? 'active' : '' ?>" data-tab="login">Connexion</button>
        <button class="tab-btn <?= $tab === 'register' ? 'active' : '' ?>" data-tab="register">Inscription</button>
    </div>

    <!-- ===== Formulaire de CONNEXION ===== -->
    <section id="tab-login" class="tab-pane <?= $tab === 'login' ? 'active' : '' ?>">
        <form action="../back/login.php" method="POST" id="login-form" novalidate>
            <div class="field">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" required>
                <small class="error-msg" id="login-email-err"></small>
            </div>
            <div class="field">
                <label for="login-password">Mot de passe</label>
                <input type="password" id="login-password" name="password" required>
                <small class="error-msg" id="login-password-err"></small>
            </div>
            <button type="submit" class="btn btn-large">Se connecter</button>
            <p class="hint">Compte demo : demo@techzone.tn / demo1234</p>
        </form>
    </section>

    <!-- ===== Formulaire d'INSCRIPTION ===== -->
    <section id="tab-register" class="tab-pane <?= $tab === 'register' ? 'active' : '' ?>">
        <form action="../back/register.php" method="POST" id="register-form" novalidate>
            <div class="field">
                <label for="reg-name">Nom complet</label>
                <input type="text" id="reg-name" name="name" required minlength="2">
                <small class="error-msg" id="reg-name-err"></small>
            </div>
            <div class="field">
                <label for="reg-email">Email</label>
                <input type="email" id="reg-email" name="email" required>
                <small class="error-msg" id="reg-email-err"></small>
                <small class="info-msg" id="reg-email-info"></small>
            </div>
            <div class="field">
                <label for="reg-password">Mot de passe</label>
                <input type="password" id="reg-password" name="password" required minlength="6">
                <small class="error-msg" id="reg-password-err"></small>
            </div>
            <div class="field">
                <label for="reg-confirm">Confirmer le mot de passe</label>
                <input type="password" id="reg-confirm" name="confirm" required>
                <small class="error-msg" id="reg-confirm-err"></small>
            </div>
            <button type="submit" class="btn btn-large">Creer mon compte</button>
        </form>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; 2025-2026 TechZone - Mini-projet LSIM 2</p>
    </div>
</footer>

<script src="../js/main.js"></script>
<script src="../js/validation.js"></script>
<script src="../js/ajax.js"></script>
</body>
</html>
