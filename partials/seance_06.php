<!-- =================================================================== -->
<!-- SÉANCE 6 : MÉDIAS & UPLOAD DE FICHIERS -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-blue-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-1 mr-3">Séance 6</span>
    Médias & Upload de Fichiers
</h2>

<section id="seance6-spatie" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">6.1 Installation de Spatie Media Library</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Pourquoi Spatie Media Library ?</h4>
            <p class="text-gray-700 mb-4">
                Gérer les uploads manuellement est fastidieux (stockage, noms uniques, miniatures...). 
                <strong>Spatie Media Library</strong> automatise tout cela avec une API élégante.
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Avantages de Spatie Media Library :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li>Upload et stockage automatiques (local, S3, etc.)</li>
                    <li>Génération automatique de miniatures (conversions)</li>
                    <li>Association facile aux modèles Eloquent</li>
                    <li>Collections de médias (images, downloads, etc.)</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Installation</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>composer require spatie/laravel-medialibrary

php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

php artisan migrate</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Ce que cela crée :</strong> Une table <code>media</code> pour stocker les informations 
                sur tous les fichiers uploadés (nom, chemin, type MIME, etc.).
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Configurer le modèle Product</h4>
            <p class="text-gray-700 mb-4">
                Le modèle doit implémenter <code>HasMedia</code> et utiliser le trait <code>InteractsWithMedia</code>.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/Product.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">Spatie\MediaLibrary\HasMedia</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\MediaLibrary\InteractsWithMedia</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Product</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span> <span class="token-keyword">implements</span> <span class="token-class-name">HasMedia</span>
{
    <span class="token-keyword">use</span> InteractsWithMedia;

    <span class="token-keyword">public function</span> <span class="token-function">registerMediaCollections</span>(): <span class="token-keyword">void</span>
    {
        <span class="token-variable">$this</span>-><span class="token-function">addMediaCollection</span>(<span class="token-string">'images'</span>);
        <span class="token-variable">$this</span>-><span class="token-function">addMediaCollection</span>(<span class="token-string">'downloads'</span>)-><span class="token-function">singleFile</span>();
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Collections de médias :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>images</code> : Collection pour multiples images (galerie produit)</li>
                    <li><code>downloads</code> + <code>singleFile()</code> : Un seul fichier par produit (le fichier à télécharger)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="seance6-product-images" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">6.2 Images Multiples pour Produits</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Upload d'images dans le contrôleur</h4>
            <p class="text-gray-700 mb-4">
                L'upload se fait en une ligne avec <code>addMedia()</code>. La méthode gère automatiquement 
                le stockage, le nommage unique et l'association au modèle.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Dans Vendor/ProductController.php - méthode store()</span>

<span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">hasFile</span>(<span class="token-string">'images'</span>)) {
    <span class="token-keyword">foreach</span> (<span class="token-variable">$request</span>-><span class="token-function">file</span>(<span class="token-string">'images'</span>) <span class="token-keyword">as</span> <span class="token-variable">$image</span>) {
        <span class="token-variable">$product</span>-><span class="token-function">addMedia</span>(<span class="token-variable">$image</span>)-><span class="token-function">toMediaCollection</span>(<span class="token-string">'images'</span>);
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Ce qui se passe en coulisses :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li>Le fichier est déplacé vers <code>storage/app/public/</code></li>
                    <li>Un enregistrement est créé dans la table <code>media</code></li>
                    <li>L'association avec le produit est automatique</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Récupérer les images dans une vue</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/products/show.blade.php --&gt;</span>

<span class="token-blade">@foreach($product->getMedia('images') as $image)</span>
    &lt;img src="<span class="token-blade">{{ $image->getUrl() }}</span>" alt="Image produit"&gt;
    
    <span class="token-comment">&lt;!-- Ou avec une conversion (miniature) --&gt;</span>
    &lt;img src="<span class="token-blade">{{ $image->getUrl('thumb') }}</span>" alt="Miniature"&gt;
<span class="token-blade">@endforeach</span></code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<section id="seance6-digital-files" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">6.3 Upload de Fichiers Numériques</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Fichier téléchargeable (produit numérique)</h4>
            <p class="text-gray-700 mb-4">
                Pour les produits numériques (ebooks, logiciels...), on utilise la collection <code>downloads</code> 
                configurée avec <code>singleFile()</code> pour qu'un nouveau fichier remplace l'ancien.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Upload du fichier téléchargeable</span>
<span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">hasFile</span>(<span class="token-string">'download_file'</span>)) {
    <span class="token-variable">$product</span>-><span class="token-function">addMedia</span>(<span class="token-variable">$request</span>-><span class="token-function">file</span>(<span class="token-string">'download_file'</span>))
        -><span class="token-function">toMediaCollection</span>(<span class="token-string">'downloads'</span>);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Formulaire d'upload</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/vendor/products/create.blade.php --&gt;</span>

&lt;form action="<span class="token-blade">{{ route('vendor.products.store') }}</span>" 
      method="POST" 
      enctype="multipart/form-data"&gt;
    <span class="token-blade">@csrf</span>
    
    <span class="token-comment">&lt;!-- Images multiples --&gt;</span>
    &lt;div class="mb-3"&gt;
        &lt;label class="form-label"&gt;Images du produit&lt;/label&gt;
        &lt;input type="file" name="images[]" multiple class="form-control" accept="image/*"&gt;
    &lt;/div&gt;
    
    <span class="token-comment">&lt;!-- Fichier à télécharger --&gt;</span>
    &lt;div class="mb-3"&gt;
        &lt;label class="form-label"&gt;Fichier téléchargeable (ZIP, PDF...)&lt;/label&gt;
        &lt;input type="file" name="download_file" class="form-control"&gt;
    &lt;/div&gt;
    
    &lt;button type="submit" class="btn btn-primary"&gt;Créer le produit&lt;/button&gt;
&lt;/form&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-warning mt-4">
                <strong>⚠️ Important :</strong> N'oubliez pas <code>enctype="multipart/form-data"</code> 
                sur le formulaire, sinon les fichiers ne seront pas envoyés !
            </div>
        </div>
    </div>
</section>

<section id="seance6-thumbnails" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">6.4 Génération de Miniatures</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Définir les conversions dans le modèle</h4>
            <p class="text-gray-700 mb-4">
                Les <strong>conversions</strong> permettent de générer automatiquement des versions 
                redimensionnées des images (miniatures, previews, etc.).
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/Product.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">Spatie\MediaLibrary\MediaCollections\Models\Media</span>;

<span class="token-keyword">public function</span> <span class="token-function">registerMediaConversions</span>(Media <span class="token-variable">$media</span> = <span class="token-keyword">null</span>): <span class="token-keyword">void</span>
{
    <span class="token-comment">// Miniature pour les listes de produits</span>
    <span class="token-variable">$this</span>-><span class="token-function">addMediaConversion</span>(<span class="token-string">'thumb'</span>)
        -><span class="token-function">width</span>(<span class="token-number">300</span>)
        -><span class="token-function">height</span>(<span class="token-number">200</span>)
        -><span class="token-function">sharpen</span>(<span class="token-number">10</span>);

    <span class="token-comment">// Preview pour la page produit</span>
    <span class="token-variable">$this</span>-><span class="token-function">addMediaConversion</span>(<span class="token-string">'preview'</span>)
        -><span class="token-function">width</span>(<span class="token-number">800</span>)
        -><span class="token-function">height</span>(<span class="token-number">600</span>);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Utilisation des conversions :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>$product->getFirstMediaUrl('images', 'thumb')</code> → URL de la miniature</li>
                    <li><code>$product->getFirstMediaUrl('images', 'preview')</code> → URL du preview</li>
                    <li>Les conversions sont générées automatiquement à l'upload</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Accesseur pour faciliter l'accès</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/Product.php - Ajouter un accessor</span>

<span class="token-keyword">public function</span> <span class="token-function">getThumbnailUrlAttribute</span>(): <span class="token-keyword">string</span>
{
    <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">getFirstMediaUrl</span>(<span class="token-string">'images'</span>, <span class="token-string">'thumb'</span>) 
        ?: <span class="token-string">'https://via.placeholder.com/300x200'</span>;
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <p class="text-gray-700 mt-4">
                Maintenant on peut utiliser <code>$product->thumbnail_url</code> dans les vues !
            </p>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 6 !</strong> Vous pouvez maintenant gérer les images et 
        fichiers téléchargeables de vos produits avec Spatie Media Library.
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>
