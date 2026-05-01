<?php
session_start();
require_once __DIR__ . '/back/db.php';

// Recuperation de quelques produits a la une (SELECT)
$featured = $pdo->query("SELECT id, name, price, image, category FROM products ORDER BY created_at DESC LIMIT 4")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo">Tech<span>Zone</span></a>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php" class="active">Accueil</a></li>
                <li><a href="html/products.php">Produits</a></li>
                <li><a href="html/cart.php">Panier <span id="cart-badge" class="badge">0</span></a></li>
                <li><a href="html/about.html">A propos</a></li>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li class="user-pill">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?></li>
                    <li><a href="back/logout.php" class="btn-outline">Deconnexion</a></li>
                <?php else: ?>
                    <li><a href="html/auth.php" class="btn">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero-inner">
            <div class="hero-text">
                <h1>La technologie a portee de clic</h1>
                <p>Decouvrez les meilleurs produits high-tech a des prix imbattables. Livraison rapide partout en Tunisie.</p>
                <a href="html/products.php" class="btn btn-large">Explorer les produits</a>
            </div>
            <div class="hero-art" aria-hidden="true">
                <div class="blob"></div>
            </div>
        </div>
    </section>

    <section class="container features">
        <h2>Pourquoi choisir TechZone ?</h2>
        <div class="grid-3">
            <article class="feature-card">
                <div class="icon">+</div>
                <h3>Large choix</h3>
                <p>Plus de centaines de produits issus des meilleures marques.</p>
            </article>
            <article class="feature-card">
                <div class="icon">v</div>
                <h3>Garantie 2 ans</h3>
                <p>Tous nos produits sont garantis 24 mois piece et main d'oeuvre.</p>
            </article>
            <article class="feature-card">
                <div class="icon">&gt;</div>
                <h3>Livraison express</h3>
                <p>Recevez vos commandes en 24h dans toutes les grandes villes.</p>
            </article>
        </div>
    </section>

    <section class="container featured">
        <h2>A la une</h2>
        <div class="grid-4">
            <?php foreach ($featured as $p): ?>
                <article class="product-card">
                    <img src="images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" onerror="this.src='images/placeholder.svg'">
                    <h3><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="cat"><?= htmlspecialchars($p['category']) ?></p>
                    <p class="price"><?= number_format($p['price'], 2, ',', ' ') ?> DT</p>
                    <a class="btn" href="html/products.php">Voir</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; 2025-2026 TechZone - Mini-projet LSIM 2</p>
    </div>
</footer>

<script src="js/main.js"></script>
</body>
</html>
