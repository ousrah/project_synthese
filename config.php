<?php
/**
 * ===================================================================
 * CONFIGURATION DU COURS - PROJET DE SYNTHÈSE BOUTIQUE MARKETPLACE
 * ===================================================================
 * 
 * Ce fichier définit la structure complète du cours progressif
 * pour reconstruire le projet Boutique Marketplace de A à Z.
 */

// Configuration générale du cours
define('COURSE_TITLE', 'Projet de Synthèse : Marketplace de Produits Numériques avec Laravel 12');
define('COURSE_SUBTITLE', 'Construire une plateforme e-commerce multi-vendeurs complète');
define('COURSE_AUTHOR', 'P. Rahmouni Oussama');
define('COURSE_LAST_UPDATE', 'Décembre 2025');
define('COURSE_DURATION', '');

// Structure du cours - Séances progressives
$course_parts = [
    "Séance 1 : Fondations & Catalogue" => [
        ['id' => 'seance1-intro', 'title' => "1.1 Introduction au Projet & Objectifs"],
        ['id' => 'seance1-install', 'title' => "1.2 Installation de Laravel 12 & Configuration"],
        ['id' => 'seance1-models', 'title' => "1.3 Modèles Product & Category (Migrations, Seeders)"],
        ['id' => 'seance1-layout', 'title' => "1.4 Layout Public & Affichage du Catalogue"],
    ],
    "Séance 2 : Authentification & Rôles" => [
        ['id' => 'seance2-breeze', 'title' => "2.1 Installation de Laravel Breeze"],
        ['id' => 'seance2-roles', 'title' => "2.2 Système de Rôles (Admin, Vendor, Customer)"],
        ['id' => 'seance2-middleware', 'title' => "2.3 Middlewares de Protection des Routes"],
        ['id' => 'seance2-dashboards', 'title' => "2.4 Création des Dashboards par Rôle"],
    ],
    "Séance 3 : Multi-Vendeurs & Boutiques" => [
        ['id' => 'seance3-store-model', 'title' => "3.1 Modèle Store & Migration"],
        ['id' => 'seance3-store-crud', 'title' => "3.2 CRUD Boutique Vendeur"],
        ['id' => 'seance3-products-vendor', 'title' => "3.3 Gestion des Produits par Vendeur"],
        ['id' => 'seance3-commission', 'title' => "3.4 Système de Commission"],
    ],
    "Séance 4 : Panier & Commandes" => [
        ['id' => 'seance4-cart-js', 'title' => "4.1 Panier JavaScript (localStorage)"],
        ['id' => 'seance4-order-models', 'title' => "4.2 Modèles Order & OrderItem"],
        ['id' => 'seance4-checkout', 'title' => "4.3 Page Checkout & Synchronisation Panier"],
        ['id' => 'seance4-order-history', 'title' => "4.4 Historique des Commandes Client"],
    ],
    "Séance 5 : Paiements (Stripe & PayPal)" => [
        ['id' => 'seance5-stripe', 'title' => "5.1 Intégration Stripe (Carte Bancaire)"],
        ['id' => 'seance5-paypal', 'title' => "5.2 Intégration PayPal"],
        ['id' => 'seance5-webhooks', 'title' => "5.3 Gestion des Webhooks de Paiement"],
        ['id' => 'seance5-download', 'title' => "5.4 Téléchargements après Paiement"],
    ],
    "Séance 6 : Médias & Upload de Fichiers" => [
        ['id' => 'seance6-spatie', 'title' => "6.1 Installation de Spatie Media Library"],
        ['id' => 'seance6-product-images', 'title' => "6.2 Images Multiples pour Produits"],
        ['id' => 'seance6-digital-files', 'title' => "6.3 Upload de Fichiers Numériques (Produits)"],
        ['id' => 'seance6-thumbnails', 'title' => "6.4 Génération de Miniatures"],
    ],
    "Séance 7 : Avis, Wishlist & Recherche" => [
        ['id' => 'seance7-reviews', 'title' => "7.1 Système d'Avis Clients"],
        ['id' => 'seance7-wishlist', 'title' => "7.2 Liste de Souhaits (Wishlist)"],
        ['id' => 'seance7-search', 'title' => "7.3 Recherche Avancée & Filtres"],
        ['id' => 'seance7-sorting', 'title' => "7.4 Tri & Pagination"],
    ],
    "Séance 8 : Dashboard Vendeur Complet" => [
        ['id' => 'seance8-sales', 'title' => "8.1 Vue des Ventes Vendeur"],
        ['id' => 'seance8-stats', 'title' => "8.2 Statistiques & Graphiques"],
        ['id' => 'seance8-payouts', 'title' => "8.3 Demandes de Paiement (Payouts)"],
        ['id' => 'seance8-products', 'title' => "8.4 Gestion Complète des Produits"],
    ],
    "Séance 9 : Administration" => [
        ['id' => 'seance9-admin-users', 'title' => "9.1 Gestion des Utilisateurs"],
        ['id' => 'seance9-admin-products', 'title' => "9.2 Modération des Produits"],
        ['id' => 'seance9-admin-orders', 'title' => "9.3 Gestion des Commandes"],
        ['id' => 'seance9-admin-settings', 'title' => "9.4 Paramètres Généraux"],
    ],
    "Séance 10 : Finalisation & Déploiement" => [
        ['id' => 'seance10-emails', 'title' => "10.1 Emails Transactionnels"],
        ['id' => 'seance10-seo', 'title' => "10.2 SEO & Optimisation"],
        ['id' => 'seance10-tests', 'title' => "10.3 Tests Automatisés (Pest)"],
        ['id' => 'seance10-deploy', 'title' => "10.4 Déploiement en Production"],
    ],
];

// Technologies utilisées dans ce projet
$technologies = [
    'Backend' => ['Laravel 12', 'PHP 8.3+', 'MySQL/MariaDB', 'Eloquent ORM'],
    'Frontend' => ['Blade', 'Bootstrap 5', 'Alpine.js', 'JavaScript ES6+'],
    'Paiements' => ['Stripe', 'PayPal (srmklive/paypal)'],
    'Médias' => ['Spatie Media Library', 'Intervention Image'],
    'Autres' => ['Spatie Translatable', 'Laravel Breeze', 'Vite'],
];
?>
