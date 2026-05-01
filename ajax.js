/* =========================================================
   TechZone - ajax.js
   Communication asynchrone avec le serveur (fetch)
   (Partie 5 du sujet)
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* =====================================================
       1) Verification de l'email en AJAX (page inscription)
       ===================================================== */
    const regEmail = document.getElementById('reg-email');
    const regInfo  = document.getElementById('reg-email-info');
    if (regEmail && regInfo) {
        let timer;
        regEmail.addEventListener('input', () => {
            clearTimeout(timer);
            regInfo.textContent = '';
            timer = setTimeout(async () => {
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(regEmail.value)) return;
                try {
                    const r = await fetch('../back/check_email.php?email=' + encodeURIComponent(regEmail.value));
                    const d = await r.json();
                    if (d.ok) {
                        if (d.available) {
                            regInfo.textContent = 'Email disponible';
                            regInfo.style.color = 'var(--success)';
                        } else {
                            regInfo.textContent = 'Email deja utilise';
                            regInfo.style.color = 'var(--danger)';
                        }
                    }
                } catch (err) { /* silencieux */ }
            }, 400);
        });
    }

    /* =====================================================
       2) Recherche / filtrage en direct des produits (AJAX)
       ===================================================== */
    const search    = document.getElementById('search');
    const category  = document.getElementById('category');
    const list      = document.getElementById('product-list');
    const counter   = document.getElementById('result-count');

    if (list && (search || category)) {
        let searchTimer;

        const fetchProducts = async () => {
            const q   = search   ? search.value   : '';
            const cat = category ? category.value : 'all';

            try {
                const url = '../back/get_products.php?q=' + encodeURIComponent(q)
                          + '&category=' + encodeURIComponent(cat);
                const res = await fetch(url);
                const data = await res.json();

                // Mise a jour DYNAMIQUE de la liste (sans rechargement de la page)
                list.innerHTML = '';
                if (data.products.length === 0) {
                    list.innerHTML = '<p class="alert alert-info" style="grid-column:1/-1">Aucun produit trouve.</p>';
                } else {
                    data.products.forEach(p => {
                        const card = document.createElement('article');
                        card.className = 'product-card';
                        card.dataset.id = p.id;
                        card.innerHTML = `
                            <img src="../images/${p.image}" alt="${p.name}" onerror="this.src='../images/placeholder.svg'">
                            <h3>${p.name}</h3>
                            <p class="cat">${p.category}</p>
                            <p class="desc">${p.description}</p>
                            <p class="price">${parseFloat(p.price).toFixed(2).replace('.', ',')} DT</p>
                            <button class="btn add-cart-btn" data-id="${p.id}">Ajouter au panier</button>
                        `;
                        list.appendChild(card);
                    });
                }
                if (counter) counter.textContent = data.count + ' produit' + (data.count > 1 ? 's' : '');
            } catch (err) {
                window.showToast && showToast('Erreur reseau', 'error');
            }
        };

        if (search) {
            search.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(fetchProducts, 250);
            });
        }
        if (category) category.addEventListener('change', fetchProducts);
    }

    /* =====================================================
       3) Ajout au panier (AJAX)
       ===================================================== */
    if (list) {
        list.addEventListener('click', async (e) => {
            const btn = e.target.closest('.add-cart-btn');
            if (!btn) return;
            const productId = btn.dataset.id;

            try {
                const fd = new FormData();
                fd.append('product_id', productId);
                fd.append('quantity', 1);

                const res = await fetch('../back/add_to_cart.php', { method: 'POST', body: fd });
                const data = await res.json();

                if (data.ok) {
                    showToast('Produit ajoute au panier', 'success');
                    const badge = document.getElementById('cart-badge');
                    if (badge) badge.textContent = data.cart_total;
                } else if (data.error === 'auth') {
                    showToast('Veuillez vous connecter', 'error');
                    setTimeout(() => location.href = 'auth.php', 1200);
                } else {
                    showToast('Erreur lors de l\'ajout', 'error');
                }
            } catch (err) {
                showToast('Erreur reseau', 'error');
            }
        });
    }

    /* =====================================================
       4) Mise a jour quantite + suppression dans le panier
       ===================================================== */
    const cartTable = document.querySelector('.cart-table');
    if (cartTable) {

        // Recalcul du total
        const recalcTotal = () => {
            let total = 0, items = 0;
            cartTable.querySelectorAll('tbody tr').forEach(row => {
                const price = parseFloat(row.dataset.price);
                const qty   = parseInt(row.querySelector('.qty-input').value, 10) || 1;
                const sub   = price * qty;
                row.querySelector('.subtotal').textContent = sub.toFixed(2).replace('.', ',') + ' DT';
                total += sub;
                items += qty;
            });
            document.getElementById('cart-total').textContent = total.toFixed(2).replace('.', ',') + ' DT';
            const badge = document.getElementById('cart-badge');
            if (badge) badge.textContent = items;
        };

        // Modification quantite
        cartTable.addEventListener('change', async (e) => {
            if (!e.target.classList.contains('qty-input')) return;
            const row = e.target.closest('tr');
            const cartId = row.dataset.cartId;
            const qty = Math.max(1, parseInt(e.target.value, 10) || 1);
            e.target.value = qty;

            try {
                const fd = new FormData();
                fd.append('cart_id', cartId);
                fd.append('quantity', qty);
                const res = await fetch('../back/update_cart.php', { method: 'POST', body: fd });
                const d = await res.json();
                if (d.ok) {
                    recalcTotal();
                    showToast('Quantite mise a jour', 'success');
                }
            } catch (err) {
                showToast('Erreur reseau', 'error');
            }
        });

        // Suppression
        cartTable.addEventListener('click', async (e) => {
            const btn = e.target.closest('.remove-btn');
            if (!btn) return;
            const row = btn.closest('tr');
            const cartId = row.dataset.cartId;

            if (!confirm('Supprimer ce produit du panier ?')) return;

            try {
                const fd = new FormData();
                fd.append('cart_id', cartId);
                const res = await fetch('../back/delete_cart.php', { method: 'POST', body: fd });
                const d = await res.json();
                if (d.ok) {
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();                    // suppression dynamique
                        if (!cartTable.querySelector('tbody tr')) {
                            location.reload();           // panier vide -> recharger pour message
                        } else {
                            recalcTotal();
                        }
                    }, 300);
                    showToast('Produit retire', 'success');
                }
            } catch (err) {
                showToast('Erreur reseau', 'error');
            }
        });

        // Bouton checkout (demo)
        const co = document.getElementById('checkout-btn');
        if (co) co.addEventListener('click', () => {
            showToast('Commande envoyee (demo)', 'success');
        });
    }

});
