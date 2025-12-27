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
        
        <span class="token-comment">// Vendeur propriétaire (un seul par utilisateur)</span>
        <span class="token-variable">$table</span>-><span class="token-function">foreignId</span>(<span class="token-string">'user_id'</span>)
            -><span class="token-function">unique</span>()
            -><span class="token-function">constrained</span>()
            -><span class="token-function">onDelete</span>(<span class="token-string">'cascade'</span>);
        
        <span class="token-comment">// Informations de base</span>
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'name'</span>);
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'slug'</span>)-><span class="token-function">unique</span>();
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'description'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'short_description'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// Médias (via Spatie Media Library, champs plus nécessaires ici mais gardons structure propre au projet si besoin de champs directs)</span>
        <span class="token-comment">// Note: Le projet utilise Spatie Media Library pour 'logo' et 'banner', donc pas de colonnes string ici sauf si legacy.</span>
        <span class="token-comment">// Dans le fichier du projet vu, il y a 'logo' et 'banner' en string. Conservons-les pour compatibilité stricte.</span>
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'logo'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'banner'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-variable">$table</span>-><span class="token-function">unsignedBigInteger</span>(<span class="token-string">'category_id'</span>)-><span class="token-function">nullable</span>();

        <span class="token-comment">// Commission</span>
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'commission_rate'</span>, <span class="token-number">5</span>, <span class="token-number">2</span>)-><span class="token-function">default</span>(<span class="token-number">10.00</span>);
        
        <span class="token-comment">// Statut</span>
        <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_active'</span>)-><span class="token-function">default</span>(<span class="token-keyword">true</span>);
        <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_featured'</span>)-><span class="token-function">default</span>(<span class="token-keyword">false</span>);
        <span class="token-variable">$table</span>-><span class="token-function">timestamp</span>(<span class="token-string">'verified_at'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">timestamp</span>(<span class="token-string">'suspended_at'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'suspension_reason'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// Informations de paiement</span>
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'paypal_email'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'stripe_account_id'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'bank_iban'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'bank_bic'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'bank_name'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// Informations légales</span>
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'company_name'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'tax_number'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'siret'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// Adresse</span>
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'address'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'city'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'postal_code'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'country'</span>, <span class="token-number">2</span>)-><span class="token-function">nullable</span>(); <span class="token-comment">// Code ISO 2</span>
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'phone'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// SEO</span>
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'meta_title'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">json</span>(<span class="token-string">'meta_description'</span>)-><span class="token-function">nullable</span>();
        
        <span class="token-comment">// Statistiques</span>
        <span class="token-variable">$table</span>-><span class="token-function">unsignedInteger</span>(<span class="token-string">'products_count'</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">unsignedInteger</span>(<span class="token-string">'orders_count'</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'total_sales'</span>, <span class="token-number">12</span>, <span class="token-number">2</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'average_rating'</span>, <span class="token-number">3</span>, <span class="token-number">2</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">unsignedInteger</span>(<span class="token-string">'reviews_count'</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        
        <span class="token-variable">$table</span>-><span class="token-function">timestamps</span>();
        <span class="token-variable">$table</span>-><span class="token-function">softDeletes</span>();
        
        <span class="token-variable">$table</span>-><span class="token-function">index</span>(<span class="token-string">'is_active'</span>);
    });
}

<span class="token-comment">// Ajouter store_id à products (contrainte Foreign Key)</span>
Schema::<span class="token-function">table</span>(<span class="token-string">'products'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
    <span class="token-variable">$table</span>-><span class="token-function">foreign</span>(<span class="token-string">'store_id'</span>)-><span class="token-function">references</span>(<span class="token-string">'id'</span>)-><span class="token-function">on</span>(<span class="token-string">'stores'</span>)-><span class="token-function">cascadeOnDelete</span>();
});</code></pre>
    <button class="copy-btn">Copier</button>
</div>

