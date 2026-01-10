<?php
/**
 * SÉANCE 5 : Gestion Complète des Produits (Vendeur)
 * 
 * Contenu technique : Code source exact du projet (Fidélité 100%).
 * Design : Bootstrap 5 via Vite + CSS Custom.
 */
?>

<!-- ===================================================================
     SÉANCE 5 : GESTION DES PRODUITS ET GALERIE
     =================================================================== -->

<!-- 5.1 Introduction -->
<section id="seance5-intro" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-5 mr-3">Séance 5</span>
        <h2 class="text-2xl font-bold text-gray-800">5.1 Configuration Multi-langues (Prérequis)</h2>
    </div>

    <div class="section-card">
        <p class="text-gray-700 leading-relaxed mb-4">
            Avant de permettre aux vendeurs de créer des produits, nous devons gérer le multi-langue pour que les produits puissent avoir un nom et une description en Français, Anglais, etc.
        </p>

        <h3 class="text-xl font-bold text-gray-800 mb-4">Installation de mcamara/laravel-localization</h3>
        
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">composer require mcamara/laravel-localization
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"</div>
        </div>

        <p class="mb-2 mt-4">Ajoutez le middleware dans <code>bootstrap/app.php</code> :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        \'localize\'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        \'localizationRedirect\'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        \'localeSessionRedirect\'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        \'localeCookieRedirect\'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        \'localeViewPath\'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ]);
})') ?></div>
        </div>

        <div class="alert-info mt-4">
            <strong>Configuration :</strong> Dans <code>config/laravellocalization.php</code>, décommentez les lignes pour 'en', 'es' et 'ar' si vous souhaitez supporter ces langues en plus du Français.
        </div>
    </div>
</section>

