<!-- =================================================================== -->
<!-- SÉANCE 1 : FONDATIONS & CATALOGUE -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-blue-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-1 mr-3">Séance 1</span>
    Fondations & Catalogue
</h2>

<!-- ========== 1.1 INTRODUCTION AU PROJET ========== -->
<section id="seance1-intro" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">1.1 Introduction au Projet & Objectifs</h3>
    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
        Bienvenue dans ce projet de synthèse ! Nous allons construire une <strong>marketplace de produits numériques</strong> 
        complète, permettant à plusieurs vendeurs de proposer leurs produits (ebooks, logiciels, templates, cours) 
        et aux clients de les acheter via Stripe ou PayPal.
    </p>
    
    <div class="section-card">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">🎯 Objectifs de cette séance</h4>
        <ul class="checklist">
            <li>Comprendre le cahier des charges et l'architecture du projet</li>
            <li>Installer et configurer un nouveau projet Laravel 12</li>
            <li>Créer les modèles Product et Category avec leurs migrations</li>
            <li>Créer les seeders avec des données de démonstration</li>
            <li>Créer un layout public avec Bootstrap 5</li>
            <li>Afficher le catalogue de produits</li>
        </ul>
        
        <div class="alert-info mt-6">
            <strong>💡 Prérequis :</strong> PHP 8.2+, Composer, Node.js 18+, MySQL/MariaDB, un éditeur de code (VS Code recommandé).
        </div>
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>

<!-- ========== CAHIER DES CHARGES ========== -->
<section id="seance1-cahier-charges" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">1.1.1 Cahier des Charges</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">📋 Description du Projet</h4>
            <p class="text-gray-700 mb-4">
                <strong>DigiMarket</strong> est une marketplace multi-vendeurs permettant la vente de produits numériques.
                Les vendeurs peuvent créer leur boutique, gérer leurs produits et recevoir des paiements. 
                Les clients peuvent parcourir le catalogue, acheter et télécharger leurs achats.
            </p>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">👥 Acteurs du Système</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h5 class="font-bold text-blue-800"><i class="bi bi-person"></i> Client</h5>
                    <ul class="text-sm text-gray-700 mt-2 list-disc ml-4">
                        <li>Parcourir les produits</li>
                        <li>Ajouter au panier</li>
                        <li>Payer (Stripe/PayPal)</li>
                        <li>Télécharger les achats</li>
                        <li>Laisser des avis</li>
                    </ul>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h5 class="font-bold text-green-800"><i class="bi bi-shop"></i> Vendeur</h5>
                    <ul class="text-sm text-gray-700 mt-2 list-disc ml-4">
                        <li>Créer sa boutique</li>
                        <li>Gérer ses produits</li>
                        <li>Voir ses ventes</li>
                        <li>Recevoir des paiements</li>
                        <li>Répondre aux avis</li>
                    </ul>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <h5 class="font-bold text-red-800"><i class="bi bi-shield-check"></i> Admin</h5>
                    <ul class="text-sm text-gray-700 mt-2 list-disc ml-4">
                        <li>Gérer les utilisateurs</li>
                        <li>Modérer les produits</li>
                        <li>Vérifier les boutiques</li>
                        <li>Configurer la plateforme</li>
                        <li>Voir les statistiques</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">📦 Types de Produits</h4>
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">Type</th>
                        <th class="border p-2 text-left">Description</th>
                        <th class="border p-2 text-left">Exemple</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="border p-2"><code>digital</code></td><td class="border p-2">Fichier téléchargeable</td><td class="border p-2">E-book PDF, Template</td></tr>
                    <tr><td class="border p-2"><code>subscription</code></td><td class="border p-2">Accès récurrent</td><td class="border p-2">SaaS mensuel</td></tr>
                    <tr><td class="border p-2"><code>course</code></td><td class="border p-2">Formation en ligne</td><td class="border p-2">Cours vidéo Laravel</td></tr>
                    <tr><td class="border p-2"><code>license</code></td><td class="border p-2">Clé d'activation</td><td class="border p-2">Logiciel avec licence</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- ========== SCHÉMA RELATIONNEL ========== -->
<section id="seance1-schema" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">1.1.2 Schéma Relationnel (ERD)</h3>
    
    <div class="section-card">
        <p class="text-gray-700 mb-4">
            Voici le schéma entité-relation simplifié de notre application. Les tables principales 
            sont liées par des clés étrangères pour assurer l'intégrité des données.
        </p>
        
        <div class="bg-gray-50 p-4 rounded-lg mb-4 overflow-x-auto">
            <pre class="text-sm text-gray-800"><code>
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│   USERS     │       │   STORES    │       │  PRODUCTS   │
├─────────────┤       ├─────────────┤       ├─────────────┤
│ id          │◄──────│ user_id     │       │ id          │
│ name        │       │ id          │◄──────│ store_id    │
│ email       │       │ name        │       │ name (JSON) │
│ role        │       │ slug        │       │ slug        │
│ ...         │       │ commission  │       │ type        │
└─────────────┘       │ verified_at │       │ price       │
                      └─────────────┘       │ ...         │
                                            └─────────────┘
                                                   │
        ┌──────────────────────────────────────────┼───────────────────────┐
        │                                          │                       │
        ▼                                          ▼                       ▼
┌─────────────┐       ┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│ CATEGORIES  │       │  ORDER_ITEMS │      │   REVIEWS   │       │  DOWNLOADS  │
├─────────────┤       ├─────────────┤       ├─────────────┤       ├─────────────┤
│ id          │       │ id          │       │ id          │       │ id          │
│ parent_id   │       │ order_id    │       │ user_id     │       │ user_id     │
│ name (JSON) │       │ product_id  │       │ product_id  │       │ order_item  │
│ slug        │       │ quantity    │       │ rating      │       │ downloaded  │
└─────────────┘       │ total       │       │ content     │       │ expires_at  │
      │               └─────────────┘       └─────────────┘       └─────────────┘
      │                      │
      │                      │
      ▼                      ▼
