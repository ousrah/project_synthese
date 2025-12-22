<!-- =================================================================== -->
<!-- SÉANCE 9 : ADMINISTRATION -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-yellow-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-4 mr-3">Séance 9</span>
    Administration
</h2>

<!-- ========== 9.1 USERS ========== -->
<section id="seance9-admin-users" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">9.1 Gestion des Utilisateurs</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Rôle de l'administrateur</h4>
            <p class="text-gray-700 mb-4">
                L'administrateur gère l'ensemble de la plateforme : utilisateurs, produits, 
                commandes et paramètres globaux.
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Fonctionnalités admin :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li>Gérer les utilisateurs (rôles, bannissement)</li>
                    <li>Modérer les produits (approuver, rejeter)</li>
                    <li>Voir toutes les commandes</li>
                    <li>Configurer les paramètres (commission, etc.)</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Contrôleur Admin/UserController</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:controller Admin/UserController</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/Admin/UserController.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Http\Controllers\Admin</span>;

<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Controllers\Controller</span>;
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\User</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Http\Request</span>;

<span class="token-keyword">class</span> <span class="token-class-name">UserController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-keyword">public function</span> <span class="token-function">index</span>(Request <span class="token-variable">$request</span>)
    {
        <span class="token-variable">$query</span> = User::<span class="token-function">with</span>(<span class="token-string">'store'</span>);
        
        <span class="token-comment">// Filtre par rôle</span>
        <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'role'</span>)) {
            <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'role'</span>, <span class="token-variable">$request</span>->role);
        }
        
        <span class="token-comment">// Recherche</span>
        <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'search'</span>)) {
            <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'name'</span>, <span class="token-string">'like'</span>, <span class="token-string">'%'</span> . <span class="token-variable">$request</span>->search . <span class="token-string">'%'</span>)
                  -><span class="token-function">orWhere</span>(<span class="token-string">'email'</span>, <span class="token-string">'like'</span>, <span class="token-string">'%'</span> . <span class="token-variable">$request</span>->search . <span class="token-string">'%'</span>);
        }
        
        <span class="token-variable">$users</span> = <span class="token-variable">$query</span>-><span class="token-function">latest</span>()-><span class="token-function">paginate</span>(<span class="token-number">20</span>);
        
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'admin.users.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'users'</span>));
    }

    <span class="token-keyword">public function</span> <span class="token-function">updateRole</span>(Request <span class="token-variable">$request</span>, User <span class="token-variable">$user</span>)
    {
        <span class="token-variable">$request</span>-><span class="token-function">validate</span>([
            <span class="token-string">'role'</span> => <span class="token-string">'required|in:customer,vendor,admin'</span>
        ]);
        
        <span class="token-variable">$user</span>-><span class="token-function">update</span>([<span class="token-string">'role'</span> => <span class="token-variable">$request</span>->role]);
        
        <span class="token-keyword">return</span> <span class="token-function">back</span>()-><span class="token-function">with</span>(<span class="token-string">'success'</span>, <span class="token-string">"Rôle de {$user->name} mis à jour."</span>);
    }
    
    <span class="token-keyword">public function</span> <span class="token-function">destroy</span>(User <span class="token-variable">$user</span>)
    {
        <span class="token-comment">// Empêcher la suppression de son propre compte</span>
        <span class="token-keyword">if</span> (<span class="token-variable">$user</span>->id === <span class="token-function">auth</span>()-><span class="token-function">id</span>()) {
            <span class="token-keyword">return</span> <span class="token-function">back</span>()-><span class="token-function">with</span>(<span class="token-string">'error'</span>, <span class="token-string">'Vous ne pouvez pas supprimer votre propre compte.'</span>);
        }
        
        <span class="token-variable">$user</span>-><span class="token-function">delete</span>();
        
        <span class="token-keyword">return</span> <span class="token-function">back</span>()-><span class="token-function">with</span>(<span class="token-string">'success'</span>, <span class="token-string">'Utilisateur supprimé.'</span>);
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Vue liste des utilisateurs</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/admin/users/index.blade.php --&gt;</span>

&lt;table class="table table-striped"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th&gt;ID&lt;/th&gt;
            &lt;th&gt;Nom&lt;/th&gt;
            &lt;th&gt;Email&lt;/th&gt;
            &lt;th&gt;Rôle&lt;/th&gt;
            &lt;th&gt;Boutique&lt;/th&gt;
            &lt;th&gt;Actions&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
        <span class="token-blade">@foreach($users as $user)</span>
        &lt;tr&gt;
            &lt;td&gt;<span class="token-blade">{{ $user->id }}</span>&lt;/td&gt;
            &lt;td&gt;<span class="token-blade">{{ $user->name }}</span>&lt;/td&gt;
            &lt;td&gt;<span class="token-blade">{{ $user->email }}</span>&lt;/td&gt;
            &lt;td&gt;
                &lt;form action="<span class="token-blade">{{ route('admin.users.role', $user) }}</span>" method="POST" class="d-inline"&gt;
                    <span class="token-blade">@csrf</span>
                    <span class="token-blade">@method('PATCH')</span>
                    &lt;select name="role" onchange="this.form.submit()" class="form-select form-select-sm"&gt;
                        &lt;option value="customer" <span class="token-blade">{{ $user->role == 'customer' ? 'selected' : '' }}</span>&gt;Client&lt;/option&gt;
                        &lt;option value="vendor" <span class="token-blade">{{ $user->role == 'vendor' ? 'selected' : '' }}</span>&gt;Vendeur&lt;/option&gt;
                        &lt;option value="admin" <span class="token-blade">{{ $user->role == 'admin' ? 'selected' : '' }}</span>&gt;Admin&lt;/option&gt;
                    &lt;/select&gt;
                &lt;/form&gt;
            &lt;/td&gt;
            &lt;td&gt;<span class="token-blade">{{ $user->store?->name ?? '-' }}</span>&lt;/td&gt;
            &lt;td&gt;
                &lt;form action="<span class="token-blade">{{ route('admin.users.destroy', $user) }}</span>" method="POST" 
                      onsubmit="return confirm('Supprimer cet utilisateur ?')"&gt;
                    <span class="token-blade">@csrf</span>
                    <span class="token-blade">@method('DELETE')</span>
                    &lt;button class="btn btn-danger btn-sm"&gt;&lt;i class="bi bi-trash"&gt;&lt;/i&gt;&lt;/button&gt;
                &lt;/form&gt;
            &lt;/td&gt;
        &lt;/tr&gt;
        <span class="token-blade">@endforeach</span>
    &lt;/tbody&gt;
&lt;/table&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 9.2 PRODUITS ========== -->
<section id="seance9-admin-products" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">9.2 Modération des Produits</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Système de modération</h4>
            <p class="text-gray-700 mb-4">
                L'administrateur peut approuver, rejeter ou mettre en avant les produits soumis par les vendeurs.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/Admin/ProductController.php</span>

<span class="token-keyword">public function</span> <span class="token-function">index</span>(Request <span class="token-variable">$request</span>)
{
    <span class="token-variable">$query</span> = Product::<span class="token-function">with</span>([<span class="token-string">'category'</span>, <span class="token-string">'store'</span>]);
    
    <span class="token-comment">// Filtre par statut</span>
    <span class="token-keyword">if</span> (<span class="token-variable">$request</span>->status === <span class="token-string">'pending'</span>) {
        <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">false</span>);
    } <span class="token-keyword">elseif</span> (<span class="token-variable">$request</span>->status === <span class="token-string">'active'</span>) {
        <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>);
    }
    
    <span class="token-variable">$products</span> = <span class="token-variable">$query</span>-><span class="token-function">latest</span>()-><span class="token-function">paginate</span>(<span class="token-number">20</span>);
    
    <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'admin.products.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'products'</span>));
}

