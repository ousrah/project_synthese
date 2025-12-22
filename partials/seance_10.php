<!-- =================================================================== -->
<!-- SÉANCE 10 : FINALISATION & DÉPLOIEMENT -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-purple-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-5 mr-3">Séance 10</span>
    Finalisation & Déploiement
</h2>

<!-- ========== 10.1 EMAILS ========== -->
<section id="seance10-emails" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">10.1 Emails Transactionnels</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Types d'emails dans un e-commerce</h4>
            
            <div class="alert-info mb-4">
                <strong>📖 Emails essentiels :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><strong>Confirmation de commande</strong> : Envoyé après paiement</li>
                    <li><strong>Notification vendeur</strong> : Nouvelle vente reçue</li>
                    <li><strong>Facture</strong> : Document PDF en pièce jointe</li>
                    <li><strong>Bienvenue</strong> : Après inscription</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer un Mailable</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:mail OrderConfirmation --markdown=emails.order-confirmation</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Mail/OrderConfirmation.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Mail</span>;

<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Order</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Bus\Queueable</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Mail\Mailable</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Mail\Mailables\Content</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Mail\Mailables\Envelope</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Queue\SerializesModels</span>;

<span class="token-keyword">class</span> <span class="token-class-name">OrderConfirmation</span> <span class="token-keyword">extends</span> <span class="token-class-name">Mailable</span>
{
    <span class="token-keyword">use</span> Queueable, SerializesModels;

    <span class="token-keyword">public function</span> <span class="token-function">__construct</span>(
        <span class="token-keyword">public</span> Order <span class="token-variable">$order</span>
    ) {}

    <span class="token-keyword">public function</span> <span class="token-function">envelope</span>(): <span class="token-class-name">Envelope</span>
    {
        <span class="token-keyword">return</span> <span class="token-keyword">new</span> Envelope(
            subject: <span class="token-string">'Confirmation de votre commande #'</span> . <span class="token-variable">$this</span>->order->order_number,
        );
    }

    <span class="token-keyword">public function</span> <span class="token-function">content</span>(): <span class="token-class-name">Content</span>
    {
        <span class="token-keyword">return</span> <span class="token-keyword">new</span> Content(
            markdown: <span class="token-string">'emails.order-confirmation'</span>,
        );
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Template d'email Markdown</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/emails/order-confirmation.blade.php --&gt;</span>

&lt;x-mail::message&gt;
# Merci pour votre commande !

Bonjour <span class="token-blade">{{ $order->user->name }}</span>,

Votre commande **#<span class="token-blade">{{ $order->order_number }}</span>** a été confirmée.

## Récapitulatif :

| Produit | Prix |
|:--------|-----:|
<span class="token-blade">@foreach($order->items as $item)</span>
| <span class="token-blade">{{ $item->product_name }}</span> | <span class="token-blade">{{ number_format($item->total, 2) }}</span> € |
<span class="token-blade">@endforeach</span>
| **Total** | **<span class="token-blade">{{ number_format($order->total, 2) }}</span> €** |

&lt;x-mail::button :url="route('orders.show', $order)"&gt;
Voir ma commande
&lt;/x-mail::button&gt;

Merci,&lt;br&gt;
<span class="token-blade">{{ config('app.name') }}</span>
&lt;/x-mail::message&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Envoyer l'email</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Dans PaymentController après paiement réussi</span>

<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Facades\Mail</span>;
<span class="token-keyword">use</span> <span class="token-class-name">App\Mail\OrderConfirmation</span>;

<span class="token-comment">// Envoyer l'email de confirmation</span>
Mail::<span class="token-function">to</span>(<span class="token-variable">$order</span>->user)-><span class="token-function">send</span>(<span class="token-keyword">new</span> OrderConfirmation(<span class="token-variable">$order</span>));

<span class="token-comment">// Ou en file d'attente (recommandé)</span>
Mail::<span class="token-function">to</span>(<span class="token-variable">$order</span>->user)-><span class="token-function">queue</span>(<span class="token-keyword">new</span> OrderConfirmation(<span class="token-variable">$order</span>));</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Configuration email (.env) :</strong>
                <pre class="text-sm mt-2">MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password</pre>
                <p class="text-sm mt-2">Utilisez <a href="https://mailtrap.io" class="text-blue-600 underline">Mailtrap</a> pour tester en développement.</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== 10.2 SEO ========== -->
<section id="seance10-seo" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">10.2 SEO & Optimisation</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Meta tags dynamiques</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/components/layouts/app.blade.php --&gt;</span>

&lt;head&gt;
    &lt;title&gt;<span class="token-blade">{{ $title ?? config('app.name') }}</span> | <span class="token-blade">{{ config('app.name') }}</span>&lt;/title&gt;
    &lt;meta name="description" content="<span class="token-blade">{{ $description ?? 'Marketplace de produits numériques' }}</span>"&gt;
    
    <span class="token-comment">&lt;!-- Open Graph pour réseaux sociaux --&gt;</span>
    &lt;meta property="og:title" content="<span class="token-blade">{{ $title ?? config('app.name') }}</span>"&gt;
    &lt;meta property="og:description" content="<span class="token-blade">{{ $description ?? '' }}</span>"&gt;
    &lt;meta property="og:image" content="<span class="token-blade">{{ $image ?? asset('images/og-default.jpg') }}</span>"&gt;
    &lt;meta property="og:url" content="<span class="token-blade">{{ url()->current() }}</span>"&gt;
&lt;/head&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Sitemap XML automatique</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>composer require spatie/laravel-sitemap</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Générer le sitemap</span>
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\Sitemap\Sitemap</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Spatie\Sitemap\Tags\Url</span>;

Sitemap::<span class="token-function">create</span>()
    -><span class="token-function">add</span>(Url::<span class="token-function">create</span>(<span class="token-string">'/'</span>))
    -><span class="token-function">add</span>(Url::<span class="token-function">create</span>(<span class="token-string">'/products'</span>))
    -><span class="token-function">add</span>(Product::<span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>)-><span class="token-function">get</span>())
    -><span class="token-function">writeToFile</span>(<span class="token-function">public_path</span>(<span class="token-string">'sitemap.xml'</span>));</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Cache avec Redis</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Cacher les requêtes fréquentes</span>

<span class="token-variable">$products</span> = Cache::<span class="token-function">remember</span>(<span class="token-string">'products.featured'</span>, <span class="token-number">3600</span>, <span class="token-keyword">function</span> () {
    <span class="token-keyword">return</span> Product::<span class="token-function">where</span>(<span class="token-string">'is_featured'</span>, <span class="token-keyword">true</span>)
        -><span class="token-function">with</span>(<span class="token-string">'category'</span>)
        -><span class="token-function">take</span>(<span class="token-number">8</span>)
        -><span class="token-function">get</span>();
});

<span class="token-comment">// Invalider le cache après modification</span>
Cache::<span class="token-function">forget</span>(<span class="token-string">'products.featured'</span>);</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 10.3 TESTS ========== -->
<section id="seance10-tests" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">10.3 Tests Automatisés (Pest)</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Pourquoi tester ?</h4>
            
            <div class="alert-info mb-4">
                <strong>📖 Avantages des tests :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li>Détection précoce des bugs</li>
                    <li>Refactoring en confiance</li>
                    <li>Documentation vivante du code</li>
                    <li>CI/CD automatisé</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Test de feature avec Pest</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// tests/Feature/ProductTest.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>;
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Category</span>;

<span class="token-function">it</span>(<span class="token-string">'affiche la liste des produits'</span>, <span class="token-keyword">function</span> () {
    <span class="token-comment">// Arrange</span>
    <span class="token-variable">$category</span> = Category::<span class="token-function">factory</span>()-><span class="token-function">create</span>();
    <span class="token-variable">$products</span> = Product::<span class="token-function">factory</span>(<span class="token-number">3</span>)-><span class="token-function">create</span>([
        <span class="token-string">'category_id'</span> => <span class="token-variable">$category</span>->id,
        <span class="token-string">'is_active'</span> => <span class="token-keyword">true</span>,
    ]);

    <span class="token-comment">// Act</span>
    <span class="token-variable">$response</span> = <span class="token-variable">$this</span>-><span class="token-function">get</span>(<span class="token-string">'/products'</span>);

    <span class="token-comment">// Assert</span>
    <span class="token-variable">$response</span>-><span class="token-function">assertStatus</span>(<span class="token-number">200</span>);
    <span class="token-variable">$response</span>-><span class="token-function">assertSee</span>(<span class="token-variable">$products</span>[<span class="token-number">0</span>]->name);
});

<span class="token-function">it</span>(<span class="token-string">'permet à un vendeur de créer un produit'</span>, <span class="token-keyword">function</span> () {
    <span class="token-variable">$vendor</span> = User::<span class="token-function">factory</span>()-><span class="token-function">vendor</span>()-><span class="token-function">create</span>();
    <span class="token-variable">$category</span> = Category::<span class="token-function">factory</span>()-><span class="token-function">create</span>();
    
    <span class="token-variable">$response</span> = <span class="token-variable">$this</span>-><span class="token-function">actingAs</span>(<span class="token-variable">$vendor</span>)-><span class="token-function">post</span>(<span class="token-string">'/vendor/products'</span>, [
        <span class="token-string">'name'</span> => <span class="token-string">'Mon Produit Test'</span>,
        <span class="token-string">'price'</span> => <span class="token-number">29.99</span>,
        <span class="token-string">'category_id'</span> => <span class="token-variable">$category</span>->id,
        <span class="token-string">'description'</span> => <span class="token-string">'Description du produit'</span>,
    ]);
    
    <span class="token-variable">$response</span>-><span class="token-function">assertRedirect</span>();
    <span class="token-variable">$this</span>-><span class="token-function">assertDatabaseHas</span>(<span class="token-string">'products'</span>, [<span class="token-string">'name'</span> => <span class="token-string">'Mon Produit Test'</span>]);
});</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Exécuter tous les tests</span>
./vendor/bin/pest

<span class="token-comment"># Tests avec couverture</span>
./vendor/bin/pest --coverage</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 10.4 DEPLOY ========== -->
<section id="seance10-deploy" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">10.4 Déploiement en Production</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Checklist pré-déploiement</h4>
            
            <div class="alert-warning mb-4">
                <strong>⚠️ À vérifier avant mise en production :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>APP_DEBUG=false</code></li>
                    <li><code>APP_ENV=production</code></li>
                    <li>Clés Stripe/PayPal en mode live</li>
                    <li>Configuration email production</li>
                    <li>HTTPS configuré</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Commandes de déploiement</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># 1. Installer les dépendances (sans dev)</span>
composer install --optimize-autoloader --no-dev

<span class="token-comment"># 2. Compiler les assets</span>
npm run build

<span class="token-comment"># 3. Cacher les configurations</span>
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

<span class="token-comment"># 4. Migrer la base de données</span>
php artisan migrate --force

<span class="token-comment"># 5. Créer le lien storage</span>
php artisan storage:link

<span class="token-comment"># 6. Optimiser l'autoloader</span>
composer dump-autoload --optimize</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Configuration du serveur web (Nginx)</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">nginx</span>
                <pre class="code-block"><code>server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/boutique/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">HTTPS avec Certbot (Let's Encrypt)</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Installer Certbot</span>
sudo apt install certbot python3-certbot-nginx

<span class="token-comment"># Obtenir un certificat SSL gratuit</span>
sudo certbot --nginx -d votre-domaine.com -d www.votre-domaine.com

<span class="token-comment"># Renouvellement automatique (déjà configuré par Certbot)</span>
sudo certbot renew --dry-run</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Félicitations !</strong> Vous avez terminé toutes les séances du cours ! 
        Votre marketplace est maintenant prête à être mise en production.
        <br><br>
        <strong>Prochaines étapes suggérées :</strong>
        <ul class="list-disc ml-6 mt-2">
            <li>Ajouter des fonctionnalités avancées (coupons, abonnements...)</li>
            <li>Implémenter Stripe Connect pour les paiements directs aux vendeurs</li>
            <li>Ajouter l'internationalisation (multi-langues)</li>
            <li>Créer une application mobile avec API REST</li>
        </ul>
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>
