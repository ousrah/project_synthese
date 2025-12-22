<!-- =================================================================== -->
<!-- SÉANCE 8 : DASHBOARD VENDEUR COMPLET -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-green-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-3 mr-3">Séance 8</span>
    Dashboard Vendeur Complet
</h2>

<!-- ========== 8.1 VENTES ========== -->
<section id="seance8-sales" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">8.1 Vue des Ventes Vendeur</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Objectif du dashboard vendeur</h4>
            <p class="text-gray-700 mb-4">
                Le vendeur doit pouvoir voir ses ventes, ses statistiques et gérer ses produits 
                depuis un espace dédié. C'est le cœur de l'expérience vendeur.
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Fonctionnalités essentielles :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li>Liste des ventes récentes</li>
                    <li>Statistiques (CA, nombre de ventes, etc.)</li>
                    <li>Solde disponible pour retrait</li>
                    <li>Gestion des produits</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Route et contrôleur des ventes</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// routes/web.php</span>

Route::<span class="token-function">prefix</span>(<span class="token-string">'vendor'</span>)-><span class="token-function">middleware</span>([<span class="token-string">'auth'</span>, <span class="token-string">'vendor'</span>])-><span class="token-function">name</span>(<span class="token-string">'vendor.'</span>)-><span class="token-function">group</span>(<span class="token-keyword">function</span> () {
    Route::<span class="token-function">get</span>(<span class="token-string">'/sales'</span>, <span class="token-keyword">function</span> () {
        <span class="token-variable">$store</span> = <span class="token-function">auth</span>()-><span class="token-function">user</span>()->store;
        
        <span class="token-comment">// Récupérer les ventes (OrderItems de cette boutique)</span>
        <span class="token-variable">$sales</span> = OrderItem::<span class="token-function">where</span>(<span class="token-string">'store_id'</span>, <span class="token-variable">$store</span>->id)
            -><span class="token-function">with</span>([<span class="token-string">'order.user'</span>, <span class="token-string">'product'</span>])
            -><span class="token-function">latest</span>()
            -><span class="token-function">paginate</span>(<span class="token-number">20</span>);

        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'vendor.sales.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'sales'</span>, <span class="token-string">'store'</span>));
    })-><span class="token-function">name</span>(<span class="token-string">'sales'</span>);
});</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Explication :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>OrderItem</code> contient chaque ligne de commande avec <code>store_id</code></li>
                    <li><code>with(['order.user', 'product'])</code> : Eager loading pour éviter N+1</li>
                    <li>On récupère le client via <code>order.user</code></li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Vue des ventes</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/vendor/sales/index.blade.php --&gt;</span>

&lt;x-layouts.app title="Mes Ventes"&gt;
    &lt;div class="container py-5"&gt;
        &lt;h1 class="mb-4"&gt;&lt;i class="bi bi-receipt me-2"&gt;&lt;/i&gt;Mes Ventes&lt;/h1&gt;
        
        &lt;div class="table-responsive"&gt;
            &lt;table class="table table-striped"&gt;
                &lt;thead&gt;
                    &lt;tr&gt;
                        &lt;th&gt;Date&lt;/th&gt;
                        &lt;th&gt;Commande&lt;/th&gt;
                        &lt;th&gt;Client&lt;/th&gt;
                        &lt;th&gt;Produit&lt;/th&gt;
                        &lt;th&gt;Prix&lt;/th&gt;
                        &lt;th&gt;Votre gain&lt;/th&gt;
                    &lt;/tr&gt;
                &lt;/thead&gt;
                &lt;tbody&gt;
                    <span class="token-blade">@foreach($sales as $sale)</span>
                    &lt;tr&gt;
                        &lt;td&gt;<span class="token-blade">{{ $sale->created_at->format('d/m/Y') }}</span>&lt;/td&gt;
                        &lt;td&gt;<span class="token-blade">{{ $sale->order->order_number }}</span>&lt;/td&gt;
                        &lt;td&gt;<span class="token-blade">{{ $sale->order->user->name }}</span>&lt;/td&gt;
                        &lt;td&gt;<span class="token-blade">{{ $sale->product_name }}</span>&lt;/td&gt;
                        &lt;td&gt;<span class="token-blade">{{ number_format($sale->total, 2) }}</span> €&lt;/td&gt;
                        &lt;td class="text-success fw-bold"&gt;
                            <span class="token-blade">{{ number_format($sale->vendor_amount, 2) }}</span> €
                        &lt;/td&gt;
                    &lt;/tr&gt;
                    <span class="token-blade">@endforeach</span>
                &lt;/tbody&gt;
            &lt;/table&gt;
        &lt;/div&gt;
        
        <span class="token-blade">{{ $sales->links() }}</span>
    &lt;/div&gt;
