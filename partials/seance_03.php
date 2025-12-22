<!-- =================================================================== -->
<!-- SÉANCE 3 : MULTI-VENDEURS & BOUTIQUES -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-green-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-3 mr-3">Séance 3</span>
    Multi-Vendeurs & Boutiques
</h2>

<!-- ========== 3.1 MODÈLE STORE ========== -->
<section id="seance3-store-model" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">3.1 Modèle Store & Migration</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Concept : Architecture Multi-Vendeurs</h4>
            <p class="text-gray-700 mb-4">
                Dans une <strong>marketplace multi-vendeurs</strong>, chaque vendeur possède sa propre boutique (Store). 
                Les produits appartiennent à une boutique, et lors d'une vente, la plateforme prélève une commission.
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Structure des relations :</strong>
                <pre class="text-sm mt-2">User (vendeur) → Store (boutique) → Products (produits)</pre>
                <p class="text-sm mt-2">Un utilisateur "vendor" peut créer une boutique, puis y ajouter des produits.</p>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer le modèle Store</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:model Store -mfs</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/migrations/xxxx_create_stores_table.php</span>

<span class="token-keyword">public function</span> <span class="token-function">up</span>(): <span class="token-keyword">void</span>
{
    Schema::<span class="token-function">create</span>(<span class="token-string">'stores'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
        <span class="token-variable">$table</span>-><span class="token-function">id</span>();
        <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'user_id'</span>)-><span class="token-function">constrained</span>()-><span class="token-function">cascadeOnDelete</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'name'</span>);
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'slug'</span>)-><span class="token-function">unique</span>();
        <span class="token-variable">$table</span>-><span class="token-function">text</span>(<span class="token-string">'description'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'logo'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'commission_rate'</span>, <span class="token-number">5</span>, <span class="token-number">2</span>)-><span class="token-function">default</span>(<span class="token-number">10.00</span>); <span class="token-comment">// 10% par défaut</span>
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'balance'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_active'</span>)-><span class="token-function">default</span>(<span class="token-keyword">true</span>);
        <span class="token-variable">$table</span>-><span class="token-function">timestamps</span>();
    });
}

<span class="token-comment">// Ajouter store_id à products</span>
Schema::<span class="token-function">table</span>(<span class="token-string">'products'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
    <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'store_id'</span>)-><span class="token-function">nullable</span>()-><span class="token-function">constrained</span>()-><span class="token-function">after</span>(<span class="token-string">'category_id'</span>);
});</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <!-- Explications des champs -->
            <div class="alert-info mt-4">
                <strong>📖 Explication des champs importants :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>user_id</code> : Clé étrangère vers l'utilisateur propriétaire (le vendeur)</li>
                    <li><code>commission_rate</code> : Pourcentage prélevé par la plateforme (ici 10%)</li>
                    <li><code>balance</code> : Solde accumulé du vendeur (revenus - commissions)</li>
                    <li><code>cascadeOnDelete()</code> : Si l'utilisateur est supprimé, sa boutique l'est aussi</li>
                    <li><code>store_id</code> dans products : Lie chaque produit à une boutique</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Modèle Store complet</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/Store.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Models</span>;