<!-- Explications des champs -->
<div class="alert-info mt-4">
    <strong>📖 Explication des champs importants :</strong>
    <ul class="list-disc ml-6 mt-2 text-sm">
        <li><code>user_id</code> : Le propriétaire (vendeur). Un vendeur = une boutique.</li>
        <li><code>verified_at</code> : Date de validation par un admin (KYC).</li>
        <li><code>commission_rate</code> : Taux prélevé par la plateforme sur les ventes.</li>
        <li><code>bank_*, paypal_email</code> : Informations pour payer le vendeur.</li>
        <li><code>siret, tax_number</code> : Infos légales obligatoires pour facturation.</li>
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
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\SoftDeletes</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\MediaLibrary\HasMedia</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\MediaLibrary\InteractsWithMedia</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\Translatable\HasTranslations</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Str</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Store</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span> <span class="token-keyword">implements</span> <span class="token-class-name">HasMedia</span>
{
    <span class="token-keyword">use</span> SoftDeletes, InteractsWithMedia, HasTranslations;

    <span class="token-keyword">public array</span> <span class="token-variable">$translatable</span> = [<span class="token-string">'name'</span>, <span class="token-string">'description'</span>, <span class="token-string">'short_description'</span>, <span class="token-string">'meta_title'</span>, <span class="token-string">'meta_description'</span>];

    <span class="token-keyword">protected</span> <span class="token-variable">$fillable</span> = [
        <span class="token-string">'user_id'</span>, <span class="token-string">'name'</span>, <span class="token-string">'slug'</span>, <span class="token-string">'description'</span>, <span class="token-string">'short_description'</span>,
        <span class="token-string">'logo'</span>, <span class="token-string">'banner'</span>, <span class="token-string">'category_id'</span>, <span class="token-string">'commission_rate'</span>,
        <span class="token-string">'is_active'</span>, <span class="token-string">'is_featured'</span>, <span class="token-string">'verified_at'</span>,
        <span class="token-string">'paypal_email'</span>, <span class="token-string">'bank_iban'</span>, <span class="token-string">'bank_bic'</span>, <span class="token-string">'bank_name'</span>,
        <span class="token-string">'company_name'</span>, <span class="token-string">'siret'</span>, <span class="token-string">'tax_number'</span>,
        <span class="token-string">'address'</span>, <span class="token-string">'city'</span>, <span class="token-string">'postal_code'</span>, <span class="token-string">'country'</span>, <span class="token-string">'phone'</span>,
    ];

    <span class="token-keyword">protected function</span> <span class="token-function">casts</span>(): <span class="token-keyword">array</span>
    {
        <span class="token-keyword">return</span> [
            <span class="token-string">'is_active'</span> => <span class="token-string">'boolean'</span>,
            <span class="token-string">'is_featured'</span> => <span class="token-string">'boolean'</span>,
            <span class="token-string">'verified_at'</span> => <span class="token-string">'datetime'</span>,
            <span class="token-string">'commission_rate'</span> => <span class="token-string">'decimal:2'</span>,
        ];
    }

    <span class="token-keyword">protected static function</span> <span class="token-function">boot</span>()
    {
        <span class="token-keyword">parent</span>::boot();
        <span class="token-keyword">static</span>::<span class="token-function">creating</span>(<span class="token-keyword">function</span> (<span class="token-variable">$store</span>) {
            <span class="token-keyword">if</span> (<span class="token-function">empty</span>(<span class="token-variable">$store</span>->slug)) {
                <span class="token-variable">$name</span> = <span class="token-function">is_array</span>(<span class="token-variable">$store</span>->name) ? (<span class="token-variable">$store</span>->name[<span class="token-string">'fr'</span>] ?? <span class="token-function">reset</span>(<span class="token-variable">$store</span>->name)) : <span class="token-variable">$store</span>->name;
                <span class="token-variable">$store</span>->slug = Str::<span class="token-function">slug</span>(<span class="token-variable">$name</span>);
            }
        });
    }
    
    <span class="token-keyword">public function</span> <span class="token-function">registerMediaCollections</span>(): <span class="token-keyword">void</span>
    {
        <span class="token-variable">$this</span>-><span class="token-function">addMediaCollection</span>(<span class="token-string">'logo'</span>)-><span class="token-function">singleFile</span>();
        <span class="token-variable">$this</span>-><span class="token-function">addMediaCollection</span>(<span class="token-string">'banner'</span>)-><span class="token-function">singleFile</span>();
    }

    <span class="token-keyword">public function</span> <span class="token-function">user</span>(): <span class="token-class-name">BelongsTo</span> { <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">belongsTo</span>(User::<span class="token-keyword">class</span>); }
    <span class="token-keyword">public function</span> <span class="token-function">products</span>(): <span class="token-class-name">HasMany</span> { <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">hasMany</span>(Product::<span class="token-keyword">class</span>); }

    <span class="token-keyword">public function</span> <span class="token-function">getLogoUrlAttribute</span>(): <span class="token-keyword">string</span>
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">hasMedia</span>(<span class="token-string">'logo'</span>) ? <span class="token-variable">$this</span>-><span class="token-function">getFirstMediaUrl</span>(<span class="token-string">'logo'</span>) : <span class="token-function">asset</span>(<span class="token-string">'images/default-store.jpg'</span>);
    }
    
    <span class="token-keyword">public function</span> <span class="token-function">isVerified</span>(): <span class="token-keyword">bool</span>
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>->verified_at !== <span class="token-keyword">null</span> && <span class="token-variable">$this</span>->is_active;
    }
}</code></pre>
    <button class="copy-btn">Copier</button>
