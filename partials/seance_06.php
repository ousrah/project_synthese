<?php
/**
 * SÉANCE 6 : Panier (Cart JavaScript/Session)
 * 
 * Contenu technique : Code source exact du projet (Fidélité 100%).
 * Design : Bootstrap 5 via Vite + CSS Custom.
 */
?>

<!-- ===================================================================
     SÉANCE 6 : GESTION DU PANIER (AJAX & SESSION)
     =================================================================== -->

<!-- 6.1 Introduction -->
<section id="seance6-intro" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-6 mr-3">Séance 6</span>
        <h2 class="text-2xl font-bold text-gray-800">6.1 Architecture du Panier</h2>
    </div>

    <div class="section-card">
        <p class="text-gray-700 leading-relaxed mb-4">
            Pour le panier, nous allons utiliser une approche hybride moderne :
        </p>
        <ul class="list-disc ml-5 mb-4 text-gray-700">
            <li><strong>Stockage Session (PHP) :</strong> Le panier est stocké côté serveur dans la session (sûr et persistant).</li>
            <li><strong>Interface (JavaScript/AJAX) :</strong> Tout se passe sans rechargement de page.</li>
            <li><strong>API Interne :</strong> Des routes spéciales en <code>routes/web.php</code> (mais préfixées <code>api/</code>) servent le JSON.</li>
        </p>
    </div>
</section>

