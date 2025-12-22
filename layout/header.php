<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(COURSE_TITLE) ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Polices Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Styles personnalisés -->
    <link href="../style.css" rel="stylesheet">
    
    <!-- Barre de progression de lecture -->
    <style>
        #reading-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            z-index: 9999;
            transition: width 0.1s ease;
        }
    </style>
</head>
<body class="antialiased" id="page-top">
    <!-- Barre de progression -->
    <div id="reading-progress" style="width: 0%;"></div>

<main class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
    
    <!-- En-tête de la page -->
    <div class="flex justify-center my-8">
        <a href="https://ousrah.portal-edu.com/cv/">
            <div class="flex items-center space-x-4">
                <img src="assets/images/author.png" alt="Photo de P. Rahmouni Oussama" 
                     class="w-24 h-24 rounded-full border-2 border-gray-300 p-px object-cover"
                     onerror="this.src='https://ui-avatars.com/api/?name=OR&background=3b82f6&color=fff&size=96'">
                <div>
                    <p class="font-bold text-lg text-gray-800">Par <?= htmlspecialchars(COURSE_AUTHOR) ?></p>
                    <p class="text-sm text-gray-600">Formateur en Développement Informatique & Data Science, ISMO</p>
                    <p class="text-sm text-blue-500 hover:underline">
                        <a href="https://ousrah.portal-edu.com/#cours">Aller au catalogue de tous les cours</a>
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Titre du cours -->
    <div class="mb-12 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900"><?= htmlspecialchars(COURSE_TITLE) ?></h1>
        <p class="text-lg text-gray-600 mt-2"><?= htmlspecialchars(COURSE_SUBTITLE) ?></p>
        <p class="text-sm text-gray-500 mt-4">
            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                📚 <?= htmlspecialchars(COURSE_DURATION) ?>
            </span>
            <span class="ml-2 text-gray-400">• Dernière mise à jour : <?= htmlspecialchars(COURSE_LAST_UPDATE) ?></span>
        </p>
    </div>

    <!-- Introduction au projet -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl p-6 mb-8 shadow-lg">
        <h2 class="text-xl font-bold mb-3">🎯 Objectif du Projet</h2>
        <p class="text-blue-100 leading-relaxed">
            Ce tutoriel vous guide pas à pas dans la création d'une <strong class="text-white">marketplace de produits numériques multi-vendeurs</strong> 
            complète avec Laravel 12. Vous apprendrez à implémenter : l'authentification avec rôles, le système de boutiques vendeurs, 
            le panier d'achat, les paiements Stripe et PayPal, la gestion des médias, et bien plus encore.
        </p>
    </div>

    <!-- Technologies utilisées -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🛠️ Technologies Utilisées</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ($technologies as $category => $techs): ?>
            <div>
                <h4 class="font-semibold text-gray-700 text-sm mb-2"><?= htmlspecialchars($category) ?></h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <?php foreach ($techs as $tech): ?>
                    <li class="flex items-center">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-2"></span>
                        <?= htmlspecialchars($tech) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- SOMMAIRE DYNAMIQUE -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-12">
        <h3 class="text-xl font-bold text-gray-800 mb-4">📖 Plan du Cours</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-gray-700">
            <?php 
            $parts_count = count($course_parts);
            $half_point = ceil($parts_count / 2);
            $i = 0;
            $seance_num = 1;
            ?>

            <!-- Colonne 1 -->
            <div class="space-y-4">
            <?php foreach ($course_parts as $part_title => $chapters): ?>
                <?php if ($i == $half_point): ?>
                    </div><!-- Fin Colonne 1 -->
                    <!-- Colonne 2 -->
                    <div class="space-y-4 mt-4 md:mt-0">
                <?php endif; ?>
                
                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="font-semibold text-gray-900 flex items-center">
                        <span class="badge-seance badge-seance-<?= ($seance_num % 5) + 1 ?> mr-2">S<?= $seance_num ?></span>
                        <?= htmlspecialchars(preg_replace('/^Séance \d+ : /', '', $part_title)) ?>
                    </h4>
                    <ul class="list-none ml-0 text-sm text-gray-600 space-y-1 mt-2">
                        <?php foreach ($chapters as $chapter): ?>
                            <li>
                                <a href="#<?= $chapter['id'] ?>" class="hover:text-blue-600 hover:underline toc-link">
                                    → <?= htmlspecialchars($chapter['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php $i++; $seance_num++; endforeach; ?>
            
            <!-- Conclusion -->
            <div class="border-l-4 border-green-500 pl-4 mt-4">
                <a href="#conclusion">
                    <h4 class="font-semibold text-gray-900">🎉 Conclusion & Ressources</h4>
                </a>
            </div>
            
            </div><!-- Fin Colonne 2 -->
        </div>
    </div>

    <!-- Début du contenu principal -->
