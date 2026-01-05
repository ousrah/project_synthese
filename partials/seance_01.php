<?php
/**
 * SÉANCE 1 : Fondations & Catalogue Visiteur
 * 
 * Contenu technique : Code source exact du projet (Fidélité 100%).
 * Design : Modifié pour être professionnel (Bootstrap 5 via Vite + CSS Custom).
 */
?>

<!-- ===================================================================
     SÉANCE 1 : FONDATIONS & PREMIERS PAS
     =================================================================== -->

<!-- 1.1 Introduction -->
<section id="seance1-intro" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-1 mr-3">Séance 1</span>
        <h2 class="text-2xl font-bold text-gray-800">1.1 Introduction et Configuration</h2>
    </div>

    <div class="section-card">
        <p class="text-gray-700 leading-relaxed mb-4">
            Bienvenue ! Nous allons construire une Marketplace complète. 
            Nous allons suivre à la lettre l'architecture professionnelle de l'application finale.
        </p>

        <div class="alert-warning">
            <h4 class="font-bold mb-1">⚠️ Prérequis</h4>
            <ul class="list-disc ml-5 mt-2">
                <li><strong>PHP 8.2+</strong>, <strong>Composer</strong>, <strong>Node.js & NPM</strong>, <strong>MySQL</strong>.</li>
            </ul>
        </div>
    </div>
</section>

<!-- 1.2 Installation du Projet -->
<section id="seance1-install" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-1 mr-3">Séance 1</span>
        <h2 class="text-2xl font-bold text-gray-800">1.2 Installation et Packages</h2>
    </div>

    <div class="section-card">
        <h3 class="text-xl font-bold text-gray-800 mb-4">étape 1 : Télécharger Laravel</h3>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">composer create-project laravel/laravel boutique
cd boutique</div>
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">étape 2 : Installer les dépendances (Traductions & UI)</h3>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">composer require spatie/laravel-medialibrary
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider"
php artisan migrate

composer require spatie/laravel-activitylog
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan migrate

composer require spatie/laravel-translatable
npm install bootstrap @popperjs/core sass bootstrap-icons</div>
        </div>

        <div class="alert-danger mt-4 p-4 border-l-4 border-red-600 bg-red-50">
            <h4 class="text-red-800 font-bold uppercase mb-2">⚠️ TRÈS IMPORTANT : Installez ces packages !</h4>
            <p class="text-red-700">
                1. <strong>spatie/laravel-translatable</strong> : Indispensable pour éviter les erreurs `Unknown column 'name'`.<br>
                2. <strong>bootstrap</strong> : Pour le design professionnel que nous allons mettre en place via Vite.
            </p>
        </div>
        
        <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">étape 3 : Configurer Vite pour Bootstrap (Sans SCSS)</h3>
        <p class="mb-2">Nous allons charger Bootstrap via Vite en conservant <code>app.css</code> standard.</p>
        
        <p class="mb-2 mt-4">Dans <code>resources/js/app.js</code>, importez le CSS et le JS de Bootstrap :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">JS (resources/js/app.js)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">import './bootstrap';
// Importer le CSS de Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
// Importer les icônes (optionnel, sinon utilisez CDN)
import 'bootstrap-icons/font/bootstrap-icons.css';
// Importer le JS de Bootstrap
import * as bootstrap from 'bootstrap';</div>
        </div>

        <p class="mb-2 mt-4">Vérifiez que <code>vite.config.js</code> pointe bien vers <code>app.css</code> (par défaut) :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">JS (vite.config.js)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});</div>
        </div>
        
        <p class="mb-2 mt-4">Et dans votre layout, appelez le CSS correctement :</p>
        <div class="alert-info p-2 mt-2 mb-2 bg-blue-50 text-blue-800 text-sm">
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">étape 4 : Personnaliser le Style (app.css)</h3>
        <p class="mb-2">Pour un look plus moderne (Police Inter, ombres, boutons...), ajoutez ceci :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">CSS (resources/css/app.css)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">/* Importer une belle police */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
    color: #1e293b;
}

/* Amélioration des cartes */
.card {
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
}

