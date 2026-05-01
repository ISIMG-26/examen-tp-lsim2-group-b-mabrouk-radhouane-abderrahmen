/* =========================================================
   TechZone - validation.js
   Validation des formulaires cote client
   (Partie 4 du sujet)
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* ----- Outils de validation ----- */
    const isEmail   = v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    const isStrong  = v => v.length >= 6;        // Min 6 caracteres
    const setError  = (id, msg) => {
        const el = document.getElementById(id + '-err');
        const input = document.getElementById(id);
        if (el) el.textContent = msg;
        if (input) {
            input.classList.toggle('invalid', !!msg);
            input.classList.toggle('valid',   !msg && input.value !== '');
        }
    };

    /* =====================================================
       FORMULAIRE DE CONNEXION
       ===================================================== */
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        const email = document.getElementById('login-email');
        const pass  = document.getElementById('login-password');

        // Validation en temps reel
        email.addEventListener('input', () => {
            if (!email.value)            setError('login-email', 'Email requis');
            else if (!isEmail(email.value)) setError('login-email', 'Format email invalide');
            else                          setError('login-email', '');
        });
        pass.addEventListener('input', () => {
            if (!pass.value) setError('login-password', 'Mot de passe requis');
            else             setError('login-password', '');
        });

        loginForm.addEventListener('submit', (e) => {
            let ok = true;
            if (!email.value || !isEmail(email.value)) {
                setError('login-email', 'Email invalide'); ok = false;
            }
            if (!pass.value) {
                setError('login-password', 'Mot de passe requis'); ok = false;
            }
            if (!ok) e.preventDefault();   // BLOQUE la soumission
        });
    }

    /* =====================================================
       FORMULAIRE D'INSCRIPTION
       ===================================================== */
    const regForm = document.getElementById('register-form');
    if (regForm) {
        const name    = document.getElementById('reg-name');
        const email   = document.getElementById('reg-email');
        const pass    = document.getElementById('reg-password');
        const confirm = document.getElementById('reg-confirm');

        name.addEventListener('input', () => {
            if (!name.value || name.value.trim().length < 2)
                setError('reg-name', 'Au moins 2 caracteres');
            else
                setError('reg-name', '');
        });

        email.addEventListener('input', () => {
            if (!email.value)             setError('reg-email', 'Email requis');
            else if (!isEmail(email.value)) setError('reg-email', 'Format email invalide');
            else                           setError('reg-email', '');
        });

        pass.addEventListener('input', () => {
            if (!pass.value)        setError('reg-password', 'Mot de passe requis');
            else if (!isStrong(pass.value)) setError('reg-password', 'Au moins 6 caracteres');
            else                     setError('reg-password', '');

            // Verifier aussi la confirmation
            if (confirm.value && pass.value !== confirm.value)
                setError('reg-confirm', 'Les mots de passe ne correspondent pas');
            else if (confirm.value)
                setError('reg-confirm', '');
        });

        confirm.addEventListener('input', () => {
            if (!confirm.value)             setError('reg-confirm', 'Veuillez confirmer');
            else if (confirm.value !== pass.value) setError('reg-confirm', 'Mots de passe differents');
            else                             setError('reg-confirm', '');
        });

        regForm.addEventListener('submit', (e) => {
            let ok = true;
            if (!name.value || name.value.trim().length < 2) {
                setError('reg-name', 'Au moins 2 caracteres'); ok = false;
            }
            if (!email.value || !isEmail(email.value)) {
                setError('reg-email', 'Email invalide'); ok = false;
            }
            if (!pass.value || !isStrong(pass.value)) {
                setError('reg-password', 'Au moins 6 caracteres'); ok = false;
            }
            if (pass.value !== confirm.value) {
                setError('reg-confirm', 'Les mots de passe ne correspondent pas'); ok = false;
            }
            if (!ok) e.preventDefault();   // BLOQUE la soumission
        });
    }

});