</div>

<!-- Explications du modèle Store -->
<div class="alert-info mt-4">
    <strong>📖 Points clés du Modèle :</strong>
    <ul class="list-disc ml-6 mt-2 text-sm">
        <li><code>HasTranslations</code> : Permet de traduire le nom et la description du magasin.</li>
        <li><code>registerMediaCollections</code> : Configure Spatie Media Library pour gérer 1 seul logo et 1 seule bannière par boutique.</li>
        <li><code>boot()</code> : Génère automatiquement le slug à la création comme pour les produits.</li>
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
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Store</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Http\Request</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Facades\Auth</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Str</span>;

<span class="token-keyword">class</span> <span class="token-class-name">StoreController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-keyword">public function</span> <span class="token-function">create</span>()
    {
        <span class="token-keyword">if</span> (Auth::<span class="token-function">user</span>()->store) {
            <span class="token-keyword">return</span> <span class="token-function">redirect</span>()-><span class="token-function">route</span>(<span class="token-string">'vendor.store.edit'</span>);
        }
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'vendor.store.create'</span>);
    }

    <span class="token-keyword">public function</span> <span class="token-function">store</span>(Request <span class="token-variable">$request</span>)
    {
        <span class="token-variable">$validated</span> = <span class="token-variable">$request</span>-><span class="token-function">validate</span>([
            <span class="token-string">'name'</span> => <span class="token-string">'required|string|max:255'</span>,
            <span class="token-string">'description'</span> => <span class="token-string">'nullable|string|max:1000'</span>,
            <span class="token-string">'short_description'</span> => <span class="token-string">'nullable|string|max:300'</span>,
            <span class="token-string">'logo'</span> => <span class="token-string">'nullable|image|max:1024'</span>,
            <span class="token-string">'banner'</span> => <span class="token-string">'nullable|image|max:2048'</span>,
            <span class="token-string">'company_name'</span> => <span class="token-string">'nullable|string|max:255'</span>,
            <span class="token-string">'siret'</span> => <span class="token-string">'nullable|string|max:20'</span>,
            <span class="token-string">'tax_number'</span> => <span class="token-string">'nullable|string|max:30'</span>,
            <span class="token-string">'address'</span> => <span class="token-string">'nullable|string|max:255'</span>,
            <span class="token-string">'city'</span> => <span class="token-string">'nullable|string|max:100'</span>,
            <span class="token-string">'postal_code'</span> => <span class="token-string">'nullable|string|max:20'</span>,
            <span class="token-string">'country'</span> => <span class="token-string">'nullable|string|max:100'</span>,
            <span class="token-string">'phone'</span> => <span class="token-string">'nullable|string|max:20'</span>,
            <span class="token-string">'paypal_email'</span> => <span class="token-string">'nullable|email'</span>,
            <span class="token-string">'bank_iban'</span> => <span class="token-string">'nullable|string|max:50'</span>,
            <span class="token-string">'bank_bic'</span> => <span class="token-string">'nullable|string|max:20'</span>,
            <span class="token-string">'bank_name'</span> => <span class="token-string">'nullable|string|max:100'</span>,
        ]);

        <span class="token-variable">$user</span> = Auth::<span class="token-function">user</span>();

        <span class="token-comment">// Création de la boutique</span>
        <span class="token-variable">$store</span> = Store::<span class="token-function">create</span>([
            <span class="token-string">'user_id'</span> => <span class="token-variable">$user</span>->id,
            <span class="token-string">'name'</span> => [<span class="token-string">'fr'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'name'</span>]], <span class="token-comment">// Support Translatable</span>
            <span class="token-string">'description'</span> => [<span class="token-string">'fr'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'description'</span>] ?? <span class="token-keyword">null</span>],
            <span class="token-string">'short_description'</span> => [<span class="token-string">'fr'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'short_description'</span>] ?? <span class="token-keyword">null</span>],
            <span class="token-string">'slug'</span> => Str::<span class="token-function">slug</span>(<span class="token-variable">$validated</span>[<span class="token-string">'name'</span>]),
            <span class="token-comment">// ... mappage des autres champs optionnels ...</span>
            <span class="token-string">'company_name'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'company_name'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'siret'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'siret'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'tax_number'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'tax_number'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'address'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'address'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'city'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'city'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'postal_code'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'postal_code'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'country'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'country'</span>] ?? <span class="token-string">'France'</span>,
            <span class="token-string">'phone'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'phone'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'paypal_email'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'paypal_email'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'bank_iban'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'bank_iban'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'bank_bic'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'bank_bic'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'bank_name'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'bank_name'</span>] ?? <span class="token-keyword">null</span>,
            <span class="token-string">'commission_rate'</span> => <span class="token-number">10.00</span>,
            <span class="token-string">'is_active'</span> => <span class="token-keyword">true</span>,
        ]);

        <span class="token-comment">// Marquer l'utilisateur comme vendeur et lui donner le rôle</span>
        <span class="token-variable">$user</span>-><span class="token-function">update</span>([<span class="token-string">'is_vendor'</span> => <span class="token-keyword">true</span>]);
        <span class="token-variable">$user</span>-><span class="token-function">assignRole</span>(<span class="token-string">'vendor'</span>);

        <span class="token-comment">// Gestion des médias (Logo/Bannière)</span>
        <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">hasFile</span>(<span class="token-string">'logo'</span>)) {
            <span class="token-variable">$store</span>-><span class="token-function">addMediaFromRequest</span>(<span class="token-string">'logo'</span>)-><span class="token-function">toMediaCollection</span>(<span class="token-string">'logo'</span>);
        }
        <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">hasFile</span>(<span class="token-string">'banner'</span>)) {
            <span class="token-variable">$store</span>-><span class="token-function">addMediaFromRequest</span>(<span class="token-string">'banner'</span>)-><span class="token-function">toMediaCollection</span>(<span class="token-string">'banner'</span>);
        }

        <span class="token-keyword">return</span> <span class="token-function">redirect</span>()-><span class="token-function">route</span>(<span class="token-string">'vendor.dashboard'</span>)
            -><span class="token-function">with</span>(<span class="token-string">'success'</span>, <span class="token-string">'Boutique créée avec succès !'</span>);
    }
    
    <span class="token-comment">// ... Méthodes edit() et update() à implémenter de manière similaire</span>
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
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Category</span>;
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Http\Request</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Facades\Auth</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Facades\Storage</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Str</span>;

