<?php
/**
 * SÉANCE 2 : Authentification & Gestion des Rôles
 * 
 * Contenu technique : Code source exact du projet (Fidélité 100%).
 * Design : Modifié pour être professionnel (Bootstrap 5 via Vite + CSS Custom).
 */
?>

<!-- ===================================================================
     SÉANCE 2 : AUTHENTIFICATION & DASHBOARDS
     =================================================================== -->

<!-- 2.1 Installation Breeze -->
<section id="seance2-breeze" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.1 Installation de Laravel Breeze</h2>
    </div>

    <div class="section-card">
        <p class="text-gray-700 leading-relaxed mb-4">
            Pour l'inscription et la connexion, nous utilisons <strong>Laravel Breeze</strong>. 
        </p>

        <h3 class="text-xl font-bold text-gray-800 mb-4">étape 1 : Installer le package</h3>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">composer require laravel/breeze --dev
php artisan breeze:install blade</div>
        </div>
        <p class="text-sm text-gray-500 mt-2">Répondez "No" au support du Dark Mode et "PHPUnit" pour les tests.</p>
        
        <p class="mt-4 mb-2">Installez les dépendances front-end :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">npm install
npm run dev</div>
        </div>
    </div>
</section>

<!-- 2.1b Restauration après Breeze -->
<section id="seance2-restore" class="mb-16 scroll-mt-20">
    <div class="section-card border-l-4 border-yellow-500 bg-yellow-50">
        <h3 class="text-xl font-bold text-yellow-800 mb-4">⚠️ IMPORTANT : Restauration des fichiers</h3>
        <p class="text-yellow-800 mb-4">
            L'installation de Breeze a écrasé <code>web.php</code>, <code>app.js</code> et <code>app.css</code>. 
            Nous devons remettre notre configuration Bootstrap et nos routes de la Séance 1.
        </p>

        <h4 class="font-bold text-gray-800 mb-2">1. Réparer resources/js/app.js</h4>
        <p class="text-sm mb-2">Gardez Alpine.js (pour Breeze) mais remettez Bootstrap :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">JS</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars("import './bootstrap';

// Réintégration de Bootstrap (Séance 1)
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import * as bootstrap from 'bootstrap';

// Alpine.js (Breeze)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();") ?></div>
        </div>

        <h4 class="font-bold text-gray-800 mb-2 mt-4">2. Réparer resources/css/app.css</h4>
        <p class="text-sm mb-2">Remettez votre CSS personnalisé :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">CSS</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars("@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
    color: #1e293b;
}

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

.btn-primary {
    background-color: #3b82f6;
    border-color: #3b82f6;
    padding: 0.5rem 1.25rem;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #2563eb;
    border-color: #2563eb;
}

.navbar {
    backdrop-filter: blur(8px);
    background-color: rgba(255, 255, 255, 0.95) !important;
}") ?></div>
        </div>

        <h4 class="font-bold text-gray-800 mb-2 mt-4">3. Réparer routes/web.php</h4>
        <p class="text-sm mb-2">Combinez les routes de la Séance 1 et celles de Breeze :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars(<<<'PHP'
<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use App\Http\Controllers\ProfileController;

// --- ROUTES SÉANCE 1 (Rétablies) ---

Route::get('/', function () {
    $products = Product::where('is_active', true)
        ->with(['store', 'categories'])
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();
        
    $categories = Category::where('is_active', true)->take(6)->get();
    $featuredStores = Store::where('is_active', true)->take(4)->get();

    return view('welcome', compact('products', 'categories', 'featuredStores'));
})->name('home');

Route::get('/category/{slug}', function ($slug) {
    $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
    
    $products = Product::where('is_active', true)
        ->whereHas('categories', function($q) use ($category) {
            $q->where('categories.id', $category->id);
        })
        ->with(['store', 'categories'])
        ->paginate(12);

    return view('categories.show', compact('category', 'products'));
})->name('categories.show');

Route::get('/product/{slug}', function ($slug) {
    $product = Product::where('slug', $slug)
        ->where('is_active', true)
        ->with(['store', 'categories'])
        ->firstOrFail();
        
    $product->increment('views_count');
    
    $relatedProducts = Product::where('is_active', true)
        ->where('id', '!=', $product->id)
        ->whereHas('categories', function($q) use ($product) {
            $q->whereIn('categories.id', $product->categories->pluck('id'));
        })
        ->take(4)
        ->get();

    return view('products.show', compact('product', 'relatedProducts'));
})->name('products.show');

// --- ROUTES BREEZE (Gardées) ---

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
PHP
) ?></div>
        </div>
    </div>
</section>

<!-- 2.2 Activation Email -->
<section id="seance2-email" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.2 Activation du compte par Email</h2>
    </div>

    <div class="section-card">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Configuration SMTP (Gmail)</h3>
        <p class="mb-4">Ajoutez ces variables dans votre fichier <code>.env</code> :</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">ENV</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=ousrah@gmail.com
