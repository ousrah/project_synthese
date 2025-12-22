<!-- =================================================================== -->
<!-- SÉANCE 5 : PAIEMENTS (STRIPE & PAYPAL) -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-purple-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-5 mr-3">Séance 5</span>
    Paiements (Stripe & PayPal)
</h2>

<!-- ========== 5.1 STRIPE ========== -->
<section id="seance5-stripe" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">5.1 Intégration Stripe (Carte Bancaire)</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Pourquoi Stripe ?</h4>
            <p class="text-gray-700 mb-4">
                <strong>Stripe</strong> est l'un des services de paiement les plus populaires pour les développeurs. 
                Il gère la sécurité des cartes bancaires (PCI DSS) et propose une API simple.
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Les deux approches Stripe :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><strong>Stripe Checkout</strong> : Redirection vers une page hébergée par Stripe (plus simple, utilisé ici)</li>
                    <li><strong>Stripe Elements</strong> : Formulaire intégré dans votre site (plus personnalisable)</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Installer et configurer Stripe</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>composer require stripe/stripe-php</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <p class="text-gray-700 mt-4 mb-4">
                Créez un compte sur <a href="https://dashboard.stripe.com" target="_blank" class="text-blue-600 underline">stripe.com</a> 
                et récupérez vos clés de test dans <strong>Developers → API Keys</strong>.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">env</span>
                <pre class="code-block"><code>STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_SECRET=sk_test_votre_cle_secrete</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-warning mt-4">
                <strong>⚠️ Important :</strong> Les clés commençant par <code>pk_test_</code> et <code>sk_test_</code> 
                sont des clés de test. Utilisez les clés <code>pk_live_</code> en production.
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Controller de paiement Stripe</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/PaymentController.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">Stripe\Stripe</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Stripe\Checkout\Session</span>;