&lt;/x-layouts.app&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 8.2 STATISTIQUES ========== -->
<section id="seance8-stats" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">8.2 Statistiques & Graphiques</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Calculer les statistiques</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Dans le contrôleur du dashboard vendeur</span>

<span class="token-variable">$store</span> = <span class="token-function">auth</span>()-><span class="token-function">user</span>()->store;

<span class="token-variable">$stats</span> = [
    <span class="token-comment">// Revenus totaux (après commission)</span>
    <span class="token-string">'total_earnings'</span> => OrderItem::<span class="token-function">where</span>(<span class="token-string">'store_id'</span>, <span class="token-variable">$store</span>->id)
        -><span class="token-function">sum</span>(<span class="token-string">'vendor_amount'</span>),
    
    <span class="token-comment">// Nombre de ventes</span>
    <span class="token-string">'total_sales'</span> => OrderItem::<span class="token-function">where</span>(<span class="token-string">'store_id'</span>, <span class="token-variable">$store</span>->id)
        -><span class="token-function">count</span>(),
    
    <span class="token-comment">// Nombre de produits</span>
    <span class="token-string">'products_count'</span> => <span class="token-variable">$store</span>-><span class="token-function">products</span>()-><span class="token-function">count</span>(),
    
    <span class="token-comment">// Ventes ce mois</span>
    <span class="token-string">'this_month'</span> => OrderItem::<span class="token-function">where</span>(<span class="token-string">'store_id'</span>, <span class="token-variable">$store</span>->id)
        -><span class="token-function">whereMonth</span>(<span class="token-string">'created_at'</span>, <span class="token-function">now</span>()->month)
        -><span class="token-function">whereYear</span>(<span class="token-string">'created_at'</span>, <span class="token-function">now</span>()->year)
        -><span class="token-function">sum</span>(<span class="token-string">'vendor_amount'</span>),
    
    <span class="token-comment">// Commandes en attente (à traiter)</span>
    <span class="token-string">'pending_orders'</span> => OrderItem::<span class="token-function">where</span>(<span class="token-string">'store_id'</span>, <span class="token-variable">$store</span>->id)
        -><span class="token-function">whereHas</span>(<span class="token-string">'order'</span>, <span class="token-keyword">fn</span>(<span class="token-variable">$q</span>) => <span class="token-variable">$q</span>-><span class="token-function">where</span>(<span class="token-string">'status'</span>, <span class="token-string">'pending'</span>))
        -><span class="token-function">count</span>(),
];</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Affichage des cartes statistiques</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- Dashboard vendeur --&gt;</span>

&lt;div class="row g-4 mb-5"&gt;
    &lt;div class="col-md-3"&gt;
        &lt;div class="card bg-primary text-white"&gt;
            &lt;div class="card-body text-center"&gt;
                &lt;i class="bi bi-currency-euro fs-1"&gt;&lt;/i&gt;
                &lt;h3&gt;<span class="token-blade">{{ number_format($stats['total_earnings'], 2) }}</span> €&lt;/h3&gt;
                &lt;p class="mb-0"&gt;Revenus totaux&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    
    &lt;div class="col-md-3"&gt;
        &lt;div class="card bg-success text-white"&gt;
            &lt;div class="card-body text-center"&gt;
                &lt;i class="bi bi-graph-up fs-1"&gt;&lt;/i&gt;
                &lt;h3&gt;<span class="token-blade">{{ number_format($stats['this_month'], 2) }}</span> €&lt;/h3&gt;
                &lt;p class="mb-0"&gt;Ce mois-ci&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    
    &lt;div class="col-md-3"&gt;
        &lt;div class="card bg-info text-white"&gt;
            &lt;div class="card-body text-center"&gt;
                &lt;i class="bi bi-bag-check fs-1"&gt;&lt;/i&gt;
                &lt;h3&gt;<span class="token-blade">{{ $stats['total_sales'] }}</span>&lt;/h3&gt;
                &lt;p class="mb-0"&gt;Ventes totales&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    
    &lt;div class="col-md-3"&gt;
        &lt;div class="card bg-warning text-dark"&gt;
            &lt;div class="card-body text-center"&gt;
                &lt;i class="bi bi-box-seam fs-1"&gt;&lt;/i&gt;
                &lt;h3&gt;<span class="token-blade">{{ $stats['products_count'] }}</span>&lt;/h3&gt;
                &lt;p class="mb-0"&gt;Produits actifs&lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 8.3 PAYOUTS ========== -->
