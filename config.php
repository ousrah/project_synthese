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
        ['id' => 'seance1-install', 'title' => "1.2 Installation & Packages"],
        // ['id' => 'seance1-schema', 'title' => "1.2 Schéma de Base de Données"], // Pas de section ID dans le fichier
        ['id' => 'seance1-migrations', 'title' => "1.3 Migrations : Products & Categories"],
        ['id' => 'seance1-models', 'title' => "1.4 Modèles Eloquent"],
        ['id' => 'seance1-seeders', 'title' => "1.5 Seeders de Démonstration"],
        ['id' => 'seance1-routes', 'title' => "1.6 Routes & HomeController"],
        ['id' => 'seance1-views', 'title' => "1.7 Vues Blade : Layout & Catalogue"],
    ],
    "Séance 2 : Authentification Breeze & Rôles" => [
        ['id' => 'seance2-breeze', 'title' => "2.1 Installation de Laravel Breeze"],
        ['id' => 'seance2-restore', 'title' => "2.1b Restauration Fichiers"],
        ['id' => 'seance2-email', 'title' => "2.2 Activation Email (SMTP)"],
        ['id' => 'seance2-login', 'title' => "2.3 Personnalisation Login"],
        ['id' => 'seance2-spatie', 'title' => "2.4 Installation Spatie Permission"],
        ['id' => 'seance2-users-migration', 'title' => "2.4a Table Users (Champs Vendor)"],
        ['id' => 'seance2-middleware', 'title' => "2.4b Config Middleware"],
        ['id' => 'seance2-user-model', 'title' => "2.5 Modèle User & Traits"],
        ['id' => 'seance2-roles', 'title' => "2.6 Seeder des Rôles"],
        ['id' => 'seance2-redirect', 'title' => "2.7 Redirection après Login"],
        ['id' => 'seance2-controllers', 'title' => "2.8 Contrôleurs Dashboards"],
        ['id' => 'seance2-routes', 'title' => "2.9 Route Grouping"],
        ['id' => 'seance2-views', 'title' => "2.10 Vues des Dashboards"],
    ],
    "Séance 3 : Multi-Vendeurs (Stores)" => [
        ['id' => 'seance3-intro', 'title' => "3.1 Introduction Vendor"],
        ['id' => 'seance3-routes', 'title' => "3.2 Routes & Middleware Vendor"],
        ['id' => 'seance3-store-model', 'title' => "3.3a Mise à jour Modèle Store"],
        ['id' => 'seance3-controller', 'title' => "3.3 Contrôleur Store"],
        ['id' => 'seance3-views', 'title' => "3.4 Vue Création Boutique"],
        ['id' => 'seance3-nav', 'title' => "3.5 Navigation"],
        ['id' => 'seance3-verification', 'title' => "3.6 Vérification Finale"],
    ],
    "Séance 4 : Gestion Catégories (Admin)" => [
        ['id' => 'seance4-intro', 'title' => "4.1 Intro Gestion Catégories"],
        ['id' => 'seance4-model', 'title' => "4.2 Modèle Category (Media)"],
        ['id' => 'seance4-controller', 'title' => "4.3 CategoryController"],
        ['id' => 'seance4-routes', 'title' => "4.4 Routes Admin Resource"],
        ['id' => 'seance4-views', 'title' => "4.5 Vues CRUD Catégories"],
        ['id' => 'seance4-verify', 'title' => "4.6 Vérification"],
    ],
    "Séance 5 : Gestion Produits (Vendeur)" => [
        ['id' => 'seance5-intro', 'title' => "5.1 Config Multi-langues (Prérequis)"],
        ['id' => 'seance5-product-media', 'title' => "5.2 Modèle Product (Media)"],
        ['id' => 'seance5-routes', 'title' => "5.3 Routes Vendeur Products"],
        ['id' => 'seance5-controller', 'title' => "5.4 ProductController"],
        ['id' => 'seance5-views', 'title' => "5.5 Vues Formulaire Produit"],
    ],
    "Séance 6 : Panier (JS/Session)" => [
        ['id' => 'seance6-intro', 'title' => "6.1 Intro Architecture Panier"],
        ['id' => 'seance6-api', 'title' => "6.2 API CartController"],
        ['id' => 'seance6-routes', 'title' => "6.3 Routes API"],
        ['id' => 'seance6-javascript', 'title' => "6.4 Logic JS (Cart.js)"],
        ['id' => 'seance6-view', 'title' => "6.5 Vue Panier"],
        ['id' => 'seance6-buttons', 'title' => "6.6 Boutons & Intégration"],
    ],
    "Séance 7 : Commandes (Order & OrderItem)" => [
        ['id' => 'seance7-migrations', 'title' => "7.1 Migrations"],
        // A venir...
    ],
    "Séance 8 : Paiements Stripe" => [
        ['id' => 'seance8-install', 'title' => "8.1 Installation"],
        // A venir...
    ],
    "Séance 9 : Dashboard Admin & Modération" => [
        ['id' => 'seance9-vendors', 'title' => "9.1 Gestion Vendors"],
        // A venir...
    ],
    "Séance 10 : Finalisation" => [
        ['id' => 'seance10-reviews-migration', 'title' => "10.1 Reviews"],
        // A venir...
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