<!-- 6.2 CartController -->
<section id="seance6-api" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-6 mr-3">Séance 6</span>
        <h2 class="text-2xl font-bold text-gray-800">6.2 API CartController (Session)</h2>
    </div>

    <div class="section-card">
        <div class="code-block-wrapper">
            <div class="code-lang">TERMINAL</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">php artisan make:controller Api/CartController</div>
        </div>

        <p class="mb-4 mt-4">Ce contrôleur gère la session <code>cart</code> (panier). Copiez le code ci-dessous :</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">PHP (Api/CartController.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Récupérer le panier (GET /api/cart)
     */
    public function index(): JsonResponse
    {
        $cart = session(\'cart\', []);
        $total = collect($cart)->sum(\'price\');

        return response()->json([
            \'items\' => array_values($cart),
            \'count\' => count($cart),
            \'total\' => $total,
            \'formatted_total\' => number_format($total, 2, \',\', \' \') . \' €\',
        ]);
    }

    /**
     * Ajouter un produit (POST /api/cart)
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            \'product_id\' => \'required|exists:products,id\',
            \'variant_id\' => \'nullable|exists:product_variants,id\',
        ]);

        $product = Product::with(\'store\')->findOrFail($request->product_id);
        
        $cart = session(\'cart\', []);
        $key = \'product_\' . $product->id . ($request->variant_id ? \'_\' . $request->variant_id : \'\');

        if (isset($cart[$key])) {
            return response()->json([
                \'success\' => false,
                \'message\' => \'Ce produit est déjà dans votre panier\',
            ], 409);
        }

        $cart[$key] = [
            \'id\' => $product->id,
            \'variant_id\' => $request->variant_id,
            \'name\' => $product->getTranslation(\'name\', app()->getLocale()),
            \'slug\' => $product->slug,
            \'price\' => (float) $product->price,
            \'type\' => $product->type,
            \'store_id\' => $product->store_id,
            \'store_name\' => $product->store?->getTranslation(\'name\', app()->getLocale()),
            \'thumbnail\' => $product->thumbnail_url,
        ];

        session([\'cart\' => $cart]);

        return response()->json([
            \'success\' => true,
            \'message\' => \'Produit ajouté au panier\',
            \'cart_count\' => count($cart),
        ]);
    }

    /**
     * Supprimer un produit (DELETE /api/cart/{id})
     */
    public function destroy(Request $request, int $productId): JsonResponse
    {
        $cart = session(\'cart\', []);
        $key = \'product_\' . $productId; // Simplifié pour le cours

        if (!isset($cart[$key])) {
            return response()->json([\'success\' => false, \'message\' => \'Produit non trouvé\'], 404);
        }

        unset($cart[$key]);
        session([\'cart\' => $cart]);

        $total = collect($cart)->sum(\'price\');

        return response()->json([
            \'success\' => true,
            \'message\' => \'Produit retiré du panier\',
            \'cart_count\' => count($cart),
            \'total\' => $total,
        ]);
    }

    /**
     * Vider le panier
     */
    public function clear(): JsonResponse
    {
        session()->forget(\'cart\');
        return response()->json([\'success\' => true, \'message\' => \'Panier vidé\', \'cart_count\' => 0]);
    }
}
') ?></div>
        </div>
    </div>
</section>

<!-- 6.3 Routes API -->
<section id="seance6-routes" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-6 mr-3">Séance 6</span>
        <h2 class="text-2xl font-bold text-gray-800">6.3 Routes API (routes/web.php)</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Ajoutez ces routes dans <code>routes/web.php</code>. Elles doivent être dans le fichier web pour avoir accès à la session.</p>

        <div class="code-block-wrapper">
            <div class="code-lang">PHP (routes/web.php)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('// Routes AJAX pour le Panier
Route::prefix(\'api\')->group(function () {
    Route::get(\'/cart\', [App\Http\Controllers\Api\CartController::class, \'index\'])->name(\'api.cart.index\');
    Route::post(\'/cart\', [App\Http\Controllers\Api\CartController::class, \'store\'])->name(\'api.cart.store\');
    Route::delete(\'/cart/{productId}\', [App\Http\Controllers\Api\CartController::class, \'destroy\'])->name(\'api.cart.destroy\');
    Route::delete(\'/cart\', [App\Http\Controllers\Api\CartController::class, \'clear\'])->name(\'api.cart.clear\');
});

// Vue du Panier
Route::get(\'/cart\', fn() => view(\'cart.index\'))->name(\'cart\');
') ?></div>
        </div>
    </div>
</section>

<!-- 6.4 JavaScript (Cart Logic) -->
<section id="seance6-javascript" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-6 mr-3">Séance 6</span>
        <h2 class="text-2xl font-bold text-gray-800">6.4 JavaScript (resources/js/cart.js)</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Créez le fichier <code>resources/js/cart.js</code>. C'est le cœur de notre système AJAX.</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">JAVASCRIPT (resources/js/cart.js)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('/**
 * Gestion du Panier (BoutiqueCart)
 */
const BoutiqueCart = {
    csrfToken: document.querySelector(\'meta[name="csrf-token"]\').getAttribute(\'content\'),

    // Récupérer le panier
    async getItems() {
        try {
            const response = await fetch(\'/api/cart\');
            const data = await response.json();
            this.updateBadge(data.count);
            return data.items;
        } catch (error) {
            console.error(\'Erreur panier:\', error);
            return [];
        }
    },

    // Ajouter au panier
    async addItem(productId) {
        try {
            const response = await fetch(\'/api/cart\', {
                method: \'POST\',
                headers: {
                    \'Content-Type\': \'application/json\',
                    \'X-CSRF-TOKEN\': this.csrfToken
                },
                body: JSON.stringify({ product_id: productId })
            });
            const data = await response.json();
            
            if (response.ok) {
                this.updateBadge(data.cart_count);
                // Utiliser Toast si disponible, sinon alert
                if (typeof Swal !== \'undefined\') {
                    Swal.fire({ icon: \'success\', title: \'Ajouté !\', text: data.message, toast: true, position: \'top-end\', showConfirmButton: false, timer: 3000 });
                } else {
                    alert(data.message);
                }
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error(\'Erreur ajout panier:\', error);
        }
    },

    // Supprimer du panier
    async removeItem(productId) {
        try {
            const response = await fetch(`/api/cart/${productId}`, {
                method: \'DELETE\',
                headers: {
                    \'X-CSRF-TOKEN\': this.csrfToken
                }
            });
            const data = await response.json();
            if (response.ok) {
                this.updateBadge(data.cart_count);
                return true; // Succès
            }
            return false;
        } catch (error) {
            console.error(\'Erreur suppression:\', error);
            return false;
        }
    },

    // Mettre à jour le badge du menu
    updateBadge(count) {
        const badge = document.querySelector(\'.cart-badge\');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? \'inline-block\' : \'none\';
        }
    }
};

// Rendre accessible globalement
window.BoutiqueCart = BoutiqueCart;
') ?></div>
        </div>

        <p class="mb-4 mt-4 font-bold text-red-600">IMPORTANT : Importez ce fichier dans <code>resources/js/app.js</code></p>
        <div class="code-block-wrapper">
            <div class="code-lang">JAVASCRIPT (resources/js/app.js)</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block">import './bootstrap';
import './cart'; // <-- AJOUTER CETTE LIGNE
import Alpine from 'alpinejs';
// ...</div>
        </div>
    </div>
</section>

<!-- 6.5 Vue Panier -->
<section id="seance6-view" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-6 mr-3">Séance 6</span>
        <h2 class="text-2xl font-bold text-gray-800">6.5 Vue Panier et Navigation</h2>
    </div>

    <div class="section-card">
        <p class="mb-2">Créez <code>resources/views/cart/index.blade.php</code> (voir code du projet fourni pour le HTML complet).</p>
        
        <h4 class="font-bold mt-4 mb-2">Ajouter le lien "Panier" dans la Navigation</h4>
        <p class="mb-2">Dans <code>resources/views/layouts/navigation.blade.php</code> ou votre header, ajoutez l'icône :</p>

        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<a href="{{ route(\'cart\') }}" class="nav-link position-relative">
    <i class="bi bi-cart3 fs-5"></i>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge" style="display: none;">
        0
    </span>
</a>') ?></div>
        </div>

        <h4 class="font-bold mt-4 mb-2">Initialiser au chargement</h4>
        <p class="mb-2">Pour que le badge s'affiche dès l'arrivée sur le site, ajoutez ceci dans votre layout principal (<code>app.blade.php</code>), juste avant la fermeture du body :</p>
        
        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<script>
    document.addEventListener(\'DOMContentLoaded\', function() {
        if (typeof BoutiqueCart !== \'undefined\') {
            BoutiqueCart.getItems(); // Charge le compteur
        }
    });
</script>') ?></div>
        </div>
    </div>
</section>

<!-- 6.6 Bouton Ajouter au Panier -->
<section id="seance6-buttons" class="mb-16 scroll-mt-20">
    <div class="flex items-center mb-6">
        <span class="badge-seance badge-seance-6 mr-3">Séance 6</span>
        <h2 class="text-2xl font-bold text-gray-800">6.6 Bouton "Ajouter au Panier"</h2>
    </div>

    <div class="section-card">
        <p class="mb-4">Sur la fiche produit (<code>resources/views/products/show.blade.php</code>) ou dans les listes, utilisez ce bouton :</p>

        <div class="code-block-wrapper">
            <div class="code-lang">HTML</div>
            <button class="copy-btn">Copier</button>
            <div class="code-block"><?= htmlspecialchars('<button onclick="BoutiqueCart.addItem({{ $product->id }})" class="btn btn-primary">
    <i class="bi bi-cart-plus me-2"></i> Ajouter au panier
</button>') ?></div>
        </div>
    </div>
</section>
