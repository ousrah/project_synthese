<?php
/**
 * ===================================================================
 * CONFIGURATION DU COURS - PROJET DE SYNTHÈSE BOUTIQUE MARKETPLACE
 * ===================================================================
 * 
 * Ce fichier définit la structure complète du cours progressif
 * pour reconstruire le projet Boutique Marketplace de A à Z.
 * 
 * ⚠️ IMPORTANT : Ce cours est basé UNIQUEMENT sur le code source
 * réel et opérationnel de l'application. Aucune réinvention !
 */

// Configuration générale du cours
define('COURSE_TITLE', 'Projet de Synthèse : Marketplace de Produits Numériques avec Laravel 12');
define('COURSE_SUBTITLE', 'Construire une plateforme e-commerce multi-vendeurs complète');
define('COURSE_AUTHOR', 'P. Rahmouni Oussama');
define('COURSE_LAST_UPDATE', 'Décembre 2025');
define('COURSE_DURATION', '10 séances');

// Structure du cours - Séances progressives
$course_parts = [
    "Séance 1 : Fondations & Catalogue Visiteur" => [
        ['id' => 'seance1-intro', 'title' => "1.1 Introduction au Projet"],
        ['id' => 'seance1-schema', 'title' => "1.2 Schéma de Base de Données (ERD)"],
        ['id' => 'seance1-install', 'title' => "1.3 Installation de Laravel 12"],
        ['id' => 'seance1-migrations', 'title' => "1.4 Migrations : Products & Categories"],
        ['id' => 'seance1-models', 'title' => "1.5 Modèles Eloquent & Relations"],
        ['id' => 'seance1-seeders', 'title' => "1.6 Seeders de Démonstration"],
        ['id' => 'seance1-routes', 'title' => "1.7 Routes & HomeController"],
        ['id' => 'seance1-views', 'title' => "1.8 Vues Blade : Layout & Catalogue"],
        ['id' => 'seance1-result', 'title' => "✅ Résultat : Page d'accueil fonctionnelle"],
    ],
    "Séance 2 : Authentification Breeze & Rôles" => [
        ['id' => 'seance2-breeze', 'title' => "2.1 Installation de Laravel Breeze"],
        ['id' => 'seance2-verification', 'title' => "2.2 Configuration Email Verification"],
        ['id' => 'seance2-spatie', 'title' => "2.3 Installation Spatie Permission"],
        ['id' => 'seance2-roles', 'title' => "2.4 Création des Rôles (Admin/Vendor/Customer)"],
        ['id' => 'seance2-middleware', 'title' => "2.5 Middlewares Personnalisés"],
        ['id' => 'seance2-dashboards', 'title' => "2.6 Dashboards par Rôle"],
        ['id' => 'seance2-result', 'title' => "✅ Résultat : Système d'authentification complet"],
    ],
    "Séance 3 : Multi-Vendeurs (Stores)" => [
        ['id' => 'seance3-migration', 'title' => "3.1 Migration : Table Stores"],
        ['id' => 'seance3-model', 'title' => "3.2 Modèle Store & Relations"],
        ['id' => 'seance3-routes', 'title' => "3.3 Routes Vendor/Store"],
        ['id' => 'seance3-controller', 'title' => "3.4 StoreController (CRUD)"],
        ['id' => 'seance3-views', 'title' => "3.5 Vues : Créer/Éditer une Boutique"],
        ['id' => 'seance3-dashboard', 'title' => "3.6 Dashboard Vendeur avec Infos Store"],
        ['id' => 'seance3-result', 'title' => "✅ Résultat : Vendeur peut créer sa boutique"],
    ],
    "Séance 4 : Gestion Catégories avec Spatie Media" => [
        ['id' => 'seance4-spatie-install', 'title' => "4.1 Installation Spatie Media Library"],
        ['id' => 'seance4-category-media', 'title' => "4.2 Configuration Category avec HasMedia"],
        ['id' => 'seance4-routes', 'title' => "4.3 Routes Admin/Categories"],
        ['id' => 'seance4-controller', 'title' => "4.4 CategoryController (CRUD complet)"],
        ['id' => 'seance4-views', 'title' => "4.5 Vues Admin : Gérer Catégories"],
        ['id' => 'seance4-upload', 'title' => "4.6 Upload d'Images avec Spatie"],
        ['id' => 'seance4-translatable', 'title' => "4.7 Spatie Translatable (Bonus)"],
        ['id' => 'seance4-result', 'title' => "✅ Résultat : CRUD catégories avec images"],
    ],
    "Séance 5 : Gestion Produits & Galerie Photos" => [
        ['id' => 'seance5-intro', 'title' => "5.1 Configuration Multi-langues (Prérequis)"],
        ['id' => 'seance5-product-media', 'title' => "5.2 Modèle Product avec Spatie Media"],
        ['id' => 'seance5-routes', 'title' => "5.2 Routes Vendor/Products"],
        ['id' => 'seance5-controller', 'title' => "5.3 ProductController Vendor (CRUD)"],
        ['id' => 'seance5-forms', 'title' => "5.4 Formulaires : Create/Edit Product"],
        ['id' => 'seance5-thumbnail', 'title' => "5.5 Upload Thumbnail"],
        ['id' => 'seance5-gallery', 'title' => "5.6 Galerie d'Images (Collection gallery)"],
        ['id' => 'seance5-files', 'title' => "5.7 Upload Fichier Principal (digital)"],
        ['id' => 'seance5-result', 'title' => "✅ Résultat : Vendeur gère ses produits"],
    ],
    "Séance 6 : Panier (Cart JavaScript/Session)" => [
        ['id' => 'seance6-api', 'title' => "6.1 API CartController (Session)"],
        ['id' => 'seance6-routes', 'title' => "6.2 Routes API Cart"],
        ['id' => 'seance6-javascript', 'title' => "6.3 JavaScript : cart.js (Fetch API)"],
        ['id' => 'seance6-view', 'title' => "6.4 Vue : Page Panier"],
        ['id' => 'seance6-buttons', 'title' => "6.5 Boutons Ajouter au Panier"],
        ['id' => 'seance6-badge', 'title' => "6.6 Badge Nombre d'Articles (Header)"],
        ['id' => 'seance6-result', 'title' => "✅ Résultat : Panier fonctionnel"],
    ],
    "Séance 7 : Commandes (Order & OrderItem)" => [
        ['id' => 'seance7-migrations', 'title' => "7.1 Migrations : Orders & OrderItems"],
        ['id' => 'seance7-models', 'title' => "7.2 Modèles Order & OrderItem"],
        ['id' => 'seance7-checkout-route', 'title' => "7.3 Routes Checkout"],
        ['id' => 'seance7-controller', 'title' => "7.4 PaymentController : checkout()"],
        ['id' => 'seance7-view', 'title' => "7.5 Vue Checkout : Récapitulatif"],
        ['id' => 'seance7-process', 'title' => "7.6 Créer la Commande (sans paiement)"],
        ['id' => 'seance7-history', 'title' => "7.7 Historique Commandes Client"],
        ['id' => 'seance7-result', 'title' => "✅ Résultat : Passer commande"],
    ],
    "Séance 8 : Paiements Stripe" => [
        ['id' => 'seance8-install', 'title' => "8.1 Installation Stripe PHP"],
        ['id' => 'seance8-config', 'title' => "8.2 Configuration Stripe"],
        ['id' => 'seance8-process', 'title' => "8.3 Méthode processStripe()"],
        ['id' => 'seance8-elements', 'title' => "8.4 Vue : Stripe Elements (carte)"],
        ['id' => 'seance8-javascript', 'title' => "8.5 JavaScript : Confirmer le paiement"],
        ['id' => 'seance8-webhooks', 'title' => "8.6 Webhooks Stripe (Bonus)"],
        ['id' => 'seance8-result', 'title' => "✅ Résultat : Paiement Stripe fonctionnel"],
    ],
    "Séance 9 : Dashboard Admin & Modération" => [
        ['id' => 'seance9-vendors', 'title' => "9.1 Gestion Vendors (Admin)"],
        ['id' => 'seance9-approve', 'title' => "9.2 Vérification de Boutiques"],
        ['id' => 'seance9-products', 'title' => "9.3 Modération des Produits"],
        ['id' => 'seance9-stats', 'title' => "9.4 Statistiques Dashboard Admin"],
        ['id' => 'seance9-sales', 'title' => "9.5 Vue Ventes Vendeur"],
        ['id' => 'seance9-result', 'title' => "✅ Résultat : Admin peut tout gérer"],
    ],
    "Séance 10 : Reviews, Recherche & Finalisation" => [
        ['id' => 'seance10-reviews-migration', 'title' => "10.1 Migration : Reviews"],
        ['id' => 'seance10-reviews-model', 'title' => "10.2 Modèle Review"],
        ['id' => 'seance10-reviews-api', 'title' => "10.3 API ReviewController"],
        ['id' => 'seance10-reviews-view', 'title' => "10.4 Avis sur Fiche Produit"],
        ['id' => 'seance10-search', 'title' => "10.5 Recherche Avancée & Filtres"],
        ['id' => 'seance10-optimization', 'title' => "10.6 Optimisations (Eager Loading, etc.)"],
        ['id' => 'seance10-deploy', 'title' => "10.7 Déploiement (Bonus)"],
        ['id' => 'seance10-result', 'title' => "✅ Résultat : Application complète !"],
    ],
];