┌──────────────────┐  ┌─────────────┐
│ PRODUCT_CATEGORY │  │   ORDERS    │
├──────────────────┤  ├─────────────┤
│ product_id       │  │ id          │
│ category_id      │  │ user_id     │
└──────────────────┘  │ total       │
                      │ status      │
                      │ payment_id  │
                      └─────────────┘
            </code></pre>
        </div>
        
        <div class="alert-info">
            <strong>📖 Relations clés :</strong>
            <ul class="list-disc ml-6 mt-2 text-sm">
                <li><code>User 1:1 Store</code> : Un utilisateur vendeur possède une boutique</li>
                <li><code>Store 1:N Product</code> : Une boutique a plusieurs produits</li>
                <li><code>Product N:M Category</code> : Un produit peut être dans plusieurs catégories (table pivot)</li>
                <li><code>Order 1:N OrderItem</code> : Une commande contient plusieurs articles</li>
                <li><code>OrderItem 1:N Download</code> : Chaque article peut avoir plusieurs téléchargements</li>
            </ul>
        </div>
    </div>
</section>

<!-- ========== SPRINTS DE DÉVELOPPEMENT ========== -->
<section id="seance1-sprints" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">1.1.3 Planning de Développement (Sprints)</h3>
    
    <div class="section-card">
        <p class="text-gray-700 mb-4">
            Le développement est organisé en <strong>10 séances</strong> (sprints) de 3-4 heures chacune.
            Chaque sprint aboutit à une fonctionnalité utilisable.
        </p>
        
        <div class="space-y-3">
            <div class="flex items-center p-3 bg-blue-100 rounded-lg">
                <span class="badge-seance badge-seance-1 mr-3">S1</span>
                <div class="flex-1">
                    <strong>Fondations & Catalogue</strong>
                    <p class="text-sm text-gray-600">Installation, modèles Category/Product, layout Bootstrap, affichage catalogue</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-blue-100 rounded-lg">
                <span class="badge-seance badge-seance-1 mr-3">S2</span>
                <div class="flex-1">
                    <strong>Authentification & Rôles</strong>
                    <p class="text-sm text-gray-600">Laravel Breeze, Spatie Permission, rôles (admin/vendor/customer), middleware</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-green-100 rounded-lg">
                <span class="badge-seance badge-seance-2 mr-3">S3</span>
                <div class="flex-1">
                    <strong>Multi-Vendeurs & Boutiques</strong>
                    <p class="text-sm text-gray-600">Modèle Store, création boutique, page vendeur, vérification admin</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-green-100 rounded-lg">
                <span class="badge-seance badge-seance-2 mr-3">S4</span>
                <div class="flex-1">
                    <strong>Panier & Commandes</strong>
                    <p class="text-sm text-gray-600">Panier JavaScript (localStorage), modèles Order/OrderItem, checkout</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-orange-100 rounded-lg">
                <span class="badge-seance badge-seance-3 mr-3">S5</span>
                <div class="flex-1">
                    <strong>Paiements (Stripe & PayPal)</strong>
                    <p class="text-sm text-gray-600">Intégration Stripe Checkout, PayPal, webhooks, gestion statut commande</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-orange-100 rounded-lg">
                <span class="badge-seance badge-seance-3 mr-3">S6</span>
                <div class="flex-1">
                    <strong>Médias & Téléchargements</strong>
                    <p class="text-sm text-gray-600">Spatie Media Library, upload images, fichiers numériques, téléchargements sécurisés</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-purple-100 rounded-lg">
                <span class="badge-seance badge-seance-4 mr-3">S7</span>
                <div class="flex-1">
                    <strong>Avis, Wishlist & Recherche</strong>
                    <p class="text-sm text-gray-600">Système d'avis, wishlist JavaScript, recherche avancée avec filtres</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-purple-100 rounded-lg">
                <span class="badge-seance badge-seance-4 mr-3">S8</span>
                <div class="flex-1">
                    <strong>Dashboard Vendeur</strong>
                    <p class="text-sm text-gray-600">Tableau de bord vendeur, statistiques, gestion produits, demandes paiement</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-red-100 rounded-lg">
                <span class="badge-seance badge-seance-5 mr-3">S9</span>
                <div class="flex-1">
                    <strong>Administration</strong>
                    <p class="text-sm text-gray-600">Gestion utilisateurs, modération produits/avis, vérification boutiques, paramètres</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-red-100 rounded-lg">
                <span class="badge-seance badge-seance-5 mr-3">S10</span>
                <div class="flex-1">
                    <strong>Finalisation & Déploiement</strong>
                    <p class="text-sm text-gray-600">Emails, SEO, tests Pest, optimisation, configuration production, déploiement</p>
                </div>
            </div>
        </div>
        
        <div class="alert-success mt-6">
            <strong>✅ Stack Technique :</strong> Laravel 12, Bootstrap 5, Spatie (Media Library, Permission, Translatable), 
            Stripe/PayPal, Pest Tests
        </div>
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>


<!-- ========== 1.2 INSTALLATION ========== -->
<section id="seance1-install" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">1.2 Installation de Laravel 12 & Configuration</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Étape 1 : Créer le projet Laravel</h4>
            <p class="text-gray-700 mb-4">Ouvrez votre terminal et exécutez la commande suivante pour créer un nouveau projet :</p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Créer le projet avec Composer</span>
composer create-project laravel/laravel boutique

<span class="token-comment"># Accéder au dossier du projet</span>
cd boutique</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Étape 2 : Créer la base de données</h4>
            <p class="text-gray-700 mb-4">
                Créez une nouvelle base de données MySQL nommée <code class="bg-gray-100 px-2 py-1 rounded">boutique</code> 
                avec l'encodage <code class="bg-gray-100 px-2 py-1 rounded">utf8mb4_unicode_ci</code>.
            </p>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Étape 3 : Configurer le fichier .env</h4>
            <p class="text-gray-700 mb-4">Ouvrez le fichier <code>.env</code> à la racine du projet et modifiez les paramètres de base de données :</p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">env</span>
                <pre class="code-block"><code>APP_NAME=Boutique
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=boutique
DB_USERNAME=root
DB_PASSWORD=</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Étape 4 : Installer les dépendances et lancer</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Générer la clé d'application</span>
php artisan key:generate

<span class="token-comment"># Installer les dépendances Node.js</span>
npm install

<span class="token-comment"># Lancer les serveurs (2 terminaux)</span>
<span class="token-comment"># Terminal 1 :</span>
npm run dev

