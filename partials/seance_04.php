<!-- =================================================================== -->
<!-- SÉANCE 4 : PANIER & COMMANDES -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-yellow-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-4 mr-3">Séance 4</span>
    Panier & Commandes
</h2>

<!-- ========== 4.1 PANIER JS ========== -->
<section id="seance4-cart-js" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">4.1 Panier JavaScript (localStorage)</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Pourquoi un panier côté client ?</h4>
            <p class="text-gray-700 mb-4">
                Dans une boutique e-commerce, le panier doit fonctionner <strong>même sans être connecté</strong>. 
                Le <code>localStorage</code> du navigateur permet de stocker des données qui persistent entre les sessions.
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 localStorage vs sessionStorage vs Cookies :</strong>
                <table class="styled-table text-sm mt-2">
                    <tr><td><strong>localStorage</strong></td><td>Persiste jusqu'à suppression manuelle (parfait pour le panier)</td></tr>
                    <tr><td><strong>sessionStorage</strong></td><td>Supprimé à la fermeture de l'onglet</td></tr>
                    <tr><td><strong>Cookies</strong></td><td>Envoyé au serveur à chaque requête, limité en taille (4KB)</td></tr>
                </table>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer le fichier panier JavaScript</h4>
            <p class="text-gray-700 mb-4">
                Nous créons un objet <code>BoutiqueCart</code> avec toutes les méthodes nécessaires pour gérer le panier.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">javascript</span>
                <pre class="code-block"><code><span class="token-comment">// public/js/cart.js</span>

<span class="token-js-keyword">const</span> BoutiqueCart = {
    <span class="token-comment">// Récupérer le panier</span>
    <span class="token-js-function">getCart</span>() {
        <span class="token-js-keyword">const</span> cart = localStorage.getItem(<span class="token-js-string">'boutique_cart'</span>);
        <span class="token-js-keyword">return</span> cart ? JSON.parse(cart) : [];
    },

    <span class="token-comment">// Sauvegarder le panier</span>
    <span class="token-js-function">saveCart</span>(cart) {
        localStorage.setItem(<span class="token-js-string">'boutique_cart'</span>, JSON.stringify(cart));
        <span class="token-js-this">this</span>.updateBadge();
    },

    <span class="token-comment">// Ajouter un produit</span>
    <span class="token-js-function">add</span>(product) {
        <span class="token-js-keyword">const</span> cart = <span class="token-js-this">this</span>.getCart();
        <span class="token-js-keyword">const</span> existing = cart.find(item => item.id === product.id);
        
        <span class="token-js-keyword">if</span> (!existing) {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                image: product.image || <span class="token-js-string">''</span>,
                quantity: <span class="token-js-number">1</span>
            });
        }
        
        <span class="token-js-this">this</span>.saveCart(cart);
        <span class="token-js-keyword">return</span> <span class="token-js-keyword">true</span>;
    },

    <span class="token-comment">// Supprimer un produit</span>
    <span class="token-js-function">remove</span>(productId) {
        <span class="token-js-keyword">let</span> cart = <span class="token-js-this">this</span>.getCart();
        cart = cart.filter(item => item.id !== productId);
        <span class="token-js-this">this</span>.saveCart(cart);
    },

    <span class="token-comment">// Calculer le total</span>
    <span class="token-js-function">getTotal</span>() {
        <span class="token-js-keyword">return</span> <span class="token-js-this">this</span>.getCart().reduce((sum, item) => sum + item.price, <span class="token-js-number">0</span>);
    },

    <span class="token-comment">// Vider le panier</span>
    <span class="token-js-function">clear</span>() {
        localStorage.removeItem(<span class="token-js-string">'boutique_cart'</span>);
        <span class="token-js-this">this</span>.updateBadge();
    },

    <span class="token-comment">// Mettre à jour le badge</span>
    <span class="token-js-function">updateBadge</span>() {
        <span class="token-js-keyword">const</span> badge = document.querySelector(<span class="token-js-string">'.cart-count'</span>);
        <span class="token-js-keyword">if</span> (badge) {
            badge.textContent = <span class="token-js-this">this</span>.getCart().length;
        }
    }
};