// Technologies utilisées dans ce projet
$technologies = [
    'Backend' => ['Laravel 12', 'PHP 8.2+', 'MySQL/MariaDB', 'Eloquent ORM'],
    'Frontend' => ['Blade', 'Bootstrap 5', 'JavaScript ES6+', 'Fetch API'],
    'Paiements' => ['Stripe PHP'],
    'Médias' => ['Spatie Media Library'],
    'Auth & Permissions' => ['Laravel Breeze', 'Spatie Permission'],
    'Autres' => ['Spatie Translatable', 'Spatie Activitylog', 'Laravel Localization'],
];

// Prérequis pour suivre ce cours
$prerequisites = [
    'PHP bases moyennes (fonctions, classes, tableaux)',
    'Connaissance des concepts MVC',
    'Compréhension basique de SQL et relations (1-N, N-N)',
    'HTML/CSS de base',
    'Composer et npm installés sur la machine',
];

// Résultat attendu à chaque séance
$expected_results = [
    1 => "Page d'accueil avec catalogue de produits (grille Bootstrap)",
    2 => "Système d'inscription/connexion avec vérification email et dashboards",
    3 => "Vendeur peut créer sa boutique et voir son dashboard",
    4 => "Admin peut créer/modifier/supprimer des catégories avec photos",
    5 => "Vendeur peut gérer ses produits avec thumbnail et galerie d'images",
    6 => "Visiteurs peuvent ajouter des produits au panier et voir le total",
    7 => "Clients authentifiés peuvent passer commande et voir l'historique",
    8 => "Paiement Stripe fonctionnel avec carte bancaire",
    9 => "Admin peut modérer vendors et produits, voir les statistiques",
    10 => "Application complète avec avis clients et recherche avancée",
];
?>
