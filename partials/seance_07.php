<!-- =================================================================== -->
<!-- SÉANCE 7 : AVIS, WISHLIST & RECHERCHE -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-pink-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-2 mr-3">Séance 7</span>
    Avis, Wishlist & Recherche
</h2>

<!-- ========== 7.1 AVIS ========== -->
<section id="seance7-reviews" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">7.1 Système d'Avis Clients</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Pourquoi les avis sont importants ?</h4>
            <p class="text-gray-700 mb-4">
                Les avis clients augmentent la <strong>confiance</strong> et le <strong>taux de conversion</strong>. 
                Un système d'avis bien conçu permet aux acheteurs de partager leur expérience.
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Fonctionnalités d'un système d'avis :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li>Note de 1 à 5 étoiles</li>
                    <li>Commentaire optionnel</li>
                    <li>Avis "vérifié" (achat confirmé)</li>
                    <li>Un seul avis par utilisateur par produit</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer le modèle Review</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:model Review -m</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/migrations/xxxx_create_reviews_table.php</span>

Schema::<span class="token-function">create</span>(<span class="token-string">'reviews'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
    <span class="token-variable">$table</span>-><span class="token-function">id</span>();
    <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'user_id'</span>)-><span class="token-function">constrained</span>()-><span class="token-function">cascadeOnDelete</span>();
    <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'product_id'</span>)-><span class="token-function">constrained</span>()-><span class="token-function">cascadeOnDelete</span>();
    <span class="token-variable">$table</span>-><span class="token-function">tinyInteger</span>(<span class="token-string">'rating'</span>); <span class="token-comment">// 1-5</span>
    <span class="token-variable">$table</span>-><span class="token-function">text</span>(<span class="token-string">'comment'</span>)-><span class="token-function">nullable</span>();
    <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_verified'</span>)-><span class="token-function">default</span>(<span class="token-keyword">false</span>);
    <span class="token-variable">$table</span>-><span class="token-function">timestamps</span>();
    
    <span class="token-comment">// Un seul avis par utilisateur par produit</span>
    <span class="token-variable">$table</span>-><span class="token-function">unique</span>([<span class="token-string">'user_id'</span>, <span class="token-string">'product_id'</span>]);
});</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Explication des champs :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>rating</code> : Note de 1 à 5 (tinyInteger = 1 octet, suffisant)</li>
                    <li><code>is_verified</code> : Vrai si l'utilisateur a acheté le produit</li>
                    <li><code>unique(['user_id', 'product_id'])</code> : Empêche les doublons</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Modèle Review avec relations</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/Review.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Models</span>;

<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Model</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\BelongsTo</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Review</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span>
{
    <span class="token-keyword">protected</span> <span class="token-variable">$fillable</span> = [
        <span class="token-string">'user_id'</span>, <span class="token-string">'product_id'</span>, <span class="token-string">'rating'</span>, <span class="token-string">'comment'</span>, <span class="token-string">'is_verified'</span>
    ];

    <span class="token-keyword">public function</span> <span class="token-function">user</span>(): <span class="token-class-name">BelongsTo</span>
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">belongsTo</span>(User::<span class="token-keyword">class</span>);
    }

    <span class="token-keyword">public function</span> <span class="token-function">product</span>(): <span class="token-class-name">BelongsTo</span>
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">belongsTo</span>(Product::<span class="token-keyword">class</span>);
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Relation dans le modèle Product</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/Product.php - Ajouter</span>

<span class="token-keyword">public function</span> <span class="token-function">reviews</span>(): <span class="token-class-name">HasMany</span>
{
    <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">hasMany</span>(Review::<span class="token-keyword">class</span>);
}