<span class="token-comment">// Initialiser au chargement</span>
document.addEventListener(<span class="token-js-string">'DOMContentLoaded'</span>, () => BoutiqueCart.updateBadge());</code></pre>
            <button class="copy-btn">Copier</button>
            </div>
            
            <!-- Explication des méthodes -->
            <div class="alert-info mt-4">
                <strong>📖 Résumé des méthodes du panier :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>getCart()</code> : Lit le panier depuis localStorage et le parse en JSON</li>
                    <li><code>add(product)</code> : Ajoute un produit (évite les doublons avec <code>find()</code>)</li>
                    <li><code>remove(productId)</code> : Supprime un produit avec <code>filter()</code></li>
                    <li><code>getTotal()</code> : Calcule le total avec <code>reduce()</code></li>
                    <li><code>updateBadge()</code> : Met à jour le compteur dans la navbar</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Bouton Ajouter au panier</h4>
            <p class="text-gray-700 mb-4">
                On appelle <code>BoutiqueCart.add()</code> avec les données du produit directement depuis Blade.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- Dans la vue produit --&gt;</span>
&lt;button class="btn btn-primary" 
        onclick="BoutiqueCart.add({
            id: <span class="token-blade">{{ $product->id }}</span>,
            name: '<span class="token-blade">{{ $product->name }}</span>',
            price: <span class="token-blade">{{ $product->price }}</span>,
            image: '<span class="token-blade">{{ $product->thumbnail_url }}</span>'
        })"&gt;
    &lt;i class="bi bi-cart-plus"&gt;&lt;/i&gt; Ajouter au panier
&lt;/button&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 4.2 ORDER MODELS ========== -->
<section id="seance4-order-models" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">4.2 Modèles Order & OrderItem</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Pourquoi deux tables ?</h4>
            <p class="text-gray-700 mb-4">
                Une commande peut contenir <strong>plusieurs produits</strong>. On utilise donc deux tables :
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Structure des commandes :</strong>
                <pre class="text-sm mt-2">Order (commande) → OrderItems (lignes de commande)</pre>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><strong>Order</strong> : Infos globales (client, statut, total, paiement)</li>
                    <li><strong>OrderItem</strong> : Chaque produit acheté (prix, quantité, commission vendeur)</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer les modèles</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:model Order -mfs
php artisan make:model OrderItem -m</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/migrations/xxxx_create_orders_table.php</span>

Schema::<span class="token-function">create</span>(<span class="token-string">'orders'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
    <span class="token-variable">$table</span>-><span class="token-function">id</span>();
    <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'user_id'</span>)-><span class="token-function">constrained</span>();
    <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'order_number'</span>)-><span class="token-function">unique</span>();
    <span class="token-variable">$table</span>-><span class="token-function">enum</span>(<span class="token-string">'status'</span>, [<span class="token-string">'pending'</span>, <span class="token-string">'processing'</span>, <span class="token-string">'completed'</span>, <span class="token-string">'cancelled'</span>])-><span class="token-function">default</span>(<span class="token-string">'pending'</span>);
    <span class="token-variable">$table</span>-><span class="token-function">enum</span>(<span class="token-string">'payment_status'</span>, [<span class="token-string">'pending'</span>, <span class="token-string">'paid'</span>, <span class="token-string">'failed'</span>, <span class="token-string">'refunded'</span>])-><span class="token-function">default</span>(<span class="token-string">'pending'</span>);
    <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'payment_gateway'</span>)-><span class="token-function">nullable</span>();
    <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'transaction_id'</span>)-><span class="token-function">nullable</span>();
    <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'subtotal'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>);
    <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'total'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>);
    <span class="token-variable">$table</span>-><span class="token-function">timestamp</span>(<span class="token-string">'paid_at'</span>)-><span class="token-function">nullable</span>();
    <span class="token-variable">$table</span>-><span class="token-function">timestamps</span>();
});</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/migrations/xxxx_create_order_items_table.php</span>

