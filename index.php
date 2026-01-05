<?php
/**
 * ===================================================================
 * PROJET DE SYNTHÈSE : MARKETPLACE AVEC LARAVEL 12
 * ===================================================================
 * 
 * Ce fichier est le point d'entrée principal du cours (Page Unique).
 * Il assemble toutes les parties dans l'ordre.
 */

// 1. Charger la configuration du cours
require_once 'config.php';

// 2. Afficher l'en-tête (HTML head, sommaire, menu flottant)
require_once './layout/header.php';

require_once './partials/seance_01.php'; // Fondations & Catalogue
require_once './partials/seance_02.php'; // Auth & Rôles
/*
require_once './partials/seance_03.php';
require_once './partials/seance_04.php';
require_once './partials/seance_05.php';
require_once './partials/seance_06.php';
require_once './partials/seance_07.php';
require_once './partials/seance_08.php';
require_once './partials/seance_09.php';
require_once './partials/seance_10.php';
*/

// 4. Afficher le pied de page (Conclusion, footer)
require_once './layout/footer.php';
?>