<span class="token-comment"># Terminal 2 :</span>
php artisan serve</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <p class="text-gray-700 mt-4">
                Visitez <a href="http://localhost:8000" class="text-blue-600 hover:underline">http://localhost:8000</a> 
                pour voir la page d'accueil Laravel.
            </p>
        </div>
        
        <!-- Nouvelle section: Installation des dépendances Composer -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Étape 5 : Installer les packages Composer requis</h4>
            <p class="text-gray-700 mb-4">
                Notre marketplace utilise plusieurs packages Spatie essentiels. Installez-les maintenant :
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Packages Spatie essentiels</span>
composer require spatie/laravel-medialibrary    <span class="token-comment"># Gestion des médias (images, fichiers)</span>
composer require spatie/laravel-translatable    <span class="token-comment"># Champs multi-langues (JSON)</span>
composer require spatie/laravel-permission      <span class="token-comment"># Rôles et permissions</span>
composer require spatie/laravel-activitylog     <span class="token-comment"># Historique des modifications</span>

<span class="token-comment"># Paiements (Stripe et PayPal)</span>
composer require stripe/stripe-php              <span class="token-comment"># API Stripe</span>
composer require srmklive/paypal                <span class="token-comment"># API PayPal</span>

<span class="token-comment"># Authentification</span>
composer require laravel/breeze --dev           <span class="token-comment"># UI d'authentification</span></code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Explication des packages :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>spatie/laravel-medialibrary</code> : Associe des fichiers (images, PDFs) aux modèles Eloquent, génère des miniatures automatiquement</li>
                    <li><code>spatie/laravel-translatable</code> : Permet de stocker les traductions dans des champs JSON (<code>{"fr": "...", "en": "..."}</code>)</li>
                    <li><code>spatie/laravel-permission</code> : Système complet de rôles (admin, vendor, customer) et permissions</li>
                    <li><code>spatie/laravel-activitylog</code> : Enregistre automatiquement les modifications sur les modèles</li>
                </ul>
            </div>
        </div>
        
        <!-- Publier les migrations des packages -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Étape 6 : Publier les fichiers de configuration et migrations</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Publier les migrations Spatie Media Library</span>
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

<span class="token-comment"># Publier les migrations Spatie Permission</span>
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

<span class="token-comment"># Publier les migrations Spatie Activity Log</span>
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"

<span class="token-comment"># Créer le lien symbolique pour le stockage public</span>
php artisan storage:link</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-warning mt-4">
                <strong>⚠️ Important :</strong> Ces commandes créent les tables nécessaires dans votre base de données. 
                Elles seront exécutées avec <code>php artisan migrate</code> plus tard.
            </div>
        </div>
        
        <!-- Résumé composer.json -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Récapitulatif : Votre composer.json</h4>
            <p class="text-gray-700 mb-4">
                Après installation, votre section <code>require</code> devrait ressembler à ceci :
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">json</span>
                <pre class="code-block"><code>{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "laravel/tinker": "^2.10",
        "laravel/breeze": "^2.3",
        "spatie/laravel-medialibrary": "^11.0",
        "spatie/laravel-translatable": "^6.0",
        "spatie/laravel-permission": "^6.0",
        "spatie/laravel-activitylog": "^4.0",
        "stripe/stripe-php": "^19.0",
        "srmklive/paypal": "^3.0"
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>

<!-- ========== 1.3 MODÈLES PRODUCT & CATEGORY ========== -->
<section id="seance1-models" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">1.3 Modèles Product & Category (Migrations, Seeders)</h3>
    
    <div class="section-card space-y-8">
        <!-- Modèle Category -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.3.1 Créer le modèle Category</h4>
            <p class="text-gray-700 mb-4">Créons d'abord le modèle Category avec sa migration, son factory et son seeder :</p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:model Category -mfs</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <p class="text-gray-700 mt-4 mb-4">
                Cette commande crée 4 fichiers : le modèle, la migration, le factory et le seeder. 
                Modifions la migration :
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/migrations/xxxx_create_categories_table.php</span>

<span class="token-keyword">public function</span> <span class="token-function">up</span>(): <span class="token-keyword">void</span>
{
    Schema::<span class="token-function">create</span>(<span class="token-string">'categories'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
        <span class="token-variable">$table</span>-><span class="token-function">id</span>();
        
        <span class="token-comment">// Catégorie parente (pour sous-catégories)</span>
        <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'parent_id'</span>)
            -><span class="token-function">nullable</span>()
            -><span class="token-function">constrained</span>(<span class="token-string">'categories'</span>)
            -><span class="token-function">nullOnDelete</span>();
        
        <span class="token-comment">// Champs JSON pour traductions (Spatie Translatable)</span>
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'name'</span>);
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'description'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'slug'</span>)-><span class="token-function">unique</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'image'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'icon'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_active'</span>)-><span class="token-function">default</span>(<span class="token-keyword">true</span>);
        <span class="token-variable">$table</span>-><span class="token-function">integer</span>(<span class="token-string">'order'</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        
        <span class="token-comment">// SEO</span>
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'meta_title'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'meta_description'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-variable">$table</span>-><span class="token-function">timestamps</span>();
        <span class="token-variable">$table</span>-><span class="token-function">softDeletes</span>();
    });
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <!-- Explications des champs -->
            <div class="alert-info mt-4">
                <strong>📖 Explication des champs avancés :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>parent_id</code> : Permet de créer une hiérarchie (catégorie → sous-catégorie)</li>
                    <li><code>json('name')</code> : Stockage JSON pour traductions multi-langues via <strong>Spatie Translatable</strong></li>
                    <li><code>order</code> : Permet de trier les catégories à l'affichage</li>
                    <li><code>meta_title, meta_description</code> : Balises SEO traduisibles</li>
                    <li><code>softDeletes()</code> : Suppression logique (les données ne sont pas vraiment effacées)</li>
                </ul>
            </div>
            
            <div class="alert-warning mt-4">
                <strong>⚠️ Spatie Translatable :</strong> Les champs <code>json()</code> permettent de stocker 
                les traductions. Par exemple : <code>{"fr": "Livres", "en": "Books"}</code>
            </div>
        </div>
        
        <!-- Modèle Category complet -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Le modèle Category (complet)</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/Category.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Models</span>;