/* Boutons plus modernes */
.btn-primary {
    background-color: #3b82f6; /* Bleu moderne */
    border-color: #3b82f6;
    padding: 0.5rem 1.25rem;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #2563eb;
    border-color: #2563eb;
}

/* Navigation */
.navbar {
    backdrop-filter: blur(8px);
    background-color: rgba(255, 255, 255, 0.95) !important;
}
</div>
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">étape 5 : Configurer la BDD</h3>
        <div class="code-block-wrapper">
            <div class="code-lang">.ENV</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=boutique_db
DB_USERNAME=root
DB_PASSWORD=</div>
        </div>
        
        <p class="mt-4 mb-2">Lancez le serveur de développement :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">npm run dev</div>
        </div>
        
        <p class="mt-4 mb-2 text-red-600 font-bold">N'oubliez pas le lien de stockage :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan storage:link</div>
        </div>
    </div>
</section>

<!-- 1.3 Structure de la Base de Données -->
<section id="seance1-migrations" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-1 mr-3">Séance 1</span>
        <h2 class="text-2xl font-bold text-gray-800">1.3 Structure des Tables</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Nous allons créer les tables <code>users</code>, <code>stores</code>, <code>products</code> et <code>categories</code>.</p>

        <h4 class="font-bold text-blue-600 mb-2">A. Table Stores (Boutiques)</h4>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:model Store -m</div>
        </div>
        
        <p class="text-sm mt-3 mb-2">Modifiez la migration <code>create_stores_table.php</code> :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">public function up(): void
{
    Schema::create('stores', function (Blueprint $table) {
        $table->id();
        
        // Vendeur propriétaire (Sera relié à users)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        
        $table->boolean('is_active')->default(true);
        $table->boolean('is_featured')->default(false);
        $table->timestamp('verified_at')->nullable();
        $table->timestamp('suspended_at')->nullable();
        
        // Stats dénormalisées (pour performance)
        $table->unsignedInteger('products_count')->default(0);
        $table->unsignedInteger('orders_count')->default(0);
        
        $table->timestamps();
        $table->softDeletes();
    });
}</div>
        </div>

        <h4 class="font-bold text-blue-600 mb-2 mt-6">B. Table Categories</h4>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:model Category -m</div>
        </div>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (create_categories_table.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
        
        // JSON pour Spatie Translatable
        $table->json('name'); 
        $table->json('description')->nullable();
        
        $table->string('slug')->unique();
        $table->string('image')->nullable();
        $table->string('icon')->nullable();
        
        $table->boolean('is_active')->default(true);
        $table->integer('order')->default(0);
        
        $table->timestamps();
        $table->softDeletes();
        
        $table->index('is_active');
        $table->index('order');
    });
}</div>
        </div>
        
        <h4 class="font-bold text-blue-600 mb-2 mt-6">C. Table Products</h4>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:model Product -m</div>
        </div>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (create_products_table.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        
        // Relation avec Store
        $table->foreignId('store_id')->constrained()->onDelete('cascade');
        
        // Champs traduisibles (JSON)
        $table->json('name');
        $table->string('slug')->unique();
        $table->json('description')->nullable();
        $table->json('short_description')->nullable();
        
        $table->enum('type', ['digital', 'subscription', 'course', 'license'])->default('digital');
        
        $table->decimal('price', 10, 2);
        $table->decimal('compare_price', 10, 2)->nullable();
        $table->string('currency', 3)->default('EUR');
        
        $table->integer('stock')->nullable();
        $table->boolean('track_stock')->default(false);
        
        $table->string('main_file')->nullable();
        $table->string('preview_file')->nullable();
        
        $table->boolean('is_active')->default(true);
        $table->boolean('is_featured')->default(false);
        $table->boolean('is_new')->default(true);
        $table->timestamp('published_at')->nullable();
        
        // Stats
        $table->unsignedInteger('views_count')->default(0);
        $table->unsignedInteger('sales_count')->default(0);
        $table->decimal('average_rating', 3, 2)->default(0);
        $table->unsignedInteger('reviews_count')->default(0);

        $table->timestamps();
        $table->softDeletes();
        
        $table->index('is_active');
    });
}</div>
        </div>

        <h4 class="font-bold text-blue-600 mb-2 mt-6">D. Table Pivot Product_Category</h4>
        <p class="text-sm">Pour lier les produits aux catégories.</p>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:migration create_product_category_table</div>
        </div>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">public function up(): void
{
    Schema::create('product_category', function (Blueprint $table) {
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->primary(['product_id', 'category_id']);
    });
}</div>
        </div>
        
        <p class="font-bold text-red-600 mt-4">Lancez les migrations maintenant :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan migrate</div>
        </div>
    </div>
