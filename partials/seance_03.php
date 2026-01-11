<?php
/**
 * SÉANCE 3 : Gestion Multi-Vendeurs (Stores)
 * 
 * Contenu technique : Code source exact du projet (Fidélité 100%).
 * Design : Ancien design (Tailwind + CSS perso).
 */
?>

<!-- ===================================================================
     SÉANCE 3 : BOUTIQUES VENDEURS
     =================================================================== -->

<!-- 3.1 Introduction -->
<section id="seance3-intro" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.1 Tableau de Bord Vendeur & Gestion Boutique</h2>
    </div>

    <div class="section-card">
        <p class="text-gray-700 leading-relaxed mb-4">
            Dans cette séance, nous permettons aux utilisateurs authentifiés de devenir vendeurs en créant leur propre boutique.
            Une fois la boutique créée, ils auront accès à leur tableau de bord vendeur.
        </p>
        <p class="mb-4 text-sm bg-blue-100 p-3 rounded">
            <strong>Architecture :</strong> Nous séparons les routes "Vendeur" (<code>/vendor/*</code>) des routes "Client".
            Un middleware <code>vendor</code> protégera l'accès.
        </p>
    </div>
</section>

<!-- 3.2 Routes Vendeur -->
<section id="seance3-routes" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.2 Routes Vendeur & Middleware</h2>
    </div>

    <div class="section-card">
        <h3 class="text-xl font-bold text-gray-800 mb-4">étape 1 : Le Middleware Vendor</h3>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:middleware VendorMiddleware</div>
        </div>

        <p class="mb-2 mt-2">Vérifiez que l'utilisateur a le rôle 'vendor' ou 'admin'. Fichier : <code>app/Http/Middleware/VendorMiddleware.php</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('public function handle(Request $request, Closure $next): Response
{
    // Si Admin, on laisse passer
    if ($request->user()->hasRole(\'admin\')) {
        return $next($request);
    }

    // Si pas vendeur, redirection
    if (!$request->user()->is_vendor) {
        return redirect()->route(\'become.vendor\');
    }

    return $next($request);
}') ?></div>
        </div>

        <p class="mb-2 mt-4 font-bold text-gray-800">Enregistrez le middleware (Laravel 11/12 : bootstrap/app.php)</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (bootstrap/app.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        \'vendor\' => \App\Http\Middleware\VendorMiddleware::class,
    ]);
})') ?></div>
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">étape 2 : Routes (routes/web.php)</h3>
        <p class="mb-2">Ajoutez ces routes pour gérer la création de boutique (pour devenir vendeur) et l'espace vendeur.</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (routes/web.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('// Routes pour devenir vendeur (Accessible aux connectés non-vendeurs)
Route::middleware([\'auth\', \'verified\'])->group(function () {
    Route::get(\'/become-vendor\', [\App\Http\Controllers\Vendor\StoreController::class, \'create\'])->name(\'become.vendor\');
    Route::post(\'/become-vendor\', [\App\Http\Controllers\Vendor\StoreController::class, \'store\'])->name(\'vendor.store.store2\');
});

// Espace Vendeur (Accessible uniquement aux Vendeurs)
Route::prefix(\'vendor\')->name(\'vendor.\')->middleware([\'auth\', \'verified\', \'vendor\'])->group(function () {
    
    Route::get(\'/dashboard\', [\App\Http\Controllers\Vendor\DashboardController::class, \'index\'])->name(\'dashboard\');
    
    // Gestion de la boutique (Vendeur existant)
    Route::get(\'/store\', [\App\Http\Controllers\Vendor\StoreController::class, \'edit\'])->name(\'store.edit\');
    Route::put(\'/store\', [\App\Http\Controllers\Vendor\StoreController::class, \'update\'])->name(\'store.update\');
});') ?></div>
        </div>
    </div>
</section>

</section>

<!-- 3.3a Modèle Store -->
<section id="seance3-store-model" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.3a Mise à jour du Modèle Store</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">
            Assurez-vous que le champ <code>description</code> est bien présent dans la propriété <code>$fillable</code> de votre modèle <code>app/Models/Store.php</code> pour permettre sa modification.
        </p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP (app/Models/Store.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations, LogsActivity;

    public array $translatable = [\'name\', \'description\', \'short_description\', \'meta_title\', \'meta_description\'];

    protected $fillable = [
        \'user_id\',
        \'name\',
        \'slug\',
        \'description\',
        \'logo\',
        \'banner\',
        \'is_active\',
        \'is_featured\',
        \'commission_rate\'
    ];
    
    // ... reste du modèle
}') ?></div>
        </div>
    </div>
</section>

<!-- 3.3b Migration Commission Rate -->
<section id="seance3-migration-commission" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.3b Migration Commission Rate</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">
            Ajoutez le champ <code>commission_rate</code> à la table <code>stores</code> pour gérer les commissions.
        </p>

        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:migration add_commission_rate_to_stores_table --table=stores</div>
        </div>

        <p class="mb-2 mt-4">Cochez le fichier de migration :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('public function up(): void
{
    Schema::table(\'stores\', function (Blueprint $table) {
        $table->decimal(\'commission_rate\', 5, 2)->default(10.00)->after(\'description\');
    });
}

public function down(): void
{
    Schema::table(\'stores\', function (Blueprint $table) {
        $table->dropColumn(\'commission_rate\');
    });
}') ?></div>
        </div>

        <div class="code-block-wrapper mt-4">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan migrate</div>
        </div>
    </div>
</section>

<!-- 3.3 Contrôleur & Logique -->
<section id="seance3-controller" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.3 Logique : Vendor\StoreController</h2>
    </div>

    <div class="section-card">
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:controller Vendor/StoreController</div>
        </div>

        <p class="mb-2 mt-4">Copiez la méthode <code>store()</code> exacte pour la création de boutique.</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (app/Http/Controllers/Vendor/StoreController.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('public function create()
{
    // Si l\'utilisateur a déjà une boutique, redirection
    if (Auth()->user()->is_vendor) {
        return redirect()->route(\'vendor.dashboard\');
    }
    return view(\'vendor.store.create\');
}

public function store(Request $request)
{
    $validated = $request->validate([
        \'name\' => \'required|string|max:255\',
        \'description\' => \'nullable|string|max:1000\',
        \'logo\' => \'nullable|image|max:1024\', // Max 1Mo
    ]);

    $user = Auth()->user();

    // 1. Créer la boutique
    $store = \App\Models\Store::create([
        \'user_id\' => $user->id,
        \'name\' => [\'fr\' => $validated[\'name\']], // Translatable
        \'description\' => [\'fr\' => $validated[\'description\'] ?? null],
        \'slug\' => \Illuminate\Support\Str::slug($validated[\'name\']),
        \'commission_rate\' => 10.00,
        \'is_active\' => true,
    ]);

    // 2. Assigner le rôle Vendeur
    $user->update([\'is_vendor\' => true]);
    $user->assignRole(\'vendor\');

    // 3. Gestion du Logo (Spatie Media Library)
    if ($request->hasFile(\'logo\')) {
        $store->addMediaFromRequest(\'logo\')->toMediaCollection(\'logo\');
    }

    return redirect()->route(\'vendor.dashboard\')
        ->with(\'success\', \'Boutique créée avec succès !\');
}') ?></div>
        </div>
        
        <div class="alert-info mt-4">
            <p><strong>Remarque :</strong> Notez l'utilisation de <code>$user->assignRole('vendor')</code> qui met à jour les permissions de l'utilisateur automatiquement.</p>
        </div>
    </div>
</section>

<!-- 3.4 Vues (Blade) -->
<section id="seance3-views" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.4 La Vue de Création de Boutique</h2>
    </div>

    <div class="section-card">
        <p class="mb-2">Créez le fichier <code>resources/views/vendor/store/create.blade.php</code>.</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">HTML (create.blade.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Ouvrir ma boutique") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Affichage des erreurs globales --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route(\'vendor.store.store2\') }}" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Nom --}}
                        <div class="mb-3">
                            <label class="form-label">Nom de la boutique <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error(\'name\') is-invalid @enderror" required value="{{ old(\'name\') }}">
                            @error(\'name\')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error(\'description\') is-invalid @enderror" rows="4">{{ old(\'description\') }}</textarea>
                            @error(\'description\')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Logo --}}
                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" name="logo" class="form-control @error(\'logo\') is-invalid @enderror" accept="image/*">
                            @error(\'logo\')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-shop me-2"></i>Créer ma boutique
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>') ?></div>
        </div>
    </div>
</section>

<!-- 3.5 Navigation -->
<section id="seance3-nav" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.5 Mise à jour de la Navigation</h2>
    </div>

    <div class="section-card">
        <p class="mb-2">Pour accéder facilement à ces pages, mettez à jour votre barre de navigation (ex: <code>resources/views/layouts/navigation.blade.php</code> ou votre layout principal).</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('@auth
    @if(Auth::user()->is_vendor)
        <a href="{{ route(\'vendor.dashboard\') }}" class="nav-link">Dashboard Vendeur</a>
    @elseif(Auth::user()->hasRole(\'admin\'))
        <a href="{{ route(\'admin.dashboard\') }}" class="nav-link">Dashboard Admin</a>
    @else
        <a href="{{ route(\'become.vendor\') }}" class="btn btn-outline-primary">Devenir Vendeur</a>
        
    @endif
    
   
@else
    <a href="{{ route(\'login\') }}" class="nav-link">Connexion</a>
    <a href="{{ route(\'register\') }}" class="nav-link">Inscription</a>
@endauth
&nbsp;') ?>
</div>
        </div>
    </div>
</section>

<!-- 3.5b Mise à jour du Dashboard -->
<section id="seance3-dashboard-update" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.5b Mise à jour du Dashboard Vendeur</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">
            Modifiez <code>resources/views/vendor/dashboard.blade.php</code> pour afficher le nom de la boutique si elle existe, sinon le lien de création.
        </p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">HTML (extrait)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<div class="p-6 text-gray-900">
    @if(Auth::user()->store)
        <h3 class="text-lg font-bold mb-4">Bienvenue, {{ Auth::user()->store->name }}</h3>
    @else
        <div class="alert alert-warning">
            Vous n\'avez pas encore de boutique active. <a href="{{ route(\'become.vendor\') }}" class="underline">Créer ma boutique</a>.
        </div>
    @endif
</div>') ?></div>
        </div>
    </div>
</section>

<!-- 3.5b Mise à jour du modèle User -->
<section id="seance3-dashboard-update" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.5b Mise à jour du Dashboard Vendeur</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">
            Modifiez <code>app/Models/User.php</code> pour ajouter la relation avec le modèle Store.
        </p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (app/Models/User.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars(' public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }') ?></div>
        </div>
    </div>
</section>


<!-- 3.6 Vérification -->
<section id="seance3-verification" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
        <h2 class="text-2xl font-bold text-gray-800">3.6 Testez votre travail</h2>
    </div>

    <div class="section-card bg-green-50">
        <ol class="list-decimal ml-5 space-y-2 mt-2">
            <li>Connectez-vous avec un compte utilisateur normal.</li>
            <li>Cliquez sur "Devenir Vendeur" ou allez sur <code>/become-vendor</code>.</li>
            <li>Remplissez le formulaire et validez.</li>
            <li>Vérifiez que vous êtes redirigé (vers le dashboard vendeur ou store.edit) et que vous avez maintenant le rôle 'vendor' en base de données.</li>
        </ol>
    </div>
</section>