MAIL_PASSWORD=xxxxxxxxxxxxx # Mot de passe d'application Google
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="ousrah@gmail.com"
MAIL_FROM_NAME="portaledu"
MAIL_SCHEME=null</div>
        </div>
        <div class="alert alert-warning mt-4">
            <strong>Important :</strong> Utilisez un "Mot de passe d'application" généré dans votre compte Google (Sécurité > Validation en 2 étapes), pas votre mot de passe habituel.
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-4 mt-6">Implémenter MustVerifyEmail</h3>
        <p class="mb-4">Dans <code>app/Models/User.php</code> :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    // ...
}') ?></div>
        </div>
    </div>
</section>

<!-- 2.3 Login Customization -->
<section id="seance2-login" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.3 Personnalisation du Login (Remember Me)</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Assurez-vous que la case "Se souvenir de moi" est présente dans <code>resources/views/auth/login.blade.php</code> :</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<!-- Remember Me -->
<div class="block mt-4">
    <label for="remember_me" class="inline-flex items-center">
        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
        <span class="ms-2 text-sm text-gray-600">{{ __(\'Se souvenir de moi\') }}</span>
    </label>
</div>') ?></div>
        </div>
    </div>
</section>

<!-- 2.4 Permissions avec Spatie -->
<section id="seance2-spatie" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.4 Rôles et Permissions (Spatie)</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">
            Nous avons 3 types d'utilisateurs : <strong>Admin</strong>, <strong>Vendeur</strong> et <strong>Client</strong>.
        </p>

        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate</div>
        </div>
    </div>
</section>

<!-- 2.4a Modification Table Users -->
<section id="seance2-users-migration" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.4a Modification de la table Users</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">
            Nous devons ajouter le champ <code>is_vendor</code> et <code>vendor_verified_at</code> à la table users.
        </p>

        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:migration add_vendor_fields_to_users_table --table=users</div>
        </div>

        <p class="mb-2 mt-4">Dans la nouvelle migration créée (<code>database/migrations/xxxx_xx_xx_xxxxxx_add_vendor_fields_to_users_table.php</code>) :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('public function up(): void
{
    Schema::table(\'users\', function (Blueprint $table) {
        $table->boolean(\'is_vendor\')->default(false)->after(\'email\');
        $table->timestamp(\'vendor_verified_at\')->nullable()->after(\'is_vendor\');
    });
}

public function down(): void
{
    Schema::table(\'users\', function (Blueprint $table) {
        $table->dropColumn([\'is_vendor\', \'vendor_verified_at\']);
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

<!-- 2.4b Configuration Middleware -->
<section id="seance2-middleware" class="mb-16 scroll-mt-20">
    <div class="section-card border-l-4 border-blue-500 bg-blue-50">
        <h3 class="text-xl font-bold text-blue-800 mb-4">ℹ️ Configuration des Middlewares</h3>
        <p class="text-blue-800 mb-4">
            Pour utiliser <code>role:admin</code> dans vos routes, vous devez enregistrer les middlewares de Spatie.
        </p>
        <p class="mb-2">Ouvrez <code>bootstrap/app.php</code> et ajoutez les alias dans <code>withMiddleware</code> :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars(<<<'PHP'
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
PHP
) ?></div>
        </div>
    </div>
</section>

<!-- 2.5 Modèle User -->
<section id="seance2-user-model" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.5 Configuration du Modèle User</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Ouvrez <code>app/Models/User.php</code>. Ajoutez le trait <code>HasRoles</code>.</p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP (app/Models/User.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // <-- AJOUT

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        \'name\', \'email\', \'password\', \'is_vendor\', \'vendor_verified_at\'
    ];

    protected $hidden = [\'password\', \'remember_token\'];

    protected function casts(): array
    {
        return [
            \'email_verified_at\' => \'datetime\',
            \'password\' => \'hashed\',
            \'is_vendor\' => \'boolean\',
        ];
    }
    
    // Helpers
    public function isVerifiedVendor(): bool { return $this->is_vendor && $this->vendor_verified_at !== null; }
    public function isAdmin(): bool { return $this->hasRole(\'admin\'); }
    public function isCustomer(): bool { return $this->hasRole(\'customer\'); }
}') ?></div>
        </div>
    </div>
</section>

<!-- 2.6 Création des Rôles -->
<section id="seance2-roles" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.6 Seeder des Rôles</h2>
    </div>

    <div class="section-card">
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:seeder RolesAndPermissionsSeeder</div>
        </div>

        <p class="mb-2 mt-4">Dans <code>database/seeders/RolesAndPermissionsSeeder.php</code> :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('public function run(): void
{
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    $roleAdmin = \Spatie\Permission\Models\Role::create([\'name\' => \'admin\']);
    $roleVendor = \Spatie\Permission\Models\Role::create([\'name\' => \'vendor\']);
    $roleCustomer = \Spatie\Permission\Models\Role::create([\'name\' => \'customer\']);
}') ?></div>
        </div>
        
        <p class="mb-2 mt-4">Dans <code>database/seeders/DatabaseSeeder.php</code>, appelez ce seeder en premier :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">$this->call(RolesAndPermissionsSeeder::class);</div>
        </div>
        
        <div class="code-block-wrapper mt-4">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan migrate:fresh --seed</div>
        </div>
    </div>
</section>

<!-- 2.7 Redirection Login -->
<section id="seance2-redirect" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.7 Redirection Intelligente</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Nous voulons rediriger l'utilisateur vers son dashboard spécifique après le login.</p>
        <p>Modifiez <code>app/Http/Controllers/Auth/AuthenticatedSessionController.php</code>, méthode <code>store</code> :</p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // Redirection selon le rôle
    if ($request->user()->hasRole(\'admin\')) {
        return redirect()->intended(\'admin/dashboard\');
    }
    
    if ($request->user()->hasRole(\'vendor\')) {
        return redirect()->intended(\'vendor/dashboard\');
    }

    return redirect()->intended(\'dashboard\'); // Client par défaut
}') ?></div>
        </div>
    </div>
</section>

<!-- 2.8 Contrôleurs Dashboards -->
<section id="seance2-controllers" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.8 Création des Contrôleurs</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Créez les contrôleurs pour chaque espace.</p>

        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:controller Admin/DashboardController
php artisan make:controller Vendor/DashboardController</div>
        </div>

        <p class="mt-4 mb-2"><code>app/Http/Controllers/Admin/DashboardController.php</code> :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            \'users\' => User::count(),
            \'stores\' => Store::count(),
            \'pending_stores\' => Store::where(\'is_active\', false)->count()
        ];
        return view(\'admin.dashboard\', compact(\'stats\'));
    }
}') ?></div>
        </div>

        <p class="mt-4 mb-2"><code>app/Http/Controllers/Vendor/DashboardController.php</code> :</p>
        <div class="code-block-wrapper">
            <div class="code-lang">PHP</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php
namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store; // Suppose une relation hasOne dans User
        return view(\'vendor.dashboard\', compact(\'store\'));
    }
}') ?></div>
        </div>
    </div>
</section>

<!-- 2.9 Routes -->
<section id="seance2-routes" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.9 Configuration des Routes</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Ajoutez ces groupes de routes dans <code>routes/web.php</code> :</p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP (routes/web.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('// ... Auth Routes (Breeze) ...

// Groupe Admin
Route::middleware([\'auth\', \'role:admin\'])->prefix(\'admin\')->name(\'admin.\')->group(function () {
    Route::get(\'/dashboard\', [App\Http\Controllers\Admin\DashboardController::class, \'index\'])->name(\'dashboard\');
});

// Groupe Vendeur
Route::middleware([\'auth\', \'role:vendor\'])->prefix(\'vendor\')->name(\'vendor.\')->group(function () {
    Route::get(\'/dashboard\', [App\Http\Controllers\Vendor\DashboardController::class, \'index\'])->name(\'dashboard\');
});

// Tableau de bord Client (Breeze par défaut modifié)
Route::middleware([\'auth\', \'verified\'])->get(\'/dashboard\', function () {
    return view(\'dashboard\');
})->name(\'dashboard\');') ?></div>
        </div>
    </div>
</section>

<!-- 2.10 Vues -->
<section id="seance2-views" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
        <h2 class="text-2xl font-bold text-gray-800">2.10 Vues des Dashboards</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Créez les dossiers <code>resources/views/admin</code> et <code>resources/views/vendor</code>.</p>

        <h4 class="font-bold text-gray-800 mb-2">A. Dashboard Admin (admin/dashboard.blade.php)</h4>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Carte Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 font-bold text-xl">{{ $stats[\'users\'] }}</div>
                    <div class="text-gray-600">Utilisateurs</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 font-bold text-xl">{{ $stats[\'stores\'] }}</div>
                    <div class="text-gray-600">Boutiques</div>
                </div>
                <div class="bg-red-50 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-red-900 font-bold text-xl">{{ $stats[\'pending_stores\'] }}</div>
                    <div class="text-red-600">En attente</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>') ?></div>
        </div>

        <h4 class="font-bold text-gray-800 mb-2 mt-4">B. Dashboard Vendeur (vendor/dashboard.blade.php)</h4>
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Espace Vendeur</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($store)
                        <h3 class="text-lg font-bold mb-4">Bienvenue, {{ $store->name }}</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" class="block p-4 border rounded hover:bg-gray-50">
                                <span class="font-bold text-blue-600">📦 Mes Produits</span>
                            </a>
                            <a href="#" class="block p-4 border rounded hover:bg-gray-50">
                                <span class="font-bold text-green-600">💰 Mes Ventes</span>
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Vous n\'avez pas encore de boutique active. <a href="#" class="underline">Créer ma boutique</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>') ?></div>
        </div>
        
        <h4 class="font-bold text-gray-800 mb-2 mt-4">C. Dashboard Client (dashboard.blade.php)</h4>
        <p class="text-sm">Laissez ou modifiez le fichier par défaut de Breeze pour afficher "Mes Commandes" et "Mes Téléchargements".</p>
    </div>
</section>
