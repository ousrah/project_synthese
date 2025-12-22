<?php
/**
 * ===================================================================
 * PROJET DE SYNTHÈSE : MARKETPLACE AVEC LARAVEL 12
 * ===================================================================
 * 
 * Ce fichier est le point d'entrée principal du cours.
 * Il assemble toutes les parties dans l'ordre.
 */

// 1. Charger la configuration du cours
require_once 'config.php';

// 2. Afficher l'en-tête (HTML head, sommaire)
require_once './layout/header.php';

// 3. Inclure le contenu de chaque séance
require_once './partials/seance_01.php';     // Fondations & Catalogue
require_once './partials/seance_02.php';     // Authentification & Rôles
require_once './partials/seance_03.php';     // Multi-Vendeurs & Boutiques
require_once './partials/seance_04.php';     // Panier & Commandes
require_once './partials/seance_05.php';     // Paiements (Stripe & PayPal)
require_once './partials/seance_06.php';     // Médias & Upload (Spatie)
require_once './partials/seance_07.php';     // Avis, Wishlist & Recherche
require_once './partials/seance_08.php';     // Dashboard Vendeur
require_once './partials/seance_09.php';     // Administration
require_once './partials/seance_10.php';     // Finalisation & Déploiement

// 4. Afficher le pied de page
require_once './layout/footer.php';
?>
