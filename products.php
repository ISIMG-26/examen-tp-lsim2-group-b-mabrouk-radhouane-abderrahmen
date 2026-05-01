<?php
session_start();
require_once __DIR__ . '/../back/db.php';

// Liste initiale (SELECT) - le filtrage en direct se fera en AJAX
$products   = $pdo->query("SELECT id, name, description, price, image, category, stock FROM products ORDER BY name")->fetchAll();
$categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Produits</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="../index.php" class="logo">Tech<span>Zone</span></a>
        <nav class="main-nav">
            <ul>
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="products.php" class="active">Produits</a></li>
                <li><a href="cart.php">Panier <span id="cart-badge" class="badge">0</span></a></li>
                <li><a href="about.html">A propos</a></li>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li class="user-pill">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?></li>
                    <li><a href="../back/logout.php" class="btn-outline">Deconnexion</a></li>
                <?php else: ?>
                    <li><a href="auth.php" class="btn">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="container products-page">
    <h1>Nos produits</h1>

    <section class="filters">
        <div class="field">
            <label for="search">Rechercher</label>
            <input type="search" id="search" placeholder="Nom du produit...">
        </div>
        <div class="field">
            <label for="category">Categorie</label>
            <select id="category">
                <option value="all">Toutes</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <p class="result-count" id="result-count"><?= count($products) ?> produits</p>
    </section>

    <section id="product-list" class="grid-4">
        <?php foreach ($products as $p): ?>
            <article class="product-card" data-id="<?= $p['id'] ?>">
                <img src="../images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" onerror="this.src='../images/placeholder.svg'">
                <h3><?= htmlspecialchars($p['name']) ?></h3>
                <p class="cat"><?= htmlspecialchars($p['category']) ?></p>
                <p class="desc"><?= htmlspecialchars($p['description']) ?></p>
                <p class="price"><?= number_format($p['price'], 2, ',', ' ') ?> DT</p>
                <button class="btn add-cart-btn" data-id="<?= $p['id'] ?>">Ajouter au panier</button>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<!-- Toast notifications (manipule dynamiquement par JS) -->
<div id="toast" class="toast" aria-live="polite"></div>

<footer class="site-footer">
    <div class="container">
        <p>&copy; 2025-2026 TechZone - Mini-projet LSIM 2</p>
    </div>
</footer>

<script src="../js/main.js"></script>
<script src="../js/ajax.js"></script>
</body>
</html>