<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Model</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\BelongsTo</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\HasMany</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Store</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span>
{
    <span class="token-keyword">protected</span> <span class="token-variable">$fillable</span> = [
        <span class="token-string">'user_id'</span>, <span class="token-string">'name'</span>, <span class="token-string">'slug'</span>, <span class="token-string">'description'</span>,
        <span class="token-string">'logo'</span>, <span class="token-string">'commission_rate'</span>, <span class="token-string">'balance'</span>, <span class="token-string">'is_active'</span>,
    ];

    <span class="token-keyword">public function</span> <span class="token-function">user</span>(): <span class="token-class-name">BelongsTo</span>
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">belongsTo</span>(User::<span class="token-keyword">class</span>);
    }

    <span class="token-keyword">public function</span> <span class="token-function">products</span>(): <span class="token-class-name">HasMany</span>
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">hasMany</span>(Product::<span class="token-keyword">class</span>);
    }

    <span class="token-comment">// Calculer la commission sur un montant</span>
    <span class="token-keyword">public function</span> <span class="token-function">calculateCommission</span>(<span class="token-keyword">float</span> <span class="token-variable">$amount</span>): <span class="token-keyword">float</span>
    {
        <span class="token-keyword">return</span> <span class="token-function">round</span>(<span class="token-variable">$amount</span> * <span class="token-variable">$this</span>->commission_rate / <span class="token-number">100</span>, <span class="token-number">2</span>);
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <!-- Explications du modèle Store -->
            <div class="alert-info mt-4">
                <strong>📖 Analyse du modèle Store :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>belongsTo(User::class)</code> : La boutique appartient à un utilisateur (le vendeur)</li>
                    <li><code>hasMany(Product::class)</code> : Une boutique peut avoir plusieurs produits</li>
                    <li><code>calculateCommission($amount)</code> : Méthode personnalisée qui calcule la commission : <code>montant × taux / 100</code></li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Relation User -> Store</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/User.php - Ajouter la relation</span>

<span class="token-keyword">public function</span> <span class="token-function">store</span>(): <span class="token-class-name">HasOne</span>
{
    <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">hasOne</span>(Store::<span class="token-keyword">class</span>);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 3.2 CRUD BOUTIQUE ========== -->
<section id="seance3-store-crud" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">3.2 CRUD Boutique Vendeur</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Qu'est-ce que le CRUD ?</h4>
            <p class="text-gray-700 mb-4">
                <strong>CRUD</strong> signifie Create, Read, Update, Delete - les 4 opérations de base sur les données.
                Pour la boutique, le vendeur doit pouvoir créer, voir, modifier et supprimer sa boutique.
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Mapping CRUD → Routes Laravel :</strong>
                <table class="styled-table text-sm mt-2" style="max-width: 500px;">
                    <tr><td><strong>Create</strong></td><td>→ GET /create + POST /store</td></tr>
                    <tr><td><strong>Read</strong></td><td>→ GET /index ou GET /show</td></tr>
                    <tr><td><strong>Update</strong></td><td>→ GET /edit + PUT /update</td></tr>
                    <tr><td><strong>Delete</strong></td><td>→ DELETE /destroy</td></tr>
                </table>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer le StoreController pour les vendeurs</h4>
            <p class="text-gray-700 mb-4">
                Nous créons le contrôleur dans le namespace <code>Vendor/</code> pour organiser le code par rôle.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:controller Vendor/StoreController</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/Vendor/StoreController.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Http\Controllers\Vendor</span>;

<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Controllers\Controller</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Http\Request</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Str</span>;

<span class="token-keyword">class</span> <span class="token-class-name">StoreController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-keyword">public function</span> <span class="token-function">create</span>()
    {
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'vendor.store.create'</span>);
    }

    <span class="token-keyword">public function</span> <span class="token-function">store</span>(Request <span class="token-variable">$request</span>)
    {
        <span class="token-variable">$validated</span> = <span class="token-variable">$request</span>-><span class="token-function">validate</span>([
            <span class="token-string">'name'</span> => <span class="token-string">'required|string|max:255'</span>,
            <span class="token-string">'description'</span> => <span class="token-string">'nullable|string'</span>,
        ]);

        <span class="token-variable">$store</span> = <span class="token-function">auth</span>()-><span class="token-function">user</span>()-><span class="token-function">store</span>()-><span class="token-function">create</span>([
            <span class="token-string">'name'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'name'</span>],
            <span class="token-string">'slug'</span> => Str::<span class="token-function">slug</span>(<span class="token-variable">$validated</span>[<span class="token-string">'name'</span>]),
            <span class="token-string">'description'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'description'</span>] ?? <span class="token-keyword">null</span>,
        ]);

        <span class="token-keyword">return</span> <span class="token-function">redirect</span>()-><span class="token-function">route</span>(<span class="token-string">'vendor.dashboard'</span>)
            -><span class="token-function">with</span>(<span class="token-string">'success'</span>, <span class="token-string">'Boutique créée avec succès !'</span>);
    }

    <span class="token-keyword">public function</span> <span class="token-function">edit</span>()
    {
        <span class="token-variable">$store</span> = <span class="token-function">auth</span>()-><span class="token-function">user</span>()->store;
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'vendor.store.edit'</span>, <span class="token-function">compact</span>(<span class="token-string">'store'</span>));
    }

    <span class="token-keyword">public function</span> <span class="token-function">update</span>(Request <span class="token-variable">$request</span>)
    {
        <span class="token-variable">$store</span> = <span class="token-function">auth</span>()-><span class="token-function">user</span>()->store;
        <span class="token-variable">$store</span>-><span class="token-function">update</span>(<span class="token-variable">$request</span>-><span class="token-function">validated</span>());
        
        <span class="token-keyword">return</span> <span class="token-function">back</span>()-><span class="token-function">with</span>(<span class="token-string">'success'</span>, <span class="token-string">'Boutique mise à jour !'</span>);
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 3.3 PRODUITS VENDEUR ========== -->
<section id="seance3-products-vendor" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">3.3 Gestion des Produits par Vendeur</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">ProductController Vendeur</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/Vendor/ProductController.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Http\Controllers\Vendor</span>;

<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Controllers\Controller</span>;
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>;
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Category</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Http\Request</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Str</span>;

<span class="token-keyword">class</span> <span class="token-class-name">ProductController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-keyword">public function</span> <span class="token-function">index</span>()
    {
        <span class="token-variable">$store</span> = <span class="token-function">auth</span>()-><span class="token-function">user</span>()->store;
        <span class="token-variable">$products</span> = <span class="token-variable">$store</span>-><span class="token-function">products</span>()-><span class="token-function">paginate</span>(<span class="token-number">10</span>);
        
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'vendor.products.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'products'</span>));
    }

    <span class="token-keyword">public function</span> <span class="token-function">create</span>()
    {
        <span class="token-variable">$categories</span> = Category::<span class="token-function">all</span>();
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'vendor.products.create'</span>, <span class="token-function">compact</span>(<span class="token-string">'categories'</span>));
    }

    <span class="token-keyword">public function</span> <span class="token-function">store</span>(Request <span class="token-variable">$request</span>)
    {
        <span class="token-variable">$validated</span> = <span class="token-variable">$request</span>-><span class="token-function">validate</span>([
            <span class="token-string">'name'</span> => <span class="token-string">'required|string|max:255'</span>,
            <span class="token-string">'category_id'</span> => <span class="token-string">'required|exists:categories,id'</span>,
            <span class="token-string">'description'</span> => <span class="token-string">'nullable|string'</span>,
            <span class="token-string">'price'</span> => <span class="token-string">'required|numeric|min:0'</span>,
        ]);

        <span class="token-variable">$store</span> = <span class="token-function">auth</span>()-><span class="token-function">user</span>()->store;
        <span class="token-variable">$store</span>-><span class="token-function">products</span>()-><span class="token-function">create</span>([
            ...<span class="token-variable">$validated</span>,
            <span class="token-string">'slug'</span> => Str::<span class="token-function">slug</span>(<span class="token-variable">$validated</span>[<span class="token-string">'name'</span>]) . <span class="token-string">'-'</span> . <span class="token-function">uniqid</span>(),
        ]);

        <span class="token-keyword">return</span> <span class="token-function">redirect</span>()-><span class="token-function">route</span>(<span class="token-string">'vendor.products.index'</span>)
            -><span class="token-function">with</span>(<span class="token-string">'success'</span>, <span class="token-string">'Produit créé !'</span>);
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 3.4 COMMISSION ========== -->
<section id="seance3-commission" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">3.4 Système de Commission</h3>
    
    <div class="section-card">
        <div class="alert-info">
            <strong>💡 Concept :</strong> Chaque boutique a un taux de commission (par défaut 10%). 
            Lors d'une vente, la plateforme prélève cette commission et le vendeur reçoit le reste.
        </div>
        
        <table class="styled-table mt-4">
            <thead>
                <tr>
                    <th>Prix de vente</th>
                    <th>Commission (10%)</th>
                    <th>Revenu vendeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>29.99 €</td>
                    <td>3.00 €</td>
                    <td>26.99 €</td>
                </tr>
                <tr>
                    <td>49.99 €</td>
                    <td>5.00 €</td>
                    <td>44.99 €</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 3 !</strong> Vous avez maintenant une architecture multi-vendeurs 
        avec des boutiques et la gestion de produits par vendeur.
    </div>
</section>
