/* =========================================================
   TechZone - main.js
   Manipulation du DOM + gestion des evenements
   (Partie 3 du sujet)
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* ---------- 1) Onglets de la page d'authentification ---------- */
    const tabBtns = document.querySelectorAll('.tab-btn');
    if (tabBtns.length) {
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.dataset.tab;

                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

                btn.classList.add('active');
                document.getElementById('tab-' + target).classList.add('active');
            });
        });
    }

    /* ---------- 2) Compteur interactif sur la page "A propos" ---------- */
    const counterEl = document.getElementById('counter-value');
    if (counterEl) {
        let count = 0;
        const incBtn = document.getElementById('inc-btn');
        const decBtn = document.getElementById('dec-btn');
        const reset  = document.getElementById('reset-btn');
        const list   = document.getElementById('dynamic-list');

        const render = () => { counterEl.textContent = count; };

        // Ajout dynamique d'elements (createElement / appendChild)
        incBtn.addEventListener('click', () => {
            count++;
            render();
            const li = document.createElement('li');
            li.textContent = 'Element #' + count + ' - cree dynamiquement';
            list.appendChild(li);
        });

        // Suppression dynamique d'elements (removeChild)
        decBtn.addEventListener('click', () => {
            if (count > 0) {
                count--;
                render();
                if (list.lastElementChild) {
                    list.removeChild(list.lastElementChild);
                }
            }
        });

        reset.addEventListener('click', () => {
            count = 0;
            render();
            list.innerHTML = '';   // modification dynamique du contenu HTML
        });
    }

    /* ---------- 3) Mise a jour du badge "panier" depuis localStorage cache ---------- */
    const cartBadge = document.getElementById('cart-badge');
    if (cartBadge && cartBadge.textContent === '0') {
        // (re)synchronise le badge a partir du nombre de lignes du tableau panier si on est dessus
        const rows = document.querySelectorAll('.cart-table tbody tr');
        if (rows.length) {
            let total = 0;
            rows.forEach(r => {
                const qty = r.querySelector('.qty-input');
                total += qty ? parseInt(qty.value, 10) || 0 : 0;
            });
            cartBadge.textContent = total;
        }
    }

});

/* =========================================================
   Helper : afficher un message "toast" temporaire
   (utilisable depuis ajax.js)
   ========================================================= */
window.showToast = function(message, type = '') {
    const el = document.getElementById('toast');
    if (!el) { alert(message); return; }
    el.textContent = message;
    el.className = 'toast show ' + type;
    clearTimeout(window._toastTimer);
    window._toastTimer = setTimeout(() => {
        el.className = 'toast ' + type;
    }, 2800);
};