<span class="token-comment">// Accessor pour la note moyenne</span>
<span class="token-keyword">public function</span> <span class="token-function">getAverageRatingAttribute</span>(): <span class="token-keyword">float</span>
{
    <span class="token-keyword">return</span> <span class="token-function">round</span>(<span class="token-variable">$this</span>-><span class="token-function">reviews</span>()-><span class="token-function">avg</span>(<span class="token-string">'rating'</span>) ?? <span class="token-number">0</span>, <span class="token-number">1</span>);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 7.2 WISHLIST ========== -->
<section id="seance7-wishlist" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">7.2 Liste de Souhaits (Wishlist)</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Approche JavaScript (localStorage)</h4>
            <p class="text-gray-700 mb-4">
                Comme le panier, la wishlist peut être stockée côté client dans <code>localStorage</code>. 
                C'est simple et fonctionne sans authentification.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">javascript</span>
                <pre class="code-block"><code><span class="token-comment">// public/js/wishlist.js</span>

<span class="token-js-keyword">const</span> Wishlist = {
    <span class="token-js-function">getItems</span>() {
        <span class="token-js-keyword">return</span> JSON.parse(localStorage.getItem(<span class="token-js-string">'wishlist'</span>) || <span class="token-js-string">'[]'</span>);
    },

    <span class="token-js-function">toggle</span>(productId) {
        <span class="token-js-keyword">let</span> items = <span class="token-js-this">this</span>.getItems();
        <span class="token-js-keyword">if</span> (items.includes(productId)) {
            items = items.filter(id => id !== productId);
        } <span class="token-js-keyword">else</span> {
            items.push(productId);
        }
        localStorage.setItem(<span class="token-js-string">'wishlist'</span>, JSON.stringify(items));
        <span class="token-js-this">this</span>.updateUI();
    },

    <span class="token-js-function">isInWishlist</span>(productId) {
        <span class="token-js-keyword">return</span> <span class="token-js-this">this</span>.getItems().includes(productId);
    },

    <span class="token-js-function">updateUI</span>() {
        <span class="token-js-keyword">const</span> badge = document.querySelector(<span class="token-js-string">'.wishlist-count'</span>);
        <span class="token-js-keyword">if</span> (badge) badge.textContent = <span class="token-js-this">this</span>.getItems().length;
    }
};

document.addEventListener(<span class="token-js-string">'DOMContentLoaded'</span>, () => Wishlist.updateUI());</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Méthodes de la Wishlist :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>toggle()</code> : Ajoute ou retire un produit (comportement bascule)</li>
                    <li><code>isInWishlist()</code> : Vérifie si un produit est dans la liste</li>
                    <li><code>updateUI()</code> : Met à jour le compteur dans la navbar</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Bouton Wishlist avec icône dynamique</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- Dans la carte produit --&gt;</span>

&lt;button onclick="Wishlist.toggle(<span class="token-blade">{{ $product->id }}</span>)" 
        class="btn btn-outline-danger btn-sm"
        id="wishlist-btn-<span class="token-blade">{{ $product->id }}</span>"&gt;
    &lt;i class="bi bi-heart"&gt;&lt;/i&gt;
&lt;/button&gt;

&lt;script&gt;
<span class="token-comment">// Mettre à jour l'icône au chargement</span>
document.addEventListener('DOMContentLoaded', () => {
    if (Wishlist.isInWishlist(<span class="token-blade">{{ $product->id }}</span>)) {
        document.querySelector('#wishlist-btn-<span class="token-blade">{{ $product->id }}</span> i')
            .classList.replace('bi-heart', 'bi-heart-fill');
    }
});
&lt;/script&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 7.3 RECHERCHE ========== -->
<section id="seance7-search" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">7.3 Recherche Avancée & Filtres</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Concept : Query Builder dynamique</h4>
            <p class="text-gray-700 mb-4">
                On construit la requête <strong>progressivement</strong> en ajoutant des conditions 
                selon les filtres envoyés par l'utilisateur.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/ProductController.php</span>

<span class="token-keyword">public function</span> <span class="token-function">index</span>(Request <span class="token-variable">$request</span>)
{
    <span class="token-comment">// Démarrer la requête</span>
    <span class="token-variable">$query</span> = Product::<span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>);

    <span class="token-comment">// Recherche par mot-clé</span>
    <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'q'</span>)) {
        <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-keyword">function</span>(<span class="token-variable">$q</span>) <span class="token-keyword">use</span> (<span class="token-variable">$request</span>) {
            <span class="token-variable">$q</span>-><span class="token-function">where</span>(<span class="token-string">'name'</span>, <span class="token-string">'like'</span>, <span class="token-string">'%'</span> . <span class="token-variable">$request</span>->q . <span class="token-string">'%'</span>)
              -><span class="token-function">orWhere</span>(<span class="token-string">'description'</span>, <span class="token-string">'like'</span>, <span class="token-string">'%'</span> . <span class="token-variable">$request</span>->q . <span class="token-string">'%'</span>);
        });
    }

    <span class="token-comment">// Filtre par catégorie</span>
    <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'category'</span>)) {
        <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'category_id'</span>, <span class="token-variable">$request</span>->category);
    }

    <span class="token-comment">// Filtre par prix min/max</span>
    <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'min_price'</span>)) {
        <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'price'</span>, <span class="token-string">'>='</span>, <span class="token-variable">$request</span>->min_price);
    }
    <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'max_price'</span>)) {
        <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'price'</span>, <span class="token-string">'<='</span>, <span class="token-variable">$request</span>->max_price);
    }

    <span class="token-variable">$products</span> = <span class="token-variable">$query</span>-><span class="token-function">paginate</span>(<span class="token-number">12</span>);

    <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'products.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'products'</span>));
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Bonnes pratiques :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>filled()</code> : Vérifie que le paramètre existe ET n'est pas vide</li>
                    <li>Closure dans where() : Permet de grouper les conditions OR</li>
                    <li><code>LIKE '%...%'</code> : Recherche partielle (lente sur grandes tables)</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Formulaire de recherche avec filtres</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- Sidebar filtres --&gt;</span>