<span class="token-keyword">public function</span> <span class="token-function">toggleActive</span>(Product <span class="token-variable">$product</span>)
{
    <span class="token-variable">$product</span>-><span class="token-function">update</span>([<span class="token-string">'is_active'</span> => !<span class="token-variable">$product</span>->is_active]);
    
    <span class="token-variable">$status</span> = <span class="token-variable">$product</span>->is_active ? <span class="token-string">'activé'</span> : <span class="token-string">'désactivé'</span>;
    <span class="token-keyword">return</span> <span class="token-function">back</span>()-><span class="token-function">with</span>(<span class="token-string">'success'</span>, <span class="token-string">"Produit {$status}."</span>);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 9.3 COMMANDES ========== -->
<section id="seance9-admin-orders" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">9.3 Gestion des Commandes</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Vue globale des commandes</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/Admin/OrderController.php</span>

<span class="token-keyword">public function</span> <span class="token-function">index</span>(Request <span class="token-variable">$request</span>)
{
    <span class="token-variable">$query</span> = Order::<span class="token-function">with</span>([<span class="token-string">'user'</span>, <span class="token-string">'items.product'</span>]);
    
    <span class="token-comment">// Filtre par statut</span>
    <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'status'</span>)) {
        <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'status'</span>, <span class="token-variable">$request</span>->status);
    }
    
    <span class="token-comment">// Filtre par date</span>
    <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'from'</span>)) {
        <span class="token-variable">$query</span>-><span class="token-function">whereDate</span>(<span class="token-string">'created_at'</span>, <span class="token-string">'>='</span>, <span class="token-variable">$request</span>->from);
    }
    <span class="token-keyword">if</span> (<span class="token-variable">$request</span>-><span class="token-function">filled</span>(<span class="token-string">'to'</span>)) {
        <span class="token-variable">$query</span>-><span class="token-function">whereDate</span>(<span class="token-string">'created_at'</span>, <span class="token-string">'<='</span>, <span class="token-variable">$request</span>->to);
    }
    
    <span class="token-variable">$orders</span> = <span class="token-variable">$query</span>-><span class="token-function">latest</span>()-><span class="token-function">paginate</span>(<span class="token-number">20</span>);
    
    <span class="token-comment">// Statistiques rapides</span>
    <span class="token-variable">$stats</span> = [
        <span class="token-string">'total'</span> => Order::<span class="token-function">sum</span>(<span class="token-string">'total'</span>),
        <span class="token-string">'count'</span> => Order::<span class="token-function">count</span>(),
        <span class="token-string">'pending'</span> => Order::<span class="token-function">where</span>(<span class="token-string">'status'</span>, <span class="token-string">'pending'</span>)-><span class="token-function">count</span>(),
    ];
    
    <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'admin.orders.index'</span>, <span class="token-function">compact</span>(<span class="token-string">'orders'</span>, <span class="token-string">'stats'</span>));
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 9.4 PARAMÈTRES ========== -->
<section id="seance9-admin-settings" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">9.4 Paramètres Généraux</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Fichier de configuration</h4>
            <p class="text-gray-700 mb-4">
                Les paramètres globaux peuvent être stockés dans un fichier de config ou en base de données.
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// config/marketplace.php</span>

