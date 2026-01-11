<?php
/**
 * SÉANCE 4 : Gestion des Catégories & Médias
 * 
 * Contenu technique : Code source exact du projet (Fidélité 100%).
 * Design : Bootstrap 5 via Vite + CSS Custom.
 */
?>

<!-- ===================================================================
     SÉANCE 4 : GESTION DES CATÉGORIES & MÉDIAS
     =================================================================== -->

<!-- 4.1 Introduction -->
<section id="seance4-intro" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-4 mr-3">Séance 4</span>
        <h2 class="text-2xl font-bold text-gray-800">4.1 Gestion des Catégories (Admin)</h2>
    </div>

    <div class="section-card">
        <p class="text-gray-700 leading-relaxed mb-4">
            Pour organiser les produits, nous avons besoin de catégories. Seul l'<strong>Administrateur</strong> peut les gérer.
            Nous allons utiliser <strong>Spatie Media Library</strong> pour gérer les images (thumbnails) des catégories.
        </p>
        <p class="mb-4 text-sm bg-blue-100 p-3 rounded">
            <strong>Rappel :</strong> Vous avez déjà installé <code>spatie/laravel-medialibrary</code> et <code>spatie/laravel-translatable</code> lors de la Séance 1.
            Nous allons maintenant les utiliser concrètement.
        </p>
    </div>
</section>