&lt;form method="GET" action="<span class="token-blade">{{ route('products.index') }}</span>"&gt;
    <span class="token-comment">&lt;!-- Recherche --&gt;</span>
    &lt;div class="mb-3"&gt;
        &lt;input type="text" name="q" class="form-control" 
               placeholder="Rechercher..." value="<span class="token-blade">{{ request('q') }}</span>"&gt;
    &lt;/div&gt;
    
    <span class="token-comment">&lt;!-- Catégorie --&gt;</span>
    &lt;div class="mb-3"&gt;
        &lt;select name="category" class="form-select"&gt;
            &lt;option value=""&gt;Toutes les catégories&lt;/option&gt;
            <span class="token-blade">@foreach($categories as $cat)</span>
            &lt;option value="<span class="token-blade">{{ $cat->id }}</span>" 
                <span class="token-blade">{{ request('category') == $cat->id ? 'selected' : '' }}</span>&gt;
                <span class="token-blade">{{ $cat->name }}</span>
            &lt;/option&gt;
            <span class="token-blade">@endforeach</span>
        &lt;/select&gt;
    &lt;/div&gt;
    
    <span class="token-comment">&lt;!-- Prix --&gt;</span>
    &lt;div class="row mb-3"&gt;
        &lt;div class="col"&gt;
            &lt;input type="number" name="min_price" class="form-control" 
                   placeholder="Min €" value="<span class="token-blade">{{ request('min_price') }}</span>"&gt;
        &lt;/div&gt;
        &lt;div class="col"&gt;
            &lt;input type="number" name="max_price" class="form-control" 
                   placeholder="Max €" value="<span class="token-blade">{{ request('max_price') }}</span>"&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    
    &lt;button type="submit" class="btn btn-primary w-100"&gt;Filtrer&lt;/button&gt;
&lt;/form&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 7.4 TRI ========== -->
<section id="seance7-sorting" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">7.4 Tri & Pagination</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Tri dynamique sécurisé</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Dans ProductController::index()</span>

<span class="token-comment">// Options de tri autorisées (sécurité)</span>
<span class="token-variable">$allowedSorts</span> = [<span class="token-string">'created_at'</span>, <span class="token-string">'price'</span>, <span class="token-string">'name'</span>];
<span class="token-variable">$sortBy</span> = <span class="token-function">in_array</span>(<span class="token-variable">$request</span>->sort, <span class="token-variable">$allowedSorts</span>) 
    ? <span class="token-variable">$request</span>->sort 
    : <span class="token-string">'created_at'</span>;

<span class="token-variable">$sortDir</span> = <span class="token-variable">$request</span>->dir === <span class="token-string">'asc'</span> ? <span class="token-string">'asc'</span> : <span class="token-string">'desc'</span>;

<span class="token-variable">$products</span> = <span class="token-variable">$query</span>
    -><span class="token-function">orderBy</span>(<span class="token-variable">$sortBy</span>, <span class="token-variable">$sortDir</span>)
    -><span class="token-function">paginate</span>(<span class="token-number">12</span>)
    -><span class="token-function">withQueryString</span>(); <span class="token-comment">// Garde les filtres dans la pagination</span></code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-warning mt-4">
                <strong>⚠️ Sécurité :</strong> Ne jamais utiliser directement <code>$request->sort</code> 
                dans orderBy() ! Un attaquant pourrait injecter du SQL. Toujours valider contre une liste blanche.
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Dropdown de tri</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code>&lt;select onchange="window.location.href = this.value" class="form-select"&gt;
    &lt;option value="<span class="token-blade">{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'dir' => 'desc']) }}</span>"
        <span class="token-blade">{{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}</span>&gt;
        Plus récents
    &lt;/option&gt;
    &lt;option value="<span class="token-blade">{{ request()->fullUrlWithQuery(['sort' => 'price', 'dir' => 'asc']) }}</span>"
        <span class="token-blade">{{ request('sort') == 'price' && request('dir') == 'asc' ? 'selected' : '' }}</span>&gt;
        Prix croissant
    &lt;/option&gt;
    &lt;option value="<span class="token-blade">{{ request()->fullUrlWithQuery(['sort' => 'price', 'dir' => 'desc']) }}</span>"
        <span class="token-blade">{{ request('sort') == 'price' && request('dir') == 'desc' ? 'selected' : '' }}</span>&gt;
        Prix décroissant
    &lt;/option&gt;
&lt;/select&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 7 !</strong> Votre marketplace dispose maintenant d'avis clients, 
        d'une wishlist et d'une recherche avancée avec filtres.
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>