<span class="token-keyword">return</span> [
    <span class="token-comment">// Taux de commission par défaut (%)</span>
    <span class="token-string">'default_commission_rate'</span> => <span class="token-function">env</span>(<span class="token-string">'MARKETPLACE_COMMISSION'</span>, <span class="token-number">10</span>),
    
    <span class="token-comment">// Devise</span>
    <span class="token-string">'currency'</span> => <span class="token-string">'EUR'</span>,
    <span class="token-string">'currency_symbol'</span> => <span class="token-string">'€'</span>,
    
    <span class="token-comment">// Montant minimum pour retrait vendeur</span>
    <span class="token-string">'min_payout_amount'</span> => <span class="token-number">50</span>,
    
    <span class="token-comment">// Produits par page</span>
    <span class="token-string">'products_per_page'</span> => <span class="token-number">12</span>,
];</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Utilisation :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>config('marketplace.default_commission_rate')</code> → 10</li>
                    <li><code>config('marketplace.currency_symbol')</code> → €</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Routes admin groupées</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// routes/web.php</span>

Route::<span class="token-function">prefix</span>(<span class="token-string">'admin'</span>)
    -><span class="token-function">middleware</span>([<span class="token-string">'auth'</span>, <span class="token-string">'admin'</span>])
    -><span class="token-function">name</span>(<span class="token-string">'admin.'</span>)
    -><span class="token-function">group</span>(<span class="token-keyword">function</span> () {
        Route::<span class="token-function">get</span>(<span class="token-string">'/dashboard'</span>, [AdminController::<span class="token-keyword">class</span>, <span class="token-string">'dashboard'</span>])-><span class="token-function">name</span>(<span class="token-string">'dashboard'</span>);
        
        <span class="token-comment">// Utilisateurs</span>
        Route::<span class="token-function">get</span>(<span class="token-string">'/users'</span>, [Admin\UserController::<span class="token-keyword">class</span>, <span class="token-string">'index'</span>])-><span class="token-function">name</span>(<span class="token-string">'users.index'</span>);
        Route::<span class="token-function">patch</span>(<span class="token-string">'/users/{user}/role'</span>, [Admin\UserController::<span class="token-keyword">class</span>, <span class="token-string">'updateRole'</span>])-><span class="token-function">name</span>(<span class="token-string">'users.role'</span>);
        Route::<span class="token-function">delete</span>(<span class="token-string">'/users/{user}'</span>, [Admin\UserController::<span class="token-keyword">class</span>, <span class="token-string">'destroy'</span>])-><span class="token-function">name</span>(<span class="token-string">'users.destroy'</span>);
        
        <span class="token-comment">// Produits</span>
        Route::<span class="token-function">get</span>(<span class="token-string">'/products'</span>, [Admin\ProductController::<span class="token-keyword">class</span>, <span class="token-string">'index'</span>])-><span class="token-function">name</span>(<span class="token-string">'products.index'</span>);
        Route::<span class="token-function">patch</span>(<span class="token-string">'/products/{product}/toggle'</span>, [Admin\ProductController::<span class="token-keyword">class</span>, <span class="token-string">'toggleActive'</span>])-><span class="token-function">name</span>(<span class="token-string">'products.toggle'</span>);
        
        <span class="token-comment">// Commandes</span>
        Route::<span class="token-function">get</span>(<span class="token-string">'/orders'</span>, [Admin\OrderController::<span class="token-keyword">class</span>, <span class="token-string">'index'</span>])-><span class="token-function">name</span>(<span class="token-string">'orders.index'</span>);
        Route::<span class="token-function">get</span>(<span class="token-string">'/orders/{order}'</span>, [Admin\OrderController::<span class="token-keyword">class</span>, <span class="token-string">'show'</span>])-><span class="token-function">name</span>(<span class="token-string">'orders.show'</span>);
    });</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 9 !</strong> Votre interface d'administration est prête 
        avec la gestion des utilisateurs, produits et commandes.
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>
