<?php
session_start();
require_once __DIR__ . '/../back/db.php';

$loggedIn = !empty($_SESSION['user_id']);
$items = [];
$total = 0;

if ($loggedIn) {
    $stmt = $pdo->prepare("
        SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.price, p.image, p.category
        FROM cart c
        JOIN products p ON p.id = c.product_id
        WHERE c.user_id = ?
        ORDER BY c.added_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $items = $stmt->fetchAll();
    foreach ($items as $i) {
        $total += $i['price'] * $i['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Mon panier</title>
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
                <li><a href="cart.php" class="active">Panier <span id="cart-badge" class="badge"><?= array_sum(array_column($items, 'quantity')) ?></span></a></li>
                <li><a href="about.html">A propos</a></li>
                <?php if ($loggedIn): ?>
                    <li class="user-pill">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?></li>
                    <li><a href="../back/logout.php" class="btn-outline">Deconnexion</a></li>
                <?php else: ?>
                    <li><a href="auth.php" class="btn">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="container cart-page">
    <h1>Mon panier</h1>

    <?php if (!$loggedIn): ?>
        <div class="alert alert-info">
            Vous devez <a href="auth.php">vous connecter</a> pour acceder a votre panier.
        </div>
    <?php elseif (empty($items)): ?>
        <div class="alert alert-info">
            Votre panier est vide. <a href="products.php">Decouvrir les produits</a>.
        </div>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Categorie</th>
                    <th>Prix unitaire</th>
                    <th>Quantite</th>
                    <th>Sous-total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i): ?>
                    <tr data-cart-id="<?= $i['cart_id'] ?>" data-price="<?= $i['price'] ?>">
                        <td class="product-cell">
                            <img src="../images/<?= htmlspecialchars($i['image']) ?>" alt="<?= htmlspecialchars($i['name']) ?>" onerror="this.src='../images/placeholder.svg'">
                            <span><?= htmlspecialchars($i['name']) ?></span>
                        </td>
                        <td><?= htmlspecialchars($i['category']) ?></td>
                        <td><?= number_format($i['price'], 2, ',', ' ') ?> DT</td>
                        <td>
                            <input type="number" class="qty-input" min="1" value="<?= (int)$i['quantity'] ?>">
                        </td>
                        <td class="subtotal"><?= number_format($i['price'] * $i['quantity'], 2, ',', ' ') ?> DT</td>
                        <td><button class="btn-danger remove-btn">Supprimer</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="total-label">Total :</td>
                    <td id="cart-total" colspan="2"><?= number_format($total, 2, ',', ' ') ?> DT</td>
                </tr>
            </tfoot>
        </table>

        <div class="cart-actions">
            <a href="products.php" class="btn-outline">Continuer mes achats</a>
            <button id="checkout-btn" class="btn btn-large">Passer commande</button>
        </div>
    <?php endif; ?>
</main>

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