Schema::<span class="token-function">create</span>(<span class="token-string">'order_items'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
    <span class="token-variable">$table</span>-><span class="token-function">id</span>();
    <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'order_id'</span>)-><span class="token-function">constrained</span>()-><span class="token-function">cascadeOnDelete</span>();
    <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'product_id'</span>)-><span class="token-function">constrained</span>();
    <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'store_id'</span>)-><span class="token-function">nullable</span>()-><span class="token-function">constrained</span>();
    <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'product_name'</span>);
    <span class="token-variable">$table</span>-><span class="token-function">integer</span>(<span class="token-string">'quantity'</span>)-><span class="token-function">default</span>(<span class="token-number">1</span>);
    <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'unit_price'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>);
    <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'total'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>);
    <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'commission_amount'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
    <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'vendor_amount'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
    <span class="token-variable">$table</span>-><span class="token-function">timestamps</span>();
});</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 4.3 CHECKOUT ========== -->
<section id="seance4-checkout" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">4.3 Page Checkout & Synchronisation Panier</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">API de synchronisation panier</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/Api/CartController.php</span>

<span class="token-keyword">public function</span> <span class="token-function">sync</span>(Request <span class="token-variable">$request</span>)
{
    <span class="token-variable">$request</span>-><span class="token-function">validate</span>([
        <span class="token-string">'items'</span> => <span class="token-string">'required|array'</span>,
        <span class="token-string">'items.*.id'</span> => <span class="token-string">'required|integer'</span>,
    ]);

    <span class="token-variable">$cart</span> = [];
    <span class="token-keyword">foreach</span> (<span class="token-variable">$request</span>->items <span class="token-keyword">as</span> <span class="token-variable">$item</span>) {
        <span class="token-variable">$product</span> = Product::<span class="token-function">find</span>(<span class="token-variable">$item</span>[<span class="token-string">'id'</span>]);
        <span class="token-keyword">if</span> (<span class="token-variable">$product</span>) {
            <span class="token-variable">$cart</span>[<span class="token-string">'product_'</span> . <span class="token-variable">$product</span>->id] = [
                <span class="token-string">'id'</span> => <span class="token-variable">$product</span>->id,
                <span class="token-string">'name'</span> => <span class="token-variable">$product</span>->name,
                <span class="token-string">'price'</span> => <span class="token-variable">$product</span>->price,
                <span class="token-string">'store_id'</span> => <span class="token-variable">$product</span>->store_id,
            ];
        }
    }

    <span class="token-function">session</span>([<span class="token-string">'cart'</span> => <span class="token-variable">$cart</span>]);

    <span class="token-keyword">return</span> <span class="token-function">response</span>()-><span class="token-function">json</span>([<span class="token-string">'success'</span> => <span class="token-keyword">true</span>]);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 4.4 HISTORIQUE ========== -->
<section id="seance4-order-history" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">4.4 Historique des Commandes Client</h3>
    
    <div class="section-card">
        <div class="code-block-wrapper">
            <span class="code-lang">php</span>
            <pre class="code-block"><code><span class="token-comment">// routes/web.php</span>

Route::<span class="token-function">middleware</span>(<span class="token-string">'auth'</span>)-><span class="token-function">group</span>(<span class="token-keyword">function</span> () {
    Route::<span class="token-function">get</span>(<span class="token-string">'/orders'</span>, <span class="token-keyword">function</span> () {
        <span class="token-variable">$orders</span> = <span class="token-function">auth</span>()-><span class="token-function">user</span>()-><span class="token-function">orders</span>()
            -><span class="token-function">with</span>(<span class="token-string">'items'</span>)
            -><span class="token-function">latest</span>()
            -><span class="token-function">paginate</span>(<span class="token-number">10</span>);
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'customer.orders.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'orders'</span>));
    })-><span class="token-function">name</span>(<span class="token-string">'orders.index'</span>);
});</code></pre>
            <button class="copy-btn">Copier</button>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 4 !</strong> Vous avez maintenant un panier JavaScript fonctionnel
        et les modèles Order/OrderItem prêts pour les paiements.
    </div>
</section>
