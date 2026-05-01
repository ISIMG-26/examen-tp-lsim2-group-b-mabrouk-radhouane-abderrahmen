#  Mini-projet E-commerce

> LSIM 2 — Technologies & Programmation Web 
> Mini-projet / Examen TP — encadré par Mme Neilla CHETTAOUI.

TechZone est une mini-application e-commerce dédiée à la vente de matériel
informatique (ordinateurs, smartphones, accessoires). Elle a été développée
en **HTML5 sémantique, CSS3, JavaScript natif, AJAX, PHP natif et MySQL**,
sans aucun framework ni template, conformément aux contraintes du sujet.

---

## Membres du groupe

| Nom & Prénom | Section |
|--------------|---------|
|  radhouane dadi| Groupe B |
| abderrahmen dabbek |Groupe B  |
| mabrouk brahim | Groupe B |

## Répartition des tâches

| Membre | Responsabilités |
|--------|-----------------|
| Membre 1 | Structure HTML, design CSS, intégration des pages |
| Membre 2 | JavaScript (DOM, validation, AJAX), interactivité |
| Membre 3 | Backend PHP, base de données MySQL,  |

---

## Installation

1. Démarrer  **XAMPP** (Apache + MySQL).
2. Copier le dossier du projet dans `htdocs/` (XAMPP).
3. Ouvrir **phpMyAdmin** → onglet *SQL* → importer / exécuter le fichier
   `database/script.sql`. Cela crée la base `techzone`, les tables et des
   données de démonstration.
4. Ouvrir dans le navigateur : `http://localhost/mabrouk/index.php`.

### Compte de démonstration

- **Email :** 'mabrouk.brahim@isimg.tn'
- **Mot de passe :** `azerty`

---

## Structure du projet

```
/project-root
├── index.php              # Page d'accueil (PHP + SELECT featured)
├── README.md
│
├── html/
│   ├── auth.php           # Connexion + inscription (onglets)
│   ├── products.php       # Catalogue avec filtres AJAX
│   ├── cart.php           # Panier (modif quantité, suppression)
│   └── about.html         # Page "À propos" + démo DOM (compteur)
│
├── css/
│   └── style.css          # Feuille de style globale
│
├── js/
│   ├── main.js            # DOM, événements, onglets, compteur
│   ├── validation.js      # Validation des formulaires côté client
│   └── ajax.js            # Communication asynchrone (fetch)
│
├── images/                # Visuels SVG des produits
│
├── back/                  # Scripts PHP côté serveur
│   ├── db.php             # Connexion PDO MySQL
│   ├── login.php          # Traitement connexion
│   ├── register.php       # Traitement inscription
│   ├── logout.php
│   ├── check_email.php    # AJAX : vérifie l'unicité d'un email
│   ├── get_products.php   # AJAX : recherche / filtrage produits
│   ├── add_to_cart.php    # AJAX : INSERT panier
│   ├── update_cart.php    # AJAX : UPDATE quantité
│   └── delete_cart.php    # AJAX : DELETE article
│
└── database/
    └── script.sql         # Schéma + données de démo
```

---

## Couverture des parties du sujet

| Partie | Sujet | Implémentation |
|---|---|---|
| 1 | Structure HTML & sémantique | `header`, `nav`, `main`, `section`, `article`, `footer` sur toutes les pages |
| 2 | CSS externe | `css/style.css` (un fichier unique cohérent, responsive) |
| 3 | DOM JavaScript | `js/main.js` — onglets, compteur (`createElement`, `removeChild`), badge panier |
| 4 | Validation formulaires | `js/validation.js` — temps réel + blocage `submit` si invalide |
| 5 | AJAX | `js/ajax.js` — `fetch()` pour recherche, vérification email, panier (sans rechargement) |
| 6 | PHP back-end | `$_POST`/`$_GET`, scripts séparés par fonctionnalité, PDO préparé |
| 7 | MySQL | 3 tables liées (`users`, `products`, `cart`) + INSERT/SELECT/UPDATE/DELETE |
| 8 | Qualité interface | Design moderne, responsive, navigation intuitive, toasts |

---
## REMARQUE general
Nous souhaitons vous informer de l’avancement de notre projet.

Tout d’abord, nous travaillons actuellement avec un seul ordinateur, ce qui rend l’organisation du travail un peu plus difficile. Malgré cela, nous avons réussi à développer l’ensemble du projet comme demandé.

Concernant GitHub, nous tenons à préciser qu’au début, nous ne maîtrisions pas bien son utilisation. Nous avons donc préféré nous concentrer principalement sur le développement de l’application afin d’assurer un bon fonctionnement du projet.

Une fois le développement terminé, nous avons créé le dépôt et ajouté le projet complet sur GitHub.

Merci pour votre compréhension.