<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Model</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\SoftDeletes</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\BelongsTo</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\BelongsToMany</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\HasMany</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Str</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\MediaLibrary\HasMedia</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\MediaLibrary\InteractsWithMedia</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\Translatable\HasTranslations</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Category</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span> <span class="token-keyword">implements</span> <span class="token-class-name">HasMedia</span>
{
    <span class="token-keyword">use</span> SoftDeletes, InteractsWithMedia, HasTranslations;

    <span class="token-comment">// Champs traduisibles</span>
    <span class="token-keyword">public array</span> <span class="token-variable">$translatable</span> = [<span class="token-string">'name'</span>, <span class="token-string">'description'</span>, <span class="token-string">'meta_title'</span>, <span class="token-string">'meta_description'</span>];

    <span class="token-keyword">protected</span> <span class="token-variable">$fillable</span> = [
        <span class="token-string">'parent_id'</span>, <span class="token-string">'name'</span>, <span class="token-string">'description'</span>, <span class="token-string">'slug'</span>, <span class="token-string">'image'</span>, <span class="token-string">'icon'</span>,
        <span class="token-string">'is_active'</span>, <span class="token-string">'order'</span>, <span class="token-string">'meta_title'</span>, <span class="token-string">'meta_description'</span>,
    ];

    <span class="token-keyword">protected static function</span> <span class="token-function">boot</span>()
    {
        <span class="token-keyword">parent</span>::boot();
        <span class="token-keyword">static</span>::<span class="token-function">creating</span>(<span class="token-keyword">function</span> (<span class="token-variable">$category</span>) {
            <span class="token-keyword">if</span> (empty(<span class="token-variable">$category</span>->slug)) {
                <span class="token-variable">$name</span> = <span class="token-function">is_array</span>(<span class="token-variable">$category</span>->name) 
                    ? (<span class="token-variable">$category</span>->name[<span class="token-string">'fr'</span>] ?? reset(<span class="token-variable">$category</span>->name)) 
                    : <span class="token-variable">$category</span>->name;
                <span class="token-variable">$category</span>->slug = Str::<span class="token-function">slug</span>(<span class="token-variable">$name</span>);
            }
        });
    }

    <span class="token-keyword">public function</span> <span class="token-function">registerMediaCollections</span>(): <span class="token-keyword">void</span>
    {
        <span class="token-variable">$this</span>-><span class="token-function">addMediaCollection</span>(<span class="token-string">'image'</span>)-><span class="token-function">singleFile</span>();
    }

    <span class="token-comment">// Relations</span>
    <span class="token-keyword">public function</span> <span class="token-function">parent</span>(): <span class="token-class-name">BelongsTo</span> { <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">belongsTo</span>(Category::<span class="token-keyword">class</span>, <span class="token-string">'parent_id'</span>); }
    <span class="token-keyword">public function</span> <span class="token-function">children</span>(): <span class="token-class-name">HasMany</span> { <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">hasMany</span>(Category::<span class="token-keyword">class</span>, <span class="token-string">'parent_id'</span>); }
    <span class="token-keyword">public function</span> <span class="token-function">products</span>(): <span class="token-class-name">BelongsToMany</span> { <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">belongsToMany</span>(Product::<span class="token-keyword">class</span>, <span class="token-string">'product_category'</span>); }

    <span class="token-comment">// Accesseurs</span>
    <span class="token-keyword">public function</span> <span class="token-function">getImageUrlAttribute</span>(): <span class="token-keyword">string</span>
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">hasMedia</span>(<span class="token-string">'image'</span>) 
            ? <span class="token-variable">$this</span>-><span class="token-function">getFirstMediaUrl</span>(<span class="token-string">'image'</span>) 
            : asset(<span class="token-string">'images/default-category.jpg'</span>);
    }

    <span class="token-comment">// Scopes</span>
    <span class="token-keyword">public function</span> <span class="token-function">scopeActive</span>(<span class="token-variable">$query</span>) { <span class="token-keyword">return</span> <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>); }
    <span class="token-keyword">public function</span> <span class="token-function">scopeParents</span>(<span class="token-variable">$query</span>) { <span class="token-keyword">return</span> <span class="token-variable">$query</span>-><span class="token-function">whereNull</span>(<span class="token-string">'parent_id'</span>); }
    <span class="token-keyword">public function</span> <span class="token-function">scopeOrdered</span>(<span class="token-variable">$query</span>) { <span class="token-keyword">return</span> <span class="token-variable">$query</span>-><span class="token-function">orderBy</span>(<span class="token-string">'order'</span>)-><span class="token-function">orderBy</span>(<span class="token-string">'name'</span>); }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <!-- Explications du modèle -->
            <div class="alert-info mt-4">
                <strong>📖 Concepts avancés du modèle :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>implements HasMedia</code> : Interface pour Spatie Media Library</li>
                    <li><code>HasTranslations</code> : Trait pour les champs multi-langues</li>
                    <li><code>$translatable</code> : Liste les champs traduisibles</li>
                    <li><code>boot()</code> : Génère automatiquement le slug à la création</li>
                    <li><code>parent() / children()</code> : Relations auto-référentielles pour hiérarchie</li>
                    <li><code>scopeActive()</code> : Permet d'écrire <code>Category::active()->get()</code></li>
                </ul>
            </div>
        </div>
        
        <!-- Modèle Product -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.3.2 Créer le modèle Product</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:model Product -mfs</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <p class="text-gray-700 mt-4 mb-4">Migration du modèle Product (version complète) :</p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/migrations/xxxx_create_products_table.php</span>

<span class="token-keyword">public function</span> <span class="token-function">up</span>(): <span class="token-keyword">void</span>
{
    Schema::<span class="token-function">create</span>(<span class="token-string">'products'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
        <span class="token-variable">$table</span>-><span class="token-function">id</span>();
        
        <span class="token-comment">// Boutique vendeur (sera lié en Séance 3)</span>
        <span class="token-variable">$table</span>-><span class="token-function">unsignedBigInteger</span>(<span class="token-string">'store_id'</span>)-><span class="token-function">nullable</span>();
        <span class="token-comment">// La contrainte sera ajoutée en Séance 3 après création de la table stores</span>
        
        <span class="token-comment">// Champs traduisibles (JSON pour Spatie Translatable)</span>
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'name'</span>);
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'slug'</span>)-><span class="token-function">unique</span>();
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'description'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'short_description'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// Type de produit numérique</span>
        <span class="token-variable">$table</span>-><span class="token-function">enum</span>(<span class="token-string">'type'</span>, [<span class="token-string">'digital'</span>, <span class="token-string">'subscription'</span>, <span class="token-string">'course'</span>, <span class="token-string">'license'</span>])
            -><span class="token-function">default</span>(<span class="token-string">'digital'</span>);
        
        <span class="token-comment">// Prix</span>
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'price'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>);
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'compare_price'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'currency'</span>, <span class="token-number">3</span>)-><span class="token-function">default</span>(<span class="token-string">'EUR'</span>);
        
        <span class="token-comment">// Stock (pour licences limitées)</span>
        <span class="token-variable">$table</span>-><span class="token-function">integer</span>(<span class="token-string">'stock'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'track_stock'</span>)-><span class="token-function">default</span>(<span class="token-keyword">false</span>);
        
        <span class="token-comment">// Fichiers</span>
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'main_file'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'preview_file'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// Téléchargements</span>
        <span class="token-variable">$table</span>-><span class="token-function">integer</span>(<span class="token-string">'max_downloads'</span>)-><span class="token-function">default</span>(<span class="token-number">3</span>);
        <span class="token-variable">$table</span>-><span class="token-function">integer</span>(<span class="token-string">'download_expiry_days'</span>)-><span class="token-function">default</span>(<span class="token-number">30</span>);
        
        <span class="token-comment">// Statut</span>
        <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_active'</span>)-><span class="token-function">default</span>(<span class="token-keyword">true</span>);
        <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_featured'</span>)-><span class="token-function">default</span>(<span class="token-keyword">false</span>);
        <span class="token-variable">$table</span>-><span class="token-function">timestamp</span>(<span class="token-string">'published_at'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// SEO</span>
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'meta_title'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'meta_description'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// Statistiques</span>
        <span class="token-variable">$table</span>-><span class="token-function">unsignedInteger</span>(<span class="token-string">'views_count'</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">unsignedInteger</span>(<span class="token-string">'sales_count'</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'average_rating'</span>, <span class="token-number">3</span>, <span class="token-number">2</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">unsignedInteger</span>(<span class="token-string">'reviews_count'</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        
        <span class="token-variable">$table</span>-><span class="token-function">timestamps</span>();
        <span class="token-variable">$table</span>-><span class="token-function">softDeletes</span>();
        
        <span class="token-comment">// Index pour optimiser les requêtes</span>
        <span class="token-variable">$table</span>-><span class="token-function">index</span>(<span class="token-string">'store_id'</span>);
    });
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-warning mt-4">
                <strong>⚠️ Note importante :</strong> Le champ <code>store_id</code> est créé sans contrainte de clé étrangère 
                car la table <code>stores</code> n'existe pas encore. En <strong>Séance 3</strong>, nous créerons la table 
                <code>stores</code> et ajouterons la contrainte avec une migration séparée :
                <pre class="bg-yellow-50 p-2 mt-2 rounded text-sm overflow-x-auto"><code>// Séance 3 : add_foreign_key_to_products
Schema::table('products', function (Blueprint $table) {
    $table->foreign('store_id')->references('id')->on('stores')->cascadeOnDelete();
});</code></pre>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Champs clés de la migration :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>store_id</code> : Sera lié à une boutique vendeur (Séance 3)</li>
                    <li><code>type</code> : digital, subscription, course, license</li>
                    <li><code>compare_price</code> : Ancien prix barré (pour afficher une promotion)</li>
                    <li><code>max_downloads / download_expiry_days</code> : Limites de téléchargement</li>
                    <li><code>views_count, sales_count, average_rating</code> : Statistiques</li>
                </ul>
            </div>
        </div>
        
        <!-- Modèle Product complet -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Le modèle Product</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/Product.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Models</span>;

<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Model</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\BelongsTo</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Product</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span>
{
    <span class="token-keyword">protected</span> <span class="token-variable">$fillable</span> = [
        <span class="token-string">'category_id'</span>,
        <span class="token-string">'name'</span>,
        <span class="token-string">'slug'</span>,
        <span class="token-string">'description'</span>,
        <span class="token-string">'price'</span>,
        <span class="token-string">'thumbnail'</span>,
        <span class="token-string">'type'</span>,
        <span class="token-string">'is_active'</span>,
    ];

    <span class="token-keyword">protected function</span> <span class="token-function">casts</span>(): <span class="token-keyword">array</span>
    {
        <span class="token-keyword">return</span> [
            <span class="token-string">'price'</span> => <span class="token-string">'decimal:2'</span>,
            <span class="token-string">'is_active'</span> => <span class="token-string">'boolean'</span>,
        ];
    }

    <span class="token-comment">// Relation : Un produit appartient à une catégorie</span>
    <span class="token-keyword">public function</span> <span class="token-function">category</span>(): <span class="token-class-name">BelongsTo</span>
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">belongsTo</span>(Category::<span class="token-keyword">class</span>);
    }

    <span class="token-comment">// Accesseur pour l'URL de la miniature</span>
    <span class="token-keyword">public function</span> <span class="token-function">getThumbnailUrlAttribute</span>(): <span class="token-keyword">string</span>
    {
        <span class="token-comment">// Si une image a été uploadée dans le champ thumbnail</span>
        <span class="token-keyword">if</span> (<span class="token-variable">$this</span>->thumbnail) {
            <span class="token-keyword">return</span> asset(<span class="token-string">'storage/'</span> . <span class="token-variable">$this</span>->thumbnail);
        }
        
        <span class="token-comment">// Fallback: Spatie Media Library</span>
        <span class="token-keyword">if</span> (<span class="token-variable">$this</span>-><span class="token-function">hasMedia</span>(<span class="token-string">'thumbnail'</span>)) {
            <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">getFirstMediaUrl</span>(<span class="token-string">'thumbnail'</span>);
        }
        
        <span class="token-comment">// Images Unsplash selon le type de produit</span>
        <span class="token-variable">$unsplashIds</span> = [
            <span class="token-string">'digital'</span> => <span class="token-string">'1544716278-ca5e3f4abd8c'</span>,
            <span class="token-string">'course'</span> => <span class="token-string">'1516321318423-f06f85e504b3'</span>,
            <span class="token-string">'subscription'</span> => <span class="token-string">'1460925895917-afdab827c52f'</span>,
            <span class="token-string">'license'</span> => <span class="token-string">'1555066931-4365d14bab8c'</span>,
        ];
        
        <span class="token-variable">$imageId</span> = <span class="token-variable">$unsplashIds</span>[<span class="token-variable">$this</span>->type] ?? <span class="token-variable">$unsplashIds</span>[<span class="token-string">'digital'</span>];
        <span class="token-keyword">return</span> <span class="token-string">"https://images.unsplash.com/photo-{$imageId}?w=400&amp;h=300&amp;fit=crop&amp;auto=format"</span>;
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Stratégie de fallback :</strong>
                <ol class="list-decimal ml-6 mt-2 text-sm">
                    <li>D'abord, on cherche une image uploadée manuellement (<code>thumbnail</code>)</li>
                    <li>Sinon, on utilise Spatie Media Library (<code>hasMedia</code>)</li>
                    <li>En dernier recours, une image Unsplash adaptée au type de produit</li>
                </ol>
            </div>
        </div>
        
        <!-- Seeders -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.3.3 Créer les Seeders</h4>
            <p class="text-gray-700 mb-4">Créons des données de démonstration :</p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/seeders/CategorySeeder.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">Database\Seeders</span>;

<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Category</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Seeder</span>;

<span class="token-keyword">class</span> <span class="token-class-name">CategorySeeder</span> <span class="token-keyword">extends</span> <span class="token-class-name">Seeder</span>
{
    <span class="token-keyword">public function</span> <span class="token-function">run</span>(): <span class="token-keyword">void</span>
    {
        <span class="token-variable">$categories</span> = [
            [<span class="token-string">'name'</span> => <span class="token-string">'E-Books'</span>, <span class="token-string">'slug'</span> => <span class="token-string">'ebooks'</span>, <span class="token-string">'icon'</span> => <span class="token-string">'bi-book'</span>],
            [<span class="token-string">'name'</span> => <span class="token-string">'Logiciels'</span>, <span class="token-string">'slug'</span> => <span class="token-string">'software'</span>, <span class="token-string">'icon'</span> => <span class="token-string">'bi-cpu'</span>],
            [<span class="token-string">'name'</span> => <span class="token-string">'Templates'</span>, <span class="token-string">'slug'</span> => <span class="token-string">'templates'</span>, <span class="token-string">'icon'</span> => <span class="token-string">'bi-layout-wtf'</span>],
            [<span class="token-string">'name'</span> => <span class="token-string">'Musique'</span>, <span class="token-string">'slug'</span> => <span class="token-string">'music'</span>, <span class="token-string">'icon'</span> => <span class="token-string">'bi-music-note'</span>],
            [<span class="token-string">'name'</span> => <span class="token-string">'Graphisme'</span>, <span class="token-string">'slug'</span> => <span class="token-string">'graphics'</span>, <span class="token-string">'icon'</span> => <span class="token-string">'bi-palette'</span>],
        ];

        <span class="token-keyword">foreach</span> (<span class="token-variable">$categories</span> <span class="token-keyword">as</span> <span class="token-variable">$category</span>) {
            Category::<span class="token-function">create</span>(<span class="token-variable">$category</span>);
        }
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-6">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/seeders/ProductSeeder.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">Database\Seeders</span>;

<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Seeder</span>;

<span class="token-keyword">class</span> <span class="token-class-name">ProductSeeder</span> <span class="token-keyword">extends</span> <span class="token-class-name">Seeder</span>
{
    <span class="token-keyword">public function</span> <span class="token-function">run</span>(): <span class="token-keyword">void</span>
    {
        <span class="token-variable">$products</span> = [
            [
                <span class="token-string">'category_id'</span> => <span class="token-number">1</span>,
                <span class="token-string">'name'</span> => <span class="token-string">'Guide Laravel 12'</span>,
                <span class="token-string">'slug'</span> => <span class="token-string">'guide-laravel-12'</span>,
                <span class="token-string">'description'</span> => <span class="token-string">'Le guide complet pour maîtriser Laravel 12'</span>,
                <span class="token-string">'price'</span> => <span class="token-number">29.99</span>,
            ],
            [
                <span class="token-string">'category_id'</span> => <span class="token-number">2</span>,
                <span class="token-string">'name'</span> => <span class="token-string">'DevTools Pro'</span>,
                <span class="token-string">'slug'</span> => <span class="token-string">'devtools-pro'</span>,
                <span class="token-string">'description'</span> => <span class="token-string">'Suite d\'outils pour développeurs'</span>,
                <span class="token-string">'price'</span> => <span class="token-number">49.99</span>,
            ],
            [
                <span class="token-string">'category_id'</span> => <span class="token-number">3</span>,
                <span class="token-string">'name'</span> => <span class="token-string">'Template Dashboard'</span>,
                <span class="token-string">'slug'</span> => <span class="token-string">'template-dashboard'</span>,
                <span class="token-string">'description'</span> => <span class="token-string">'Template admin moderne avec Bootstrap'</span>,
                <span class="token-string">'price'</span> => <span class="token-number">19.99</span>,
            ],
        ];

        <span class="token-keyword">foreach</span> (<span class="token-variable">$products</span> <span class="token-keyword">as</span> <span class="token-variable">$product</span>) {
            Product::<span class="token-function">create</span>(<span class="token-variable">$product</span>);
        }
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <!-- DatabaseSeeder -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.3.4 Appeler les seeders</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/seeders/DatabaseSeeder.php</span>

<span class="token-keyword">public function</span> <span class="token-function">run</span>(): <span class="token-keyword">void</span>
{
    <span class="token-variable">$this</span>-><span class="token-function">call</span>([
        CategorySeeder::<span class="token-keyword">class</span>,
        ProductSeeder::<span class="token-keyword">class</span>,
    ]);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <!-- Exécuter les migrations -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.3.5 Exécuter les migrations et seeders</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Exécuter les migrations et seeders</span>
php artisan migrate:fresh --seed</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-success mt-4">
                <strong>✅ Vérification :</strong> Ouvrez votre base de données et vérifiez que les tables 
                <code>categories</code> et <code>products</code> contiennent bien des données.
            </div>
        </div>
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>

<!-- ========== 1.4 LAYOUT PUBLIC ========== -->
<section id="seance1-layout" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">1.4 Layout Public & Affichage du Catalogue</h3>
    
    <div class="section-card space-y-8">
        <!-- Installer Bootstrap -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.4.1 Créer le layout principal</h4>
            <p class="text-gray-700 mb-4">
                Créez le fichier de layout principal qui sera utilisé par toutes les pages publiques. 
                Nous utilisons Bootstrap 5 via CDN pour simplifier.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/components/layouts/app.blade.php --&gt;</span>

&lt;!DOCTYPE html&gt;
&lt;html lang="fr"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;<span class="token-blade">{{ $title ?? 'Boutique' }}</span>&lt;/title&gt;
    
    <span class="token-comment">&lt;!-- Bootstrap 5 CSS --&gt;</span>
    &lt;link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"&gt;
    <span class="token-comment">&lt;!-- Bootstrap Icons --&gt;</span>
    &lt;link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet"&gt;
&lt;/head&gt;
&lt;body&gt;
    <span class="token-comment">&lt;!-- Navbar --&gt;</span>
    &lt;nav class="navbar navbar-expand-lg navbar-dark bg-dark"&gt;
        &lt;div class="container"&gt;
            &lt;a class="navbar-brand" href="<span class="token-blade">{{ route('home') }}</span>"&gt;
                &lt;i class="bi bi-shop me-2"&gt;&lt;/i&gt;Boutique
            &lt;/a&gt;
            &lt;ul class="navbar-nav ms-auto"&gt;
                &lt;li class="nav-item"&gt;
                    &lt;a class="nav-link" href="<span class="token-blade">{{ route('products.index') }}</span>"&gt;Produits&lt;/a&gt;
                &lt;/li&gt;
                &lt;li class="nav-item"&gt;
                    &lt;a class="nav-link" href="#"&gt;
                        &lt;i class="bi bi-cart"&gt;&lt;/i&gt; Panier
                    &lt;/a&gt;
                &lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
    &lt;/nav&gt;

    <span class="token-comment">&lt;!-- Contenu principal --&gt;</span>
    &lt;main&gt;
        <span class="token-blade">{{ $slot }}</span>
    &lt;/main&gt;

    <span class="token-comment">&lt;!-- Footer --&gt;</span>
    &lt;footer class="bg-dark text-white py-4 mt-5"&gt;
        &lt;div class="container text-center"&gt;
            &lt;p class="mb-0"&gt;&amp;copy; 2025 Boutique. Tous droits réservés.&lt;/p&gt;
        &lt;/div&gt;
    &lt;/footer&gt;

    <span class="token-comment">&lt;!-- Bootstrap JS --&gt;</span>
    &lt;script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"&gt;&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <!-- ProductController -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.4.2 Créer le ProductController</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:controller ProductController</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/ProductController.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Http\Controllers</span>;

<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>;
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Category</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Http\Request</span>;

<span class="token-keyword">class</span> <span class="token-class-name">ProductController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-comment">// Liste des produits</span>
    <span class="token-keyword">public function</span> <span class="token-function">index</span>(Request <span class="token-variable">$request</span>)
    {
        <span class="token-variable">$query</span> = Product::<span class="token-function">with</span>(<span class="token-string">'category'</span>)
            -><span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>);

        <span class="token-comment">// Filtrer par catégorie si demandé</span>
        <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">has</span>(<span class="token-string">'category'</span>)) {
            <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'category_id'</span>, <span class="token-variable">$request</span>->category);
        }

        <span class="token-variable">$products</span> = <span class="token-variable">$query</span>-><span class="token-function">paginate</span>(<span class="token-number">12</span>);
        <span class="token-variable">$categories</span> = Category::<span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>)-><span class="token-function">get</span>();

        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'products.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'products'</span>, <span class="token-string">'categories'</span>));
    }

    <span class="token-comment">// Détail d'un produit</span>
    <span class="token-keyword">public function</span> <span class="token-function">show</span>(Product <span class="token-variable">$product</span>)
    {
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'products.show'</span>, <span class="token-function">compact</span>(<span class="token-string">'product'</span>));
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <!-- Routes -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.4.3 Définir les routes</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// routes/web.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Controllers\ProductController</span>;

Route::<span class="token-function">get</span>(<span class="token-string">'/'</span>, <span class="token-keyword">fn</span>() => <span class="token-function">view</span>(<span class="token-string">'home'</span>))-><span class="token-function">name</span>(<span class="token-string">'home'</span>);

Route::<span class="token-function">get</span>(<span class="token-string">'/products'</span>, [ProductController::<span class="token-keyword">class</span>, <span class="token-string">'index'</span>])-><span class="token-function">name</span>(<span class="token-string">'products.index'</span>);
Route::<span class="token-function">get</span>(<span class="token-string">'/products/{product:slug}'</span>, [ProductController::<span class="token-keyword">class</span>, <span class="token-string">'show'</span>])-><span class="token-function">name</span>(<span class="token-string">'products.show'</span>);</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <!-- Vue products/index -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.4.4 Vue du catalogue</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/products/index.blade.php --&gt;</span>

&lt;x-layouts.app title="Nos Produits"&gt;
    &lt;div class="container py-5"&gt;
        &lt;h1 class="mb-4"&gt;Nos Produits&lt;/h1&gt;
        
        <span class="token-comment">&lt;!-- Filtres par catégorie --&gt;</span>
        &lt;div class="mb-4"&gt;
            &lt;a href="<span class="token-blade">{{ route('products.index') }}</span>" 
               class="btn btn-sm <span class="token-blade">{{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }}</span>"&gt;
                Tous
            &lt;/a&gt;
            <span class="token-blade">@foreach($categories as $category)</span>
            &lt;a href="<span class="token-blade">{{ route('products.index', ['category' => $category->id]) }}</span>" 
               class="btn btn-sm <span class="token-blade">{{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }}</span>"&gt;
                <span class="token-blade">{{ $category->name }}</span>
            &lt;/a&gt;
            <span class="token-blade">@endforeach</span>
        &lt;/div&gt;

        <span class="token-comment">&lt;!-- Grille de produits --&gt;</span>
        &lt;div class="row g-4"&gt;
            <span class="token-blade">@forelse($products as $product)</span>
            &lt;div class="col-md-4 col-lg-3"&gt;
                &lt;div class="card h-100 shadow-sm"&gt;
                    &lt;img src="<span class="token-blade">{{ $product->thumbnail_url }}</span>" 
                         class="card-img-top" 
                         alt="<span class="token-blade">{{ $product->name }}</span>"
                         style="height: 180px; object-fit: cover;"&gt;
                    &lt;div class="card-body d-flex flex-column"&gt;
                        &lt;span class="badge bg-secondary mb-2"&gt;<span class="token-blade">{{ $product->category->name }}</span>&lt;/span&gt;
                        &lt;h5 class="card-title"&gt;<span class="token-blade">{{ $product->name }}</span>&lt;/h5&gt;
                        &lt;p class="text-primary fw-bold"&gt;<span class="token-blade">{{ number_format($product->price, 2) }}</span> €&lt;/p&gt;
                        &lt;a href="<span class="token-blade">{{ route('products.show', $product) }}</span>" class="btn btn-outline-primary mt-auto"&gt;
                            Voir détails
                        &lt;/a&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            <span class="token-blade">@empty</span>
            &lt;div class="col-12"&gt;
                &lt;p class="text-muted text-center"&gt;Aucun produit disponible.&lt;/p&gt;
            &lt;/div&gt;
            <span class="token-blade">@endforelse</span>
        &lt;/div&gt;

        <span class="token-comment">&lt;!-- Pagination --&gt;</span>
        &lt;div class="mt-4"&gt;
            <span class="token-blade">{{ $products->links() }}</span>
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/x-layouts.app&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <!-- Exercice -->
    <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
        <h4 class="text-xl font-bold text-gray-800 mb-2">📝 Exercice : Créer la page d'accueil</h4>
        <p class="text-gray-700 mb-4">
            Créez une page d'accueil (<code>resources/views/home.blade.php</code>) qui affiche :
        </p>
        <ol class="list-decimal ml-6 text-gray-700 space-y-2">
            <li>Un hero banner de bienvenue</li>
            <li>Les 4 derniers produits ajoutés</li>
            <li>Les catégories sous forme de cartes</li>
        </ol>
        
        <button class="solution-toggle">👁️ Voir la solution</button>
        <div class="solution-content">
            <!-- Étape 1: HomeController -->
            <h5 class="font-bold text-gray-800 mt-6 mb-2">Étape 1 : Créer le HomeController</h5>
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:controller HomeController</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/HomeController.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> App\Http\Controllers;

<span class="token-keyword">use</span> App\Models\Product;
<span class="token-keyword">use</span> App\Models\Category;

<span class="token-keyword">class</span> <span class="token-class-name">HomeController</span> <span class="token-keyword">extends</span> Controller
{
    <span class="token-keyword">public function</span> <span class="token-function">index</span>()
    {
        <span class="token-comment">// Récupérer les 4 derniers produits</span>
        <span class="token-variable">$latestProducts</span> = Product::<span class="token-function">with</span>(<span class="token-string">'category'</span>)
            -><span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>)
            -><span class="token-function">latest</span>()
            -><span class="token-function">take</span>(<span class="token-number">4</span>)
            -><span class="token-function">get</span>();
        
        <span class="token-comment">// Récupérer les catégories avec le nombre de produits</span>
        <span class="token-variable">$categories</span> = Category::<span class="token-function">withCount</span>(<span class="token-string">'products'</span>)
            -><span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>)
            -><span class="token-function">get</span>();
        
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'home'</span>, <span class="token-function">compact</span>(<span class="token-string">'latestProducts'</span>, <span class="token-string">'categories'</span>));
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <!-- Étape 2: Route -->
            <h5 class="font-bold text-gray-800 mt-6 mb-2">Étape 2 : Modifier la route</h5>
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// routes/web.php</span>

<span class="token-keyword">use</span> App\Http\Controllers\HomeController;

Route::<span class="token-function">get</span>(<span class="token-string">'/'</span>, [HomeController::<span class="token-keyword">class</span>, <span class="token-string">'index'</span>])-><span class="token-function">name</span>(<span class="token-string">'home'</span>);</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <!-- Étape 3: Vue -->
            <h5 class="font-bold text-gray-800 mt-6 mb-2">Étape 3 : Créer la vue home.blade.php</h5>
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/home.blade.php --&gt;</span>

&lt;x-layouts.app title="Accueil - Boutique"&gt;
    <span class="token-comment">&lt;!-- Hero Banner --&gt;</span>
    &lt;div class="bg-primary text-white py-5"&gt;
        &lt;div class="container text-center"&gt;
            &lt;h1 class="display-4 fw-bold"&gt;Bienvenue sur notre Marketplace&lt;/h1&gt;
            &lt;p class="lead"&gt;Découvrez nos produits numériques de qualité&lt;/p&gt;
            &lt;a href="<span class="token-blade">{{ route('products.index') }}</span>" class="btn btn-light btn-lg mt-3"&gt;
                Voir tous les produits
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;

    &lt;div class="container py-5"&gt;
        <span class="token-comment">&lt;!-- Derniers Produits --&gt;</span>
        &lt;section class="mb-5"&gt;
            &lt;h2 class="h3 mb-4"&gt;Nouveautés&lt;/h2&gt;
            &lt;div class="row g-4"&gt;
                <span class="token-blade">@foreach($latestProducts as $product)</span>
                &lt;div class="col-md-3"&gt;
                    &lt;div class="card h-100 shadow-sm"&gt;
                        &lt;img src="<span class="token-blade">{{ $product-&gt;thumbnail_url }}</span>" 
                             class="card-img-top" style="height: 150px; object-fit: cover;"&gt;
                        &lt;div class="card-body"&gt;
                            &lt;span class="badge bg-secondary"&gt;<span class="token-blade">{{ $product-&gt;category-&gt;name }}</span>&lt;/span&gt;
                            &lt;h5 class="card-title mt-2"&gt;<span class="token-blade">{{ $product-&gt;name }}</span>&lt;/h5&gt;
                            &lt;p class="text-primary fw-bold"&gt;<span class="token-blade">{{ number_format($product-&gt;price, 2) }}</span> €&lt;/p&gt;
                            &lt;a href="<span class="token-blade">{{ route('products.show', $product) }}</span>" class="btn btn-outline-primary btn-sm"&gt;
                                Voir
                            &lt;/a&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                <span class="token-blade">@endforeach</span>
            &lt;/div&gt;
        &lt;/section&gt;

        <span class="token-comment">&lt;!-- Catégories --&gt;</span>
        &lt;section&gt;
            &lt;h2 class="h3 mb-4"&gt;Nos Catégories&lt;/h2&gt;
            &lt;div class="row g-4"&gt;
                <span class="token-blade">@foreach($categories as $category)</span>
                &lt;div class="col-md-4"&gt;
                    &lt;a href="<span class="token-blade">{{ route('products.index', ['category' =&gt; $category-&gt;id]) }}</span>" 
                       class="text-decoration-none"&gt;
                        &lt;div class="card bg-light"&gt;
                            &lt;div class="card-body text-center"&gt;
                                &lt;i class="bi <span class="token-blade">{{ $category-&gt;icon }}</span> fs-1 text-primary"&gt;&lt;/i&gt;
                                &lt;h5 class="mt-2"&gt;<span class="token-blade">{{ $category-&gt;name }}</span>&lt;/h5&gt;
                                &lt;small class="text-muted"&gt;<span class="token-blade">{{ $category-&gt;products_count }}</span> produits&lt;/small&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                    &lt;/a&gt;
                &lt;/div&gt;
                <span class="token-blade">@endforeach</span>
            &lt;/div&gt;
        &lt;/section&gt;
    &lt;/div&gt;
&lt;/x-layouts.app&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 1 !</strong> Vous avez maintenant un catalogue de produits fonctionnel. 
        Dans la prochaine séance, nous ajouterons l'authentification et les rôles utilisateurs.
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>