</section>

<!-- 1.4 Modèles Éloquent -->
<section id="seance1-models" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-1 mr-3">Séance 1</span>
        <h2 class="text-2xl font-bold text-gray-800">1.4 Modèles (Configuration Spatie)</h2>
    </div>
    
    <div class="section-card">
        <h4 class="font-bold text-gray-800 mb-2">Modèle Product.php</h4>
        <p class="mb-2">Utilisez <code>HasTranslations</code> pour le nom et la description, et configurez l'accesseur pour les images (LoremFlickr).</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (app/Models/Product.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes, HasTranslations;

    // Champs traduisibles
    public array $translatable = [\'name\', \'description\', \'short_description\'];

    protected $fillable = [
        \'store_id\', \'name\', \'slug\', \'description\', \'type\', 
        \'price\', \'compare_price\', \'is_active\', \'is_featured\', \'published_at\'
    ];

    protected $casts = [
        \'price\' => \'decimal:2\',
        \'is_active\' => \'boolean\',
        \'published_at\' => \'datetime\',
    ];

    // Relations
    public function store(): BelongsTo { return $this->belongsTo(Store::class); }
    public function categories(): BelongsToMany { return $this->belongsToMany(Category::class, \'product_category\'); }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, \',\', \' \') . \' €\';
    }

    public function getThumbnailUrlAttribute()
    {
        // Image de technologie via LoremFlickr (stable) avec lock sur l\'ID pour la consistance
        return "https://loremflickr.com/400/300/computer,technology?lock=" . $this->id;
    }
}') ?></div>
        </div>
        
        <p class="mt-4 font-bold text-gray-800 mb-2">Modèle Store.php</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (app/Models/Store.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('class Store extends Model
{
    use SoftDeletes;
    protected $fillable = [\'user_id\', \'name\', \'slug\', \'is_active\'];
}') ?></div>
        </div>
        
        <p class="mt-4 font-bold text-gray-800 mb-2">Modèle Category.php</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (app/Models/Category.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use SoftDeletes, HasTranslations;
    public array $translatable = [\'name\', \'description\'];
    protected $fillable = [\'parent_id\', \'name\', \'slug\', \'is_active\'];
    
    public function children() { return $this->hasMany(Category::class, \'parent_id\'); }
}') ?></div>
        </div>
    </div>
</section>

<!-- 1.5 Seeders -->
<section id="seance1-seeders" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-1 mr-3">Séance 1</span>
        <h2 class="text-2xl font-bold text-gray-800">1.5 Jeu de Données (Seeder)</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Créez des données réalistes pour tester la navigation.</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (database/seeders/DatabaseSeeder.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('public function run(): void
{
    // 1. Créer un Vendeur
    $vendeur = \App\Models\User::factory()->create([
        \'name\' => \'Vendeur Pro\',
        \'email\' => \'vendeur@boutique.com\',
        \'password\' => bcrypt(\'password\'),
    ]);

    // 2. Créer sa Boutique
    $store = \App\Models\Store::create([
        \'user_id\' => $vendeur->id,
        \'name\' => \'TechMaster Digital\',
        \'slug\' => \'techmaster-digital\',
        \'is_active\' => true,
        \'is_featured\' => true,
        \'verified_at\' => now(),
    ]);

    // 3. Catégories
    $cats = [];
    $catNames = [\'Ebooks\', \'Formations\', \'Logiciels\', \'Templates\'];
    foreach ($catNames as $name) {
        $cats[$name] = \App\Models\Category::create([
            \'name\' => [\'fr\' => $name, \'en\' => $name],
            \'slug\' => \Illuminate\Support\Str::slug($name),
            \'is_active\' => true
        ]);
    }

    // 4. Produits Diversifiés
    $productsData = [
        [\'name\' => \'Guide Ultime Laravel 12\', \'cat\' => \'Ebooks\', \'price\' => 29.99],
        [\'name\' => \'Maîtriser React JS\', \'cat\' => \'Ebooks\', \'price\' => 24.99],
        [\'name\' => \'Formation Fullstack 2025\', \'cat\' => \'Formations\', \'price\' => 199.00],
        [\'name\' => \'SaaS Starter Kit\', \'cat\' => \'Logiciels\', \'price\' => 89.00],
        [\'name\' => \'Admin Dashboard Theme\', \'cat\' => \'Templates\', \'price\' => 49.00],
        [\'name\' => \'Python pour Data Science\', \'cat\' => \'Formations\', \'price\' => 149.00],
        [\'name\' => \'Figma UI Kit Pro\', \'cat\' => \'Templates\', \'price\' => 39.00],
        [\'name\' => \'Docker pour Débutants\', \'cat\' => \'Ebooks\', \'price\' => 19.00],
    ];

    foreach ($productsData as $p) {
        $product = \App\Models\Product::create([
            \'store_id\' => $store->id,
            \'name\' => [\'fr\' => $p[\'name\'], \'en\' => $p[\'name\']],
            \'slug\' => \Illuminate\Support\Str::slug($p[\'name\']),
            \'description\' => [\'fr\' => \'Description détaillée de \' . $p[\'name\'] . \'. Apprenez et progressez rapidement.\'],
            \'price\' => $p[\'price\'],
            \'type\' => \'digital\',
            \'is_active\' => true,
            \'published_at\' => now(),
            \'views_count\' => rand(100, 5000),
            \'sales_count\' => rand(10, 500)
        ]);
        
        if (isset($cats[$p[\'cat\']])) {
            $product->categories()->attach($cats[$p[\'cat\']]->id);
        }
    }
}') ?></div>
        </div>
        
        <div class="alert-success mt-4">
            <p><strong>Action :</strong> <code>php artisan migrate:fresh --seed</code></p>
        </div>
    </div>
</section>

<!-- 1.6 Routes -->
<section id="seance1-routes" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-1 mr-3">Séance 1</span>
        <h2 class="text-2xl font-bold text-gray-800">1.6 Routes</h2>
    </div>

    <div class="section-card">
        <p class="mb-2">Ajoutez ces routes dans <code>routes/web.php</code> pour gérer l'accueil, les catégories et les produits.</p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP (routes/web.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;

// 1. Accueil
Route::get(\'/\', function () {
    $products = Product::where(\'is_active\', true)
        ->with([\'store\', \'categories\'])
        ->orderBy(\'created_at\', \'desc\')
        ->take(8)
        ->get();
        
    $categories = Category::where(\'is_active\', true)->take(6)->get();
    $featuredStores = Store::where(\'is_active\', true)->take(4)->get();

    return view(\'welcome\', compact(\'products\', \'categories\', \'featuredStores\'));
})->name(\'home\');

// 2. Page Catégorie (Nouveau)
Route::get(\'/category/{slug}\', function ($slug) {
    $category = Category::where(\'slug\', $slug)->where(\'is_active\', true)->firstOrFail();
    
    $products = Product::where(\'is_active\', true)
        ->whereHas(\'categories\', function($q) use ($category) {
            $q->where(\'categories.id\', $category->id);
        })
        ->with([\'store\', \'categories\'])
        ->paginate(12);

    return view(\'categories.show\', compact(\'category\', \'products\'));
})->name(\'categories.show\');

// 3. Fiche Produit (Nouveau)
Route::get(\'/product/{slug}\', function ($slug) {
    $product = Product::where(\'slug\', $slug)
        ->where(\'is_active\', true)
        ->with([\'store\', \'categories\'])
        ->firstOrFail();
        
    $product->increment(\'views_count\');
    
    $relatedProducts = Product::where(\'is_active\', true)
        ->where(\'id\', \'!=\', $product->id)
        ->whereHas(\'categories\', function($q) use ($product) {
            $q->whereIn(\'categories.id\', $product->categories->pluck(\'id\'));
        })
        ->take(4)
        ->get();

    return view(\'products.show\', compact(\'product\', \'relatedProducts\'));
})->name(\'products.show\');
') ?></div>
        </div>
    </div>
</section>

<!-- 1.7 Vues -->
<section id="seance1-views" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-1 mr-3">Séance 1</span>
        <h2 class="text-2xl font-bold text-gray-800">1.7 Composants et Vues</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Nous allons créer le layout et les vues pour la navigation.</p>

        <!-- A. Product Card -->
        <h4 class="font-bold text-gray-800 mb-2 mt-4 decoration-clone text-blue-600">A. Composant Product Card</h4>
        <p class="text-xs text-gray-500 mb-2">Fichier: <code>resources/views/components/product-card.blade.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('@props([\'product\'])
<div class="col-md-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 product-card">
        <a href="{{ route(\'products.show\', $product->slug) }}">
            <img src="{{ $product->thumbnail_url }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $product->name }}">
        </a>
        <div class="card-body">
            <div class="text-muted small mb-2">
                @foreach($product->categories as $cat)
                    <span class="badge bg-light text-secondary">{{ $cat->name }}</span>
                @endforeach
            </div>
            <h5 class="card-title h6">
                <a href="{{ route(\'products.show\', $product->slug) }}" class="text-dark text-decoration-none stretched-link">
                    {{ $product->name }}
                </a>
            </h5>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-primary fw-bold fs-5">{{ $product->formatted_price }}</span>
                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-cart-plus"></i></button>
            </div>
        </div>
    </div>
</div>') ?></div>
        </div>

        <!-- B. Header -->
        <h4 class="font-bold text-gray-800 mb-2 mt-8 decoration-clone text-blue-600">B. Composant Header</h4>
        <p class="text-xs text-gray-500 mb-2">Fichier: <code>resources/views/components/header.blade.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<header class="bg-dark text-white py-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-3 text-center text-md-start mb-2 mb-md-0">
                <a href="{{ url(\'/\') }}" class="text-decoration-none text-white d-inline-flex align-items-center">
                    <span class="fs-4 fw-bold">Boutique</span>
                </a>
            </div>
            <div class="col-12 col-md-6 mb-2 mb-md-0">
                <form action="{{ url(\'/search\') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Rechercher..." value="{{ request(\'q\') }}">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-3 text-end">
                <div class="d-flex justify-content-end gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-cart3"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-person-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>') ?></div>
        </div>

        <!-- C. Navbar -->
        <h4 class="font-bold text-gray-800 mb-2 mt-8 decoration-clone text-blue-600">C. Composant Navbar</h4>
        <p class="text-xs text-gray-500 mb-2">Fichier: <code>resources/views/components/main-navbar.blade.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="{{ url(\'/\') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Catégories</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="#">Promos</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-primary fw-bold" href="#">Devenir vendeur</a>
                </li>
            </ul>
        </div>
    </div>
</nav>') ?></div>
        </div>

        <!-- D. Footer -->
        <h4 class="font-bold text-gray-800 mb-2 mt-8 decoration-clone text-blue-600">D. Composant Footer</h4>
        <p class="text-xs text-gray-500 mb-2">Fichier: <code>resources/views/components/footer.blade.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<footer class="bg-dark text-white mt-auto py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5>Boutique</h5>
                <p class="text-secondary small">La meilleure marketplace pour vos produits numériques.</p>
            </div>
            <div class="col-md-4">
                <h6>Liens rapides</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-secondary text-decoration-none">Accueil</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Newsletter</h6>
                <form class="mt-2">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email...">
                        <button class="btn btn-primary">Ok</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="border-top border-secondary mt-4 pt-3 text-center text-secondary small">
            &copy; {{ date(\'Y\') }} Boutique. Tous droits réservés.
        </div>
    </div>
</footer>') ?></div>
        </div>

        <!-- E. Layout -->
        <h4 class="font-bold text-gray-800 mb-2 mt-8 decoration-clone text-blue-600">E. Layout Principal</h4>
        <p class="text-xs text-gray-500 mb-2">Fichier: <code>resources/views/components/layouts/app.blade.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<!DOCTYPE html>
<html lang="{{ str_replace(\'_\', \'-\', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? \'Boutique\' }}</title>
    @vite([\'resources/css/app.css\', \'resources/js/app.js\'])
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <x-header />
    <x-main-navbar />
    <main class="flex-grow-1">
        {{ $slot }}
    </main>
    <x-footer />
</body>
</html>') ?></div>
        </div>

        <!-- F. Welcome -->
        <h4 class="font-bold text-gray-800 mb-2 mt-8 decoration-clone text-blue-600">F. Page d'Accueil (Welcome)</h4>
        <p class="text-xs text-gray-500 mb-2">Fichier: <code>resources/views/welcome.blade.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-layouts.app title="Accueil">
    <section class="bg-primary text-white py-5 mb-5 rounded-3 mt-4">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-4 fw-bold mb-3">Produits Numériques Premium</h1>
                    <p class="lead mb-4">Ebooks, Formations, Logiciels. Une qualité garantie.</p>
                    <a href="#catalogue" class="btn btn-light btn-lg text-primary fw-bold">Voir le catalogue</a>
                </div>
                <div class="col-lg-5 text-center d-none d-lg-block">
                     <img src="https://loremflickr.com/500/350/technology,computer" class="img-fluid rounded shadow-lg" alt="Hero">
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <h2 class="h4 mb-4 fw-bold border-start border-4 border-primary ps-3">Catégories</h2>
        <div class="row g-3">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route(\'categories.show\', $category->slug) }}" class="text-decoration-none">
                    <div class="card text-center h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="fs-2 mb-2">📁</div>
                            <h6 class="card-title text-dark mb-0">{{ $category->name }}</h6>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>

    <section id="catalogue" class="container mb-5">
        <h2 class="h4 fw-bold border-start border-4 border-primary ps-3 mb-4">Nouveautés</h2>
        <div class="row g-4">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
</x-layouts.app>') ?></div>
        </div>

        <!-- G. Category Show -->
        <h4 class="font-bold text-gray-800 mb-2 mt-8 decoration-clone text-blue-600">G. Page Catégorie (Nouveau)</h4>
        <p class="text-xs text-gray-500 mb-2">Fichier: <code>resources/views/categories/show.blade.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-layouts.app :title="$category->name">
    <div class="bg-light py-4 mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route(\'home\') }}">Accueil</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>
            <h1 class="h2 fw-bold">{{ $category->name }}</h1>
        </div>
    </div>
    <div class="container mb-5">
        <div class="row g-4">
            @forelse($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Aucun produit dans cette catégorie.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-layouts.app>') ?></div>
        </div>

        <!-- H. Product Show -->
        <h4 class="font-bold text-gray-800 mb-2 mt-8 decoration-clone text-blue-600">H. Fiche Produit (Nouveau)</h4>
        <p class="text-xs text-gray-500 mb-2">Fichier: <code>resources/views/products/show.blade.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-layouts.app :title="$product->name">
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route(\'home\') }}">Accueil</a></li>
                @if($product->categories->isNotEmpty())
                    <li class="breadcrumb-item">
                        <a href="{{ route(\'categories.show\', $product->categories->first()->slug) }}">
                            {{ $product->categories->first()->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm overflow-hidden rounded-3">
                    <img src="{{ $product->thumbnail_url }}" class="img-fluid w-100" alt="{{ $product->name }}">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="ps-lg-4">
                    <h1 class="display-6 fw-bold mb-3">{{ $product->name }}</h1>
                    <h2 class="h3 text-primary fw-bold mb-4">{{ $product->formatted_price }}</h2>
                    <div class="prose text-muted mb-4">{{ $product->description }}</div>
                    
                    <div class="d-grid gap-2 d-md-flex mb-4">
                        <button class="btn btn-primary btn-lg flex-grow-1">
                            <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        @if($relatedProducts->isNotEmpty())
        <div class="mt-5 pt-5 border-top">
            <h3 class="h4 fw-bold mb-4">Produits similaires</h3>
            <div class="row g-4">
                @foreach($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>') ?></div>
        </div>
    </div>
</section>