<span class="token-keyword">class</span> <span class="token-class-name">ProductController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-comment">/**
     * Vérifie que le produit appartient au vendeur connecté.
     */</span>
    <span class="token-keyword">private function</span> <span class="token-function">ensureOwnership</span>(Product <span class="token-variable">$product</span>): <span class="token-keyword">void</span>
    {
        <span class="token-variable">$store</span> = Auth::<span class="token-function">user</span>()->store;
        <span class="token-keyword">if</span> (!<span class="token-variable">$store</span> || <span class="token-variable">$product</span>->store_id !== <span class="token-variable">$store</span>->id) {
            <span class="token-function">abort</span>(<span class="token-number">403</span>, <span class="token-string">'Vous n\'êtes pas autorisé à modifier ce produit.'</span>);
        }
    }

    <span class="token-keyword">public function</span> <span class="token-function">index</span>()
    {
        <span class="token-variable">$store</span> = Auth::<span class="token-function">user</span>()->store;
        
        <span class="token-comment">// Récupérer les produits DU vendeur (filtrage)</span>
        <span class="token-variable">$products</span> = Product::<span class="token-function">where</span>(<span class="token-string">'store_id'</span>, <span class="token-variable">$store</span>->id)
            -><span class="token-function">with</span>(<span class="token-string">'categories'</span>) <span class="token-comment">// Eager loading</span>
            -><span class="token-function">latest</span>()
            -><span class="token-function">paginate</span>(<span class="token-number">10</span>);
        
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'vendor.products.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'products'</span>, <span class="token-string">'store'</span>));
    }

    <span class="token-keyword">public function</span> <span class="token-function">create</span>()
    {
        <span class="token-variable">$categories</span> = Category::<span class="token-function">parents</span>()-><span class="token-function">with</span>(<span class="token-string">'children'</span>)-><span class="token-function">ordered</span>()-><span class="token-function">get</span>();
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'vendor.products.create'</span>, <span class="token-function">compact</span>(<span class="token-string">'categories'</span>));
    }

    <span class="token-keyword">public function</span> <span class="token-function">store</span>(Request <span class="token-variable">$request</span>)
    {
        <span class="token-variable">$validated</span> = <span class="token-variable">$request</span>-><span class="token-function">validate</span>([
            <span class="token-string">'name'</span> => <span class="token-string">'required|string|max:255'</span>,
            <span class="token-string">'description'</span> => <span class="token-string">'required|string'</span>,
            <span class="token-string">'price'</span> => <span class="token-string">'required|numeric|min:0'</span>,
            <span class="token-string">'type'</span> => <span class="token-string">'required|in:digital,course,subscription,license'</span>,
            <span class="token-string">'category_id'</span> => <span class="token-string">'nullable|exists:categories,id'</span>,
            <span class="token-string">'thumbnail'</span> => <span class="token-string">'nullable|image|max:2048'</span>,
        ]);

        <span class="token-variable">$store</span> = Auth::<span class="token-function">user</span>()->store;

        <span class="token-comment">// Création du produit lié au store</span>
        <span class="token-variable">$product</span> = Product::<span class="token-function">create</span>([
            <span class="token-string">'store_id'</span> => <span class="token-variable">$store</span>->id,
            <span class="token-string">'name'</span> => [<span class="token-string">'fr'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'name'</span>]],
            <span class="token-string">'description'</span> => [<span class="token-string">'fr'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'description'</span>]],
            <span class="token-string">'slug'</span> => Str::<span class="token-function">slug</span>(<span class="token-variable">$validated</span>[<span class="token-string">'name'</span>]) . <span class="token-string">'-'</span> . <span class="token-function">uniqid</span>(), <span class="token-comment">// Slug unique</span>
            <span class="token-string">'type'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'type'</span>],
            <span class="token-string">'price'</span> => <span class="token-variable">$validated</span>[<span class="token-string">'price'</span>],
            <span class="token-string">'is_active'</span> => <span class="token-variable">$request</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>),
        ]);

        <span class="token-comment">// Attacher la catégorie pivot</span>
        <span class="token-keyword">if</span> (!<span class="token-function">empty</span>(<span class="token-variable">$validated</span>[<span class="token-string">'category_id'</span>])) {
            <span class="token-variable">$product</span>-><span class="token-function">categories</span>()-><span class="token-function">attach</span>(<span class="token-variable">$validated</span>[<span class="token-string">'category_id'</span>]);
        }

        <span class="token-comment">// Upload thumbnail avec UUID personnalisé</span>
        <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">hasFile</span>(<span class="token-string">'thumbnail'</span>)) {
            <span class="token-variable">$file</span> = <span class="token-variable">$request</span>-><span class="token-function">file</span>(<span class="token-string">'thumbnail'</span>);
            <span class="token-variable">$filename</span> = Str::<span class="token-function">uuid</span>() . <span class="token-string">'.'</span> . <span class="token-variable">$file</span>-><span class="token-function">getClientOriginalExtension</span>();
            <span class="token-variable">$path</span> = <span class="token-variable">$file</span>-><span class="token-function">storeAs</span>(<span class="token-string">'products/thumbnails'</span>, <span class="token-variable">$filename</span>, <span class="token-string">'public'</span>);
            <span class="token-variable">$product</span>-><span class="token-function">update</span>([<span class="token-string">'thumbnail'</span> => <span class="token-variable">$path</span>]);
        }

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