<!-- 5.2 Product Model & Media -->
<section id="seance5-product-media" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-5 mr-3">Séance 5</span>
        <h2 class="text-2xl font-bold text-gray-800">5.2 Modèle Product avec Spatie Media</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Modifiez <code>app/Models/Product.php</code> pour gérer les collections d'images (Thumbnail, Galerie) et les fichiers numériques.</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    public array $translatable = [\'name\', \'description\', \'short_description\'];

    protected $fillable = [
        \'store_id\', \'name\', \'slug\', \'description\', \'short_description\',
        \'price\', \'compare_price\', \'quantity\', \'type\',
        \'is_active\', \'is_featured\', \'published_at\'
    ];

    protected $casts = [
        \'price\' => \'decimal:2\',
        \'compare_price\' => \'decimal:2\',
        \'is_active\' => \'boolean\',
        \'is_featured\' => \'boolean\',
        \'published_at\' => \'datetime\',
    ];

    // DEFINITION DES COLLECTIONS MEDIA
    public function registerMediaCollections(): void
    {
        // 1. Image principale (Thumbnail)
        $this->addMediaCollection(\'thumbnail\')
            ->singleFile() // Une seule image principale
            ->acceptsMimeTypes([\'image/jpeg\', \'image/png\', \'image/webp\']);

        // 2. Galerie photos (Plusieurs images)
        $this->addMediaCollection(\'gallery\')
            ->acceptsMimeTypes([\'image/jpeg\', \'image/png\', \'image/webp\']);
            
        // 3. Fichier numérique (Le produit lui-même)
        $this->addMediaCollection(\'digital_file\')
            ->singleFile()
            ->acceptsMimeTypes([\'application/pdf\', \'application/zip\', \'application/epub+zip\']);
    }

    // RELATIONS
    public function store(): BelongsTo { return $this->belongsTo(Store::class); }
    public function categories(): BelongsToMany { return $this->belongsToMany(Category::class, \'product_category\'); }

    // HELPERS
    public function getThumbnailUrlAttribute(): string
    {
        return $this->hasMedia(\'thumbnail\') ? $this->getFirstMediaUrl(\'thumbnail\') : asset(\'images/default-product.jpg\');
    }
}
') ?></div>
        </div>
    </div>
</section>

<!-- 5.3 Routes Vendeur -->
<section id="seance5-routes" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-5 mr-3">Séance 5</span>
        <h2 class="text-2xl font-bold text-gray-800">5.3 Routes Gestion Produits (Vendeur)</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Ajoutez la resource products dans le groupe Vendeur de <code>routes/web.php</code>.</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (routes/web.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('// Groupe Vendeur
Route::prefix(\'vendor\')->name(\'vendor.\')->middleware([\'auth\', \'verified\', \'vendor\'])->group(function () {
    // ... dashboard, store ...

    // AJOUTER ICI :
    Route::resource(\'products\', App\Http\Controllers\Vendor\ProductController::class);
});
') ?></div>
        </div>
    </div>
</section>

<!-- 5.4 ProductController -->
<section id="seance5-controller" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-5 mr-3">Séance 5</span>
        <h2 class="text-2xl font-bold text-gray-800">5.4 ProductController Vendeur</h2>
    </div>

    <div class="section-card">
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:controller Vendor/ProductController --resource</div>
        </div>

        <p class="mb-4 mt-4">Implémentez les méthodes <code>index</code>, <code>create</code> et <code>store</code> en gérant les médias :</p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP (Admin/ProductController.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        // Produits de la boutique du vendeur connecté
        $products = Auth::user()->store->products()->latest()->paginate(10);
        return view(\'vendor.products.index\', compact(\'products\'));
    }

    public function create()
    {
        $categories = Category::whereNull(\'parent_id\')->with(\'children\')->get();
        return view(\'vendor.products.create\', compact(\'categories\'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            \'name\' => \'required|string|max:255\',
            \'description\' => \'nullable|string\',
            \'price\' => \'required|numeric|min:0\',
            \'categories\' => \'required|array\',
            \'thumbnail\' => \'required|image|max:2048\', // Obligatoire
            \'gallery.*\' => \'image|max:2048\', // Galerie optionnelle
            \'digital_file\' => \'nullable|file|mimes:pdf,zip,epub|max:10240\', // 10Mo max
        ]);

        $store = Auth::user()->store;

        // Création Produit
        $product = $store->products()->create([
            \'name\' => [\'fr\' => $validated[\'name\']], // Défaut FR pour l\'instant
            \'description\' => [\'fr\' => $validated[\'description\'] ?? \'\'],
            \'price\' => $validated[\'price\'],
            \'slug\' => Str::slug($validated[\'name\']) . \'-\' . uniqid(),
            \'is_active\' => true,
        ]);

        // Catégories (Pivot)
        $product->categories()->attach($validated[\'categories\']);

        // 1. Thumbnail
        if ($request->hasFile(\'thumbnail\')) {
            $product->addMediaFromRequest(\'thumbnail\')->toMediaCollection(\'thumbnail\');
        }

        // 2. Galerie
        if ($request->hasFile(\'gallery\')) {
            foreach ($request->file(\'gallery\') as $image) {
                $product->addMedia($image)->toMediaCollection(\'gallery\');
            }
        }
        
        // 3. Fichier numérique
        if ($request->hasFile(\'digital_file\')) {
            $product->addMediaFromRequest(\'digital_file\')->toMediaCollection(\'digital_file\');
        }

        return redirect()->route(\'vendor.products.index\')
            ->with(\'success\', \'Produit ajouté avec succès !\');
    }
}
') ?></div>
        </div>
    </div>
</section>

<!-- 5.5 Vues Vendeur -->
<section id="seance5-views" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-5 mr-3">Séance 5</span>
        <h2 class="text-2xl font-bold text-gray-800">5.5 Vues : Formulaire Complet</h2>
    </div>

    <div class="section-card">
        <p class="mb-2">Créez <code>resources/views/vendor/products/create.blade.php</code> :</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau Produit</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route(\'vendor.products.store\') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 shadow rounded">
                @csrf
                
                <h3 class="text-lg font-bold mb-4">Informations de base</h3>
                
                <!-- Nom -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Nom du produit</label>
                    <input type="text" name="name" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                </div>

                <!-- Prix -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Prix (€)</label>
                    <input type="number" step="0.01" name="price" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                </div>
                
                <!-- Catégories -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-2">Catégories</label>
                    <div class="h-32 overflow-y-auto border p-2 rounded">
                        @foreach($categories as $category)
                            <div class="font-bold text-gray-800">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"> {{ $category->name }}
                            </div>
                            @foreach($category->children as $child)
                                <div class="ml-4 text-gray-600">
                                    <input type="checkbox" name="categories[]" value="{{ $child->id }}"> {{ $child->name }}
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <h3 class="text-lg font-bold mb-4 mt-8 border-t pt-4">Médias</h3>

                <!-- Thumbnail -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Image principale (Vignette)</label>
                    <input type="file" name="thumbnail" class="mt-1 block w-full" accept="image/*" required>
                </div>

                <!-- Galerie -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Galerie photos (Multiple)</label>
                    <input type="file" name="gallery[]" class="mt-1 block w-full" accept="image/*" multiple>
                    <p class="text-xs text-gray-500 mt-1">Maintenez CTRL pour sélectionner plusieurs images.</p>
                </div>

                <!-- Fichier Numérique -->
                <div class="mb-4 bg-blue-50 p-4 rounded border border-blue-200">
                    <label class="block font-medium text-sm text-blue-900">Fichier à télécharger (PDF, ZIP...)</label>
                    <input type="file" name="digital_file" class="mt-1 block w-full">
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                        Publier le produit
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>') ?></div>
        </div>
    </div>
</section>