<span class="token-keyword">public function</span> <span class="token-function">stripeCheckout</span>(Request <span class="token-variable">$request</span>)
{
    Stripe::<span class="token-function">setApiKey</span>(<span class="token-function">config</span>(<span class="token-string">'services.stripe.secret'</span>));

    <span class="token-variable">$cart</span> = <span class="token-function">session</span>(<span class="token-string">'cart'</span>, []);
    <span class="token-variable">$lineItems</span> = [];

    <span class="token-keyword">foreach</span> (<span class="token-variable">$cart</span> <span class="token-keyword">as</span> <span class="token-variable">$item</span>) {
        <span class="token-variable">$lineItems</span>[] = [
            <span class="token-string">'price_data'</span> => [
                <span class="token-string">'currency'</span> => <span class="token-string">'eur'</span>,
                <span class="token-string">'product_data'</span> => [<span class="token-string">'name'</span> => <span class="token-variable">$item</span>[<span class="token-string">'name'</span>]],
                <span class="token-string">'unit_amount'</span> => <span class="token-variable">$item</span>[<span class="token-string">'price'</span>] * <span class="token-number">100</span>,
            ],
            <span class="token-string">'quantity'</span> => <span class="token-number">1</span>,
        ];
    }

    <span class="token-variable">$session</span> = Session::<span class="token-function">create</span>([
        <span class="token-string">'payment_method_types'</span> => [<span class="token-string">'card'</span>],
        <span class="token-string">'line_items'</span> => <span class="token-variable">$lineItems</span>,
        <span class="token-string">'mode'</span> => <span class="token-string">'payment'</span>,
        <span class="token-string">'success_url'</span> => <span class="token-function">route</span>(<span class="token-string">'payment.success'</span>) . <span class="token-string">'?session_id={CHECKOUT_SESSION_ID}'</span>,
        <span class="token-string">'cancel_url'</span> => <span class="token-function">route</span>(<span class="token-string">'checkout'</span>),
    ]);

    <span class="token-keyword">return</span> <span class="token-function">redirect</span>(<span class="token-variable">$session</span>->url);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 5.2 PAYPAL ========== -->
<section id="seance5-paypal" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">5.2 Intégration PayPal</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Installer srmklive/paypal</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>composer require srmklive/paypal

php artisan vendor:publish --provider="Srmklive\PayPal\Providers\PayPalServiceProvider"</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">env</span>
                <pre class="code-block"><code>PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=votre_client_id
PAYPAL_SANDBOX_CLIENT_SECRET=votre_client_secret</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Controller PayPal</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/PaymentController.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">Srmklive\PayPal\Services\PayPal</span> <span class="token-keyword">as</span> <span class="token-class-name">PayPalClient</span>;

<span class="token-keyword">public function</span> <span class="token-function">paypalCheckout</span>()
{
    <span class="token-variable">$provider</span> = <span class="token-keyword">new</span> PayPalClient;
    <span class="token-variable">$provider</span>-><span class="token-function">setApiCredentials</span>(<span class="token-function">config</span>(<span class="token-string">'paypal'</span>));
    <span class="token-variable">$token</span> = <span class="token-variable">$provider</span>-><span class="token-function">getAccessToken</span>();
    <span class="token-variable">$provider</span>-><span class="token-function">setAccessToken</span>(<span class="token-variable">$token</span>);

    <span class="token-variable">$cart</span> = <span class="token-function">session</span>(<span class="token-string">'cart'</span>, []);
    <span class="token-variable">$total</span> = <span class="token-function">collect</span>(<span class="token-variable">$cart</span>)-><span class="token-function">sum</span>(<span class="token-string">'price'</span>);

    <span class="token-variable">$order</span> = <span class="token-variable">$provider</span>-><span class="token-function">createOrder</span>([
        <span class="token-string">'intent'</span> => <span class="token-string">'CAPTURE'</span>,
        <span class="token-string">'purchase_units'</span> => [[
            <span class="token-string">'amount'</span> => [
                <span class="token-string">'currency_code'</span> => <span class="token-string">'EUR'</span>,
                <span class="token-string">'value'</span> => <span class="token-function">number_format</span>(<span class="token-variable">$total</span>, <span class="token-number">2</span>, <span class="token-string">'.'</span>, <span class="token-string">''</span>),
            ],
        ]],
        <span class="token-string">'application_context'</span> => [
            <span class="token-string">'return_url'</span> => <span class="token-function">route</span>(<span class="token-string">'paypal.success'</span>),
            <span class="token-string">'cancel_url'</span> => <span class="token-function">route</span>(<span class="token-string">'checkout'</span>),
        ],
    ]);

    <span class="token-variable">$approvalUrl</span> = <span class="token-function">collect</span>(<span class="token-variable">$order</span>[<span class="token-string">'links'</span>])
        -><span class="token-function">firstWhere</span>(<span class="token-string">'rel'</span>, <span class="token-string">'approve'</span>)[<span class="token-string">'href'</span>];

    <span class="token-keyword">return</span> <span class="token-function">redirect</span>(<span class="token-variable">$approvalUrl</span>);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 5.3 WEBHOOKS ========== -->
<section id="seance5-webhooks" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">5.3 Gestion des Webhooks de Paiement</h3>
    
    <div class="section-card">
        <div class="alert-info">
            <strong>💡 Webhooks :</strong> Les webhooks permettent de recevoir des notifications 
            de Stripe/PayPal lorsqu'un paiement est complété, échoué ou remboursé.
        </div>
        
        <div class="code-block-wrapper mt-4">
            <span class="code-lang">php</span>
            <pre class="code-block"><code><span class="token-comment">// Traiter le callback de succès</span>
<span class="token-keyword">public function</span> <span class="token-function">paymentSuccess</span>(Request <span class="token-variable">$request</span>)
{
    <span class="token-variable">$cart</span> = <span class="token-function">session</span>(<span class="token-string">'cart'</span>, []);
    <span class="token-variable">$total</span> = <span class="token-function">collect</span>(<span class="token-variable">$cart</span>)-><span class="token-function">sum</span>(<span class="token-string">'price'</span>);

    <span class="token-comment">// Créer la commande</span>
    <span class="token-variable">$order</span> = Order::<span class="token-function">create</span>([
        <span class="token-string">'user_id'</span> => <span class="token-function">auth</span>()-><span class="token-function">id</span>(),
        <span class="token-string">'order_number'</span> => <span class="token-string">'ORD-'</span> . <span class="token-function">strtoupper</span>(Str::<span class="token-function">random</span>(<span class="token-number">8</span>)),
        <span class="token-string">'status'</span> => <span class="token-string">'completed'</span>,
        <span class="token-string">'payment_status'</span> => <span class="token-string">'paid'</span>,
        <span class="token-string">'subtotal'</span> => <span class="token-variable">$total</span>,
        <span class="token-string">'total'</span> => <span class="token-variable">$total</span>,
        <span class="token-string">'paid_at'</span> => <span class="token-function">now</span>(),
    ]);

    <span class="token-comment">// Créer les items avec calcul des commissions</span>
    <span class="token-keyword">foreach</span> (<span class="token-variable">$cart</span> <span class="token-keyword">as</span> <span class="token-variable">$item</span>) {
        <span class="token-variable">$product</span> = Product::<span class="token-function">with</span>(<span class="token-string">'store'</span>)-><span class="token-function">find</span>(<span class="token-variable">$item</span>[<span class="token-string">'id'</span>]);
        <span class="token-variable">$commission</span> = <span class="token-variable">$product</span>->store 
            ? <span class="token-variable">$product</span>->store-><span class="token-function">calculateCommission</span>(<span class="token-variable">$item</span>[<span class="token-string">'price'</span>]) 
            : <span class="token-number">0</span>;

        <span class="token-variable">$order</span>-><span class="token-function">items</span>()-><span class="token-function">create</span>([
            <span class="token-string">'product_id'</span> => <span class="token-variable">$product</span>->id,
            <span class="token-string">'store_id'</span> => <span class="token-variable">$product</span>->store_id,
            <span class="token-string">'product_name'</span> => <span class="token-variable">$product</span>->name,
            <span class="token-string">'unit_price'</span> => <span class="token-variable">$item</span>[<span class="token-string">'price'</span>],
            <span class="token-string">'total'</span> => <span class="token-variable">$item</span>[<span class="token-string">'price'</span>],
            <span class="token-string">'commission_amount'</span> => <span class="token-variable">$commission</span>,
            <span class="token-string">'vendor_amount'</span> => <span class="token-variable">$item</span>[<span class="token-string">'price'</span>] - <span class="token-variable">$commission</span>,
        ]);
    }

    <span class="token-function">session</span>()-><span class="token-function">forget</span>(<span class="token-string">'cart'</span>);

    <span class="token-keyword">return</span> <span class="token-function">redirect</span>()-><span class="token-function">route</span>(<span class="token-string">'orders.show'</span>, <span class="token-variable">$order</span>)
        -><span class="token-function">with</span>(<span class="token-string">'success'</span>, <span class="token-string">'Paiement réussi !'</span>);
}</code></pre>
            <button class="copy-btn">Copier</button>
        </div>
    </div>
</section>

<!-- ========== 5.4 DOWNLOAD ========== -->
<section id="seance5-download" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">5.4 Téléchargements après Paiement</h3>
    
    <div class="section-card">
        <div class="code-block-wrapper">
            <span class="code-lang">php</span>
            <pre class="code-block"><code><span class="token-comment">// Route sécurisée pour téléchargement</span>
Route::<span class="token-function">get</span>(<span class="token-string">'/download/{order}/{product}'</span>, <span class="token-keyword">function</span> (Order <span class="token-variable">$order</span>, Product <span class="token-variable">$product</span>) {
    <span class="token-comment">// Vérifier que l'utilisateur possède cette commande</span>
    <span class="token-keyword">if</span> (<span class="token-variable">$order</span>->user_id !== <span class="token-function">auth</span>()-><span class="token-function">id</span>()) {
        <span class="token-function">abort</span>(<span class="token-number">403</span>);
    }

    <span class="token-comment">// Vérifier que le produit fait partie de la commande</span>
    <span class="token-keyword">if</span> (!<span class="token-variable">$order</span>-><span class="token-function">items</span>()-><span class="token-function">where</span>(<span class="token-string">'product_id'</span>, <span class="token-variable">$product</span>->id)-><span class="token-function">exists</span>()) {
        <span class="token-function">abort</span>(<span class="token-number">404</span>);
    }

    <span class="token-comment">// Retourner le fichier</span>
    <span class="token-variable">$filePath</span> = <span class="token-variable">$product</span>-><span class="token-function">getFirstMediaPath</span>(<span class="token-string">'downloads'</span>);
    <span class="token-keyword">return</span> <span class="token-function">response</span>()-><span class="token-function">download</span>(<span class="token-variable">$filePath</span>);
})-><span class="token-function">middleware</span>(<span class="token-string">'auth'</span>)-><span class="token-function">name</span>(<span class="token-string">'download.product'</span>);</code></pre>
            <button class="copy-btn">Copier</button>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 5 !</strong> Vous avez maintenant un système de paiement complet 
        avec Stripe et PayPal, ainsi que les téléchargements sécurisés.
    </div>
</section>