<!-- 4.2 Configuration Modèle -->
<section id="seance4-model" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-4 mr-3">Séance 4</span>
        <h2 class="text-2xl font-bold text-gray-800">4.2 Configuration du Modèle Category</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">
            Vérifiez votre fichier <code>app/Models/Category.php</code>. Il doit implémenter <code>HasMedia</code> et utiliser les traits nécessaires.
        </p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    // Définir les champs traduisibles
    public array $translatable = [\'name\', \'description\', \'meta_title\', \'meta_description\'];

    protected $fillable = [
        \'parent_id\', \'name\', \'description\', \'slug\', \'image\', \'icon\',
        \'is_active\', \'order\', \'meta_title\', \'meta_description\',
    ];

    protected function casts(): array
    {
        return [\'is_active\' => \'boolean\'];
    }

    // Configuration Spatie Media Library
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(\'image\')->singleFile();
    }

    // Relations
    public function parent(): BelongsTo { return $this->belongsTo(Category::class, \'parent_id\'); }
    public function children(): HasMany { return $this->hasMany(Category::class, \'parent_id\'); }
    public function products(): BelongsToMany { return $this->belongsToMany(Product::class, \'product_category\'); }

    // Helpers
    public function getImageUrlAttribute(): string
    {
        return $this->hasMedia(\'image\') ? $this->getFirstMediaUrl(\'image\') : asset(\'images/default-category.jpg\');
    }
}
') ?></div>
        </div>
    </div>
</section>

<!-- 4.3 CategoryController -->
<section id="seance4-controller" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-4 mr-3">Séance 4</span>
        <h2 class="text-2xl font-bold text-gray-800">4.3 CategoryController (Admin)</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Créez le contrôleur pour l'administration.</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:controller Admin/CategoryController --resource</div>
        </div>

        <p class="mb-4 mt-4">Voici le code complet pour gérer le CRUD et l'upload d'images :</p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP (Admin/CategoryController.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // On charge les catégories racines et leurs enfants eagérément
        $categories = Category::whereNull(\'parent_id\')
            ->with(\'children\')
            ->orderBy(\'order\')
            ->get();
            
        return view(\'admin.categories.index\', compact(\'categories\'));
    }

    public function create()
    {
        $parents = Category::whereNull(\'parent_id\')->get();
        return view(\'admin.categories.create\', compact(\'parents\'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            \'name\' => \'required|string|max:255\',
            \'parent_id\' => \'nullable|exists:categories,id\',
            \'description\' => \'nullable|string\',
            \'image\' => \'nullable|image|max:2048\', // 2Mo max
            //   \'is_active\' => \'nullable|boolean\',
        ]);

        // Création avec traduction basique (FR par défaut)
        // Pour un vrai multi-langue, on demanderait un tableau
        $category = Category::create([
            \'name\' => [\'fr\' => $request[\'name\']],
            \'description\' => [\'fr\' => $request[\'description\'] ?? null],
            \'parent_id\' => $request[\'parent_id\'],
            \'slug\' => Str::slug($request[\'name\']),
            \'is_active\' => $request->has(\'is_active\'),
        ]);

        if ($request->hasFile(\'image\')) {
            $category->addMediaFromRequest(\'image\')->toMediaCollection(\'image\');
        }

        return redirect()->route(\'admin.categories.index\')
            ->with(\'success\', \'Catégorie créée avec succès.\');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull(\'parent_id\')->where(\'id\', \'!=\', $category->id)->get();
        return view(\'admin.categories.edit\', compact(\'category\', \'parents\'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            \'name\' => \'required|string|max:255\',
            \'parent_id\' => \'nullable|exists:categories,id\',
            \'description\' => \'nullable|string\',
            \'image\' => \'nullable|image|max:2048\',
            //   \'is_active\' => \'nullable|boolean\',
        ]);

        $category->update([
            \'name\' => [\'fr\' => $validated[\'name\']], // Mise à jour FR
            \'parent_id\' => $validated[\'parent_id\'],
            \'is_active\' => $request->has(\'is_active\'),
        ]);

        if ($request->hasFile(\'image\')) {
            $category->clearMediaCollection(\'image\');
            $category->addMediaFromRequest(\'image\')->toMediaCollection(\'image\');
        }

        return redirect()->route(\'admin.categories.index\')
            ->with(\'success\', \'Catégorie mise à jour.\');
    }

    public function destroy(Category $category)
    {
        if ($category->children()->count() > 0) {
            return back()->with(\'error\', \'Impossible de supprimer une catégorie qui a des enfants.\');
        }
        
        $category->delete();
        return redirect()->route(\'admin.categories.index\')
            ->with(\'success\', \'Catégorie supprimée.\');
    }
}
') ?></div>
        </div>
    </div>
</section>

<!-- 4.4 Routes Admin -->
<section id="seance4-routes" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-4 mr-3">Séance 4</span>
        <h2 class="text-2xl font-bold text-gray-800">4.4 Routes Admin</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Ajoutez la route resource dans le groupe Admin de <code>routes/web.php</code> :</p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP (routes/web.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('// Groupe Admin existant...
Route::middleware([\'auth\', \'role:admin\'])->prefix(\'admin\')->name(\'admin.\')->group(function () {
    Route::get(\'/dashboard\', [App\Http\Controllers\Admin\DashboardController::class, \'index\'])->name(\'dashboard\');
    
    // --> AJOUTER ICI :
    Route::resource(\'categories\', App\Http\Controllers\Admin\CategoryController::class);
});
') ?></div>
        </div>
    </div>
</section>

<!-- 4.5 Vues Admin -->
<section id="seance4-views" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-4 mr-3">Séance 4</span>
        <h2 class="text-2xl font-bold text-gray-800">4.5 Vues Admin (Blade)</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Créez le dossier <code>resources/views/admin/categories</code>.</p>

        <!-- Index -->
        <h4 class="font-bold text-gray-800 mb-2">A. Liste (index.blade.php)</h4>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des Catégories</h2>
            <a href="{{ route(\'admin.categories.create\') }}" class="btn btn-primary">
                + Nouvelle Catégorie
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session(\'success\'))
                    <div class="alert alert-success mb-4">{{ session(\'success\') }}</div>
                @endif
                
                @if(session(\'error\'))
                    <div class="alert alert-danger mb-4">{{ session(\'error\') }}</div>
                @endif

                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <!-- Catégorie Parent -->
                            <tr>
                                <td>
                                    <img src="{{ $category->image_url }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td class="fw-bold">{{ $category->name }}</td>
                                <td class="text-muted">{{ $category->slug }}</td>
                                <td>-</td>
                                <td>
                                    @if($category->is_active) 
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-secondary">Inactif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route(\'admin.categories.edit\', $category) }}" class="btn btn-sm btn-outline-primary">Éditer</a>
                                </td>
                            </tr>
                            
                            <!-- Sous-catégories -->
                            @foreach($category->children as $child)
                            <tr>
                                <td>
                                    <div class="ms-4">
                                        <img src="{{ $child->image_url }}" class="rounded" style="width: 30px; height: 30px; object-fit: cover;">
                                    </div>
                                </td>
                                <td>
                                    <div class="ms-4">↳ {{ $child->name }}</div>
                                </td>
                                <td class="text-muted">{{ $child->slug }}</td>
                                <td class="text-sm text-muted">{{ $category->name }}</td>
                                <td>
                                    @if($child->is_active) 
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-secondary">Inactif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route(\'admin.categories.edit\', $child) }}" class="btn btn-sm btn-outline-primary">Éditer</a>
                                    <form action="{{ route(\'admin.categories.destroy\', $child) }}" method="POST" class="d-inline" onsubmit="return confirm(\'Confirmer la suppression ?\')">
                                        @csrf @method(\'DELETE\')
                                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>') ?></div>
        </div>

        <!-- Create -->
        <h4 class="font-bold text-gray-800 mb-2 mt-6">B. Création (create.blade.php)</h4>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvelle Catégorie</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route(\'admin.categories.store\') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error(\'name\') is-invalid @enderror" required value="{{ old(\'name\') }}">
                        @error(\'name\')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catégorie Parente</label>
                        <select name="parent_id" class="form-select @error(\'parent_id\') is-invalid @enderror">
                            <option value="">Aucune (Catégorie principale)</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old(\'parent_id\') == $parent->id ? \'selected\' : \'\' }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error(\'parent_id\')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error(\'description\') is-invalid @enderror" rows="3">{{ old(\'description\') }}</textarea>
                        @error(\'description\')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control @error(\'image\') is-invalid @enderror" accept="image/*">
                        @error(\'image\')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="activeCheck" checked>
                        <label class="form-check-label" for="activeCheck">Catégorie active</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route(\'admin.categories.index\') }}" class="btn btn-link me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>') ?></div>
        </div>

        <!-- Edit -->
        <h4 class="font-bold text-gray-800 mb-2 mt-6">C. Édition (edit.blade.php)</h4>
        <p class="text-sm">Similaire à <code>create</code>, mais avec <code>@method('PUT')</code> et les valeurs pré-remplies.</p>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Éditer : {{ $category->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route(\'admin.categories.update\', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method(\'PUT\')
                    
                    <div class="mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ $category->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catégorie Parente</label>
                        <select name="parent_id" class="form-select">
                            <option value="">Aucune (Catégorie principale)</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->id)>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image Actuelle</label>
                        <div class="mb-2">
                            <img src="{{ $category->image_url }}" class="rounded" width="100">
                        </div>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="activeCheck" @checked($category->is_active)>
                        <label class="form-check-label" for="activeCheck">Catégorie active</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route(\'admin.categories.index\') }}" class="btn btn-link me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>') ?></div>
        </div>
    </div>
</section>

<!-- 4.6 Navigation -->
<section id="seance4-nav" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-4 mr-3">Séance 4</span>
        <h2 class="text-2xl font-bold text-gray-800">4.6 Ajout au Menu de Navigation</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Modifiez <code>resources/views/layouts/navigation.blade.php</code> pour ajouter le lien vers la gestion des catégories pour les admins :</p>

        <div class="code-block-wrapper">
            <div class="code-lang">HTML (layouts/navigation.blade.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route(\'dashboard\')" :active="request()->routeIs(\'dashboard\')">
                        {{ __(\'Dashboard\') }}
                    </x-nav-link>
                    @auth
                        @if(Auth::user()->hasRole(\'admin\'))
                            <x-nav-link :href="route(\'admin.categories.index\')" :active="request()->routeIs(\'admin.categories.*\')">
                                Gestion Catégories
                            </x-nav-link>
                        @endif
                    @endauth
                </div>') ?></div>
        </div>
    </div>
</section>

<!-- 4.7 Verification -->
<section id="seance4-verify" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-4 mr-3">Séance 4</span>
        <h2 class="text-2xl font-bold text-gray-800">✅ Vérification</h2>
    </div>

    <div class="section-card bg-green-50">
        <ol class="list-decimal ml-5 space-y-2 mt-2">
            <li>Connectez-vous en tant qu'<strong>Admin</strong>.</li>
            <li>Allez sur <code>/admin/categories</code>.</li>
            <li>Créez une catégorie "Logiciels" avec une image.</li>
            <li>Créez une sous-catégorie "Antivirus" (parent: Logiciels).</li>
            <li>Vérifiez que les images s'affichent bien dans la liste.</li>
        </ol>
    </div>
</section>