<section id="seance8-payouts" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">8.3 Système de Paiement Vendeur (Payouts)</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Concept des payouts</h4>
            
            <div class="alert-info">
                <strong>📖 Comment ça fonctionne :</strong>
                <ol class="list-decimal ml-6 mt-2 text-sm">
                    <li>Les ventes s'accumulent dans <code>vendor_amount</code> de chaque OrderItem</li>
                    <li>Le vendeur peut voir son solde total</li>
                    <li>Quand il clique "Demander un virement", une demande de payout est créée</li>
                    <li>L'admin valide et effectue le virement (manuellement ou via Stripe Connect)</li>
                </ol>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Calcul du solde disponible</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Calculer le solde disponible pour retrait</span>

<span class="token-variable">$totalEarnings</span> = OrderItem::<span class="token-function">where</span>(<span class="token-string">'store_id'</span>, <span class="token-variable">$store</span>->id)
    -><span class="token-function">whereHas</span>(<span class="token-string">'order'</span>, <span class="token-keyword">fn</span>(<span class="token-variable">$q</span>) => <span class="token-variable">$q</span>-><span class="token-function">where</span>(<span class="token-string">'payment_status'</span>, <span class="token-string">'paid'</span>))
    -><span class="token-function">sum</span>(<span class="token-string">'vendor_amount'</span>);

<span class="token-comment">// Moins les payouts déjà effectués</span>
<span class="token-variable">$totalPaidOut</span> = Payout::<span class="token-function">where</span>(<span class="token-string">'store_id'</span>, <span class="token-variable">$store</span>->id)
    -><span class="token-function">where</span>(<span class="token-string">'status'</span>, <span class="token-string">'completed'</span>)
    -><span class="token-function">sum</span>(<span class="token-string">'amount'</span>);

<span class="token-variable">$availableBalance</span> = <span class="token-variable">$totalEarnings</span> - <span class="token-variable">$totalPaidOut</span>;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 8.4 PRODUITS ========== -->
<section id="seance8-products" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">8.4 Gestion Complète des Produits</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Menu latéral du dashboard vendeur</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- Composant menu vendeur --&gt;</span>

&lt;div class="list-group"&gt;
    &lt;a href="<span class="token-blade">{{ route('vendor.dashboard') }}</span>" 
       class="list-group-item list-group-item-action <span class="token-blade">{{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}</span>"&gt;
        &lt;i class="bi bi-speedometer2 me-2"&gt;&lt;/i&gt; Dashboard
    &lt;/a&gt;
    &lt;a href="<span class="token-blade">{{ route('vendor.products.index') }}</span>" 
       class="list-group-item list-group-item-action <span class="token-blade">{{ request()->routeIs('vendor.products.*') ? 'active' : '' }}</span>"&gt;
        &lt;i class="bi bi-box-seam me-2"&gt;&lt;/i&gt; Mes Produits
    &lt;/a&gt;
    &lt;a href="<span class="token-blade">{{ route('vendor.sales') }}</span>" 
       class="list-group-item list-group-item-action"&gt;
        &lt;i class="bi bi-receipt me-2"&gt;&lt;/i&gt; Mes Ventes
    &lt;/a&gt;
    &lt;a href="<span class="token-blade">{{ route('vendor.store.edit') }}</span>" 
       class="list-group-item list-group-item-action"&gt;
        &lt;i class="bi bi-shop me-2"&gt;&lt;/i&gt; Ma Boutique
    &lt;/a&gt;
&lt;/div&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">CRUD complet des produits</h4>
            <p class="text-gray-700 mb-4">
                Le ProductController vendeur (créé en séance 3) gère toutes les opérations CRUD. 
                N'oubliez pas d'ajouter les méthodes <code>edit</code>, <code>update</code> et <code>destroy</code>.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// Routes ressource pour les produits vendeur</span>

Route::<span class="token-function">resource</span>(<span class="token-string">'products'</span>, Vendor\ProductController::<span class="token-keyword">class</span>)
    -><span class="token-function">except</span>([<span class="token-string">'show'</span>]);</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 8 !</strong> Le dashboard vendeur est maintenant complet avec 
        statistiques, ventes et gestion des produits.
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>
