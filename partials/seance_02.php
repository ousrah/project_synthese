<!-- =================================================================== -->
<!-- SÉANCE 2 : AUTHENTIFICATION & RÔLES -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-4 border-pink-500 pb-2 mb-6 mt-16">
    <span class="badge-seance badge-seance-2 mr-3">Séance 2</span>
    Authentification & Rôles
</h2>

<!-- ========== 2.1 BREEZE ========== -->
<section id="seance2-breeze" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">2.1 Installation de Laravel Breeze</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Qu'est-ce que Laravel Breeze ?</h4>
            <p class="text-gray-700 mb-4">
                <strong>Laravel Breeze</strong> est un kit d'authentification minimal qui fournit toutes les fonctionnalités 
                de base : inscription, connexion, réinitialisation de mot de passe, et vérification email. 
                C'est beaucoup plus simple que de coder ces fonctionnalités manuellement !
            </p>
            
            <div class="alert-info mb-4">
                <strong>💡 Pourquoi Breeze et pas Jetstream ?</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><strong>Breeze</strong> : Minimaliste, facile à personnaliser, parfait pour les débutants</li>
                    <li><strong>Jetstream</strong> : Plus complet (teams, 2FA), mais plus complexe à modifier</li>
                </ul>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Installer Breeze avec Blade</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Installer Breeze</span>
composer require laravel/breeze --dev

<span class="token-comment"># Installer Breeze avec Blade</span>
php artisan breeze:install blade

<span class="token-comment"># Installer les dépendances et compiler</span>
npm install
npm run build

<span class="token-comment"># Exécuter les migrations</span>
php artisan migrate</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-info mt-4">
                <strong>📖 Ce que Breeze génère :</strong>
                <ul class="list-disc ml-6 mt-2 text-sm">
                    <li><code>resources/views/auth/</code> : Vues login, register, forgot-password, etc.</li>
                    <li><code>app/Http/Controllers/Auth/</code> : Contrôleurs d'authentification</li>
                    <li><code>routes/auth.php</code> : Routes d'authentification (login, logout, register...)</li>
                    <li><code>resources/views/layouts/</code> : Layouts pour les pages auth et dashboard</li>
                </ul>
            </div>
            
            <div class="alert-success mt-4">
                <strong>✅ Résultat :</strong> Visitez <code>/login</code>, <code>/register</code>, et <code>/dashboard</code> 
                pour voir les pages d'authentification fonctionnelles !
            </div>
        </div>
    </div>
</section>

<!-- ========== 2.2 RÔLES ========== -->
<section id="seance2-roles" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">2.2 Système de Rôles (Admin, Vendor, Customer)</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Ajouter le champ role à la table users</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:migration add_role_to_users_table</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/migrations/xxxx_add_role_to_users_table.php</span>

<span class="token-keyword">public function</span> <span class="token-function">up</span>(): <span class="token-keyword">void</span>
{
    Schema::<span class="token-function">table</span>(<span class="token-string">'users'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
        <span class="token-variable">$table</span>-><span class="token-function">enum</span>(<span class="token-string">'role'</span>, [<span class="token-string">'admin'</span>, <span class="token-string">'vendor'</span>, <span class="token-string">'customer'</span>])
              -><span class="token-function">default</span>(<span class="token-string">'customer'</span>)
              -><span class="token-function">after</span>(<span class="token-string">'email'</span>);
    });
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Modifier le modèle User</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Models/User.php</span>

<span class="token-keyword">protected</span> <span class="token-variable">$fillable</span> = [
    <span class="token-string">'name'</span>,
    <span class="token-string">'email'</span>,
    <span class="token-string">'password'</span>,
    <span class="token-string">'role'</span>, <span class="token-comment">// Ajouter ce champ</span>
];

<span class="token-comment">// Ajouter ces méthodes pour vérifier les rôles</span>
<span class="token-keyword">public function</span> <span class="token-function">isAdmin</span>(): <span class="token-keyword">bool</span>
{
    <span class="token-keyword">return</span> <span class="token-variable">$this</span>->role === <span class="token-string">'admin'</span>;
}

<span class="token-keyword">public function</span> <span class="token-function">isVendor</span>(): <span class="token-keyword">bool</span>
{
    <span class="token-keyword">return</span> <span class="token-variable">$this</span>->role === <span class="token-string">'vendor'</span>;
}

<span class="token-keyword">public function</span> <span class="token-function">isCustomer</span>(): <span class="token-keyword">bool</span>
{
    <span class="token-keyword">return</span> <span class="token-variable">$this</span>->role === <span class="token-string">'customer'</span>;
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer un UserSeeder</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/seeders/UserSeeder.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">App\Models\User</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Facades\Hash</span>;

<span class="token-keyword">public function</span> <span class="token-function">run</span>(): <span class="token-keyword">void</span>
{
    <span class="token-comment">// Admin</span>
    User::<span class="token-function">create</span>([
        <span class="token-string">'name'</span> => <span class="token-string">'Admin'</span>,
        <span class="token-string">'email'</span> => <span class="token-string">'admin@boutique.com'</span>,
        <span class="token-string">'password'</span> => Hash::<span class="token-function">make</span>(<span class="token-string">'password'</span>),
        <span class="token-string">'role'</span> => <span class="token-string">'admin'</span>,
    ]);

    <span class="token-comment">// Vendeur</span>
    User::<span class="token-function">create</span>([
        <span class="token-string">'name'</span> => <span class="token-string">'Vendeur Test'</span>,
        <span class="token-string">'email'</span> => <span class="token-string">'vendor@boutique.com'</span>,
        <span class="token-string">'password'</span> => Hash::<span class="token-function">make</span>(<span class="token-string">'password'</span>),
        <span class="token-string">'role'</span> => <span class="token-string">'vendor'</span>,
    ]);

    <span class="token-comment">// Client</span>
    User::<span class="token-function">create</span>([
        <span class="token-string">'name'</span> => <span class="token-string">'Client Test'</span>,
        <span class="token-string">'email'</span> => <span class="token-string">'client@boutique.com'</span>,
        <span class="token-string">'password'</span> => Hash::<span class="token-function">make</span>(<span class="token-string">'password'</span>),
        <span class="token-string">'role'</span> => <span class="token-string">'customer'</span>,
    ]);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Appeler le Seeder dans DatabaseSeeder</h4>
            <p class="text-gray-700 mb-4">
                N'oubliez pas d'enregistrer votre seeder dans le fichier principal <code>DatabaseSeeder.php</code> :
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// database/seeders/DatabaseSeeder.php</span>

<span class="token-keyword">public function</span> <span class="token-function">run</span>(): <span class="token-keyword">void</span>
{
    <span class="token-variable">$this</span>-><span class="token-function">call</span>([
        UserSeeder::<span class="token-keyword">class</span>,
        <span class="token-comment">// ... autres seeders plus tard</span>
    ]);
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">🚀 Appliquer les changements</h4>
            <p class="text-gray-700 mb-4">
                Maintenant que tout est prêt, exécutez la migration pour modifier la table utilisateurs, puis lancez les seeders pour créer les comptes de test :
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code><span class="token-comment"># Exécuter la migration (ajoute la colonne role)</span>
php artisan migrate

<span class="token-comment"># Lancer les seeders (crée les users test)</span>
php artisan db:seed --class=UserSeeder</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="alert-success mt-4">
                <strong>💡 Astuce :</strong> Si vous voulez repartir de zéro (supprimer toutes les données et recréer), utilisez :
                <br><code>php artisan migrate:fresh --seed</code>
            </div>
        </div>
    </div>
</section>

<!-- ========== 2.3 MIDDLEWARES ========== -->
<section id="seance2-middleware" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">2.3 Middlewares de Protection des Routes</h3>
    
    <div class="section-card space-y-6">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Qu'est-ce qu'un Middleware ?</h4>
            <p class="text-gray-700 mb-4">
                Un <strong>middleware</strong> est un filtre qui s'exécute avant (ou après) chaque requête HTTP. 
                Il permet de vérifier des conditions avant d'accéder à une route : l'utilisateur est-il connecté ? 
                Est-il admin ? A-t-il le droit d'accéder à cette page ?
            </p>
            
            <div class="alert-info mb-4">
                <strong>📖 Flux d'une requête avec middleware :</strong>
                <pre class="text-sm mt-2">Requête HTTP → Middleware Auth → Middleware Admin → Controller → Réponse</pre>
                <p class="text-sm mt-2">Si le middleware refuse l'accès, la requête s'arrête et l'utilisateur reçoit une erreur 403.</p>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer les middlewares de rôle</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">bash</span>
                <pre class="code-block"><code>php artisan make:middleware EnsureUserIsAdmin
php artisan make:middleware EnsureUserIsVendor</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <div class="code-block-wrapper mt-4">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Middleware/EnsureUserIsAdmin.php</span>

<span class="token-preprocessor">&lt;?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Http\Middleware</span>;

<span class="token-keyword">use</span> <span class="token-class-name">Closure</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Http\Request</span>;

<span class="token-keyword">class</span> <span class="token-class-name">EnsureUserIsAdmin</span>
{
    <span class="token-keyword">public function</span> <span class="token-function">handle</span>(Request <span class="token-variable">$request</span>, Closure <span class="token-variable">$next</span>)
    {
        <span class="token-keyword">if</span> (!<span class="token-function">auth</span>()-><span class="token-function">check</span>() || !<span class="token-function">auth</span>()-><span class="token-function">user</span>()-><span class="token-function">isAdmin</span>()) {
            <span class="token-function">abort</span>(<span class="token-number">403</span>, <span class="token-string">'Accès réservé aux administrateurs.'</span>);
        }

        <span class="token-keyword">return</span> <span class="token-variable">$next</span>(<span class="token-variable">$request</span>);
    }
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Enregistrer les middlewares</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// bootstrap/app.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Middleware\EnsureUserIsAdmin</span>;
<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Middleware\EnsureUserIsVendor</span>;

<span class="token-keyword">return</span> Application::<span class="token-function">configure</span>(basePath: <span class="token-function">dirname</span>(__DIR__))
    -><span class="token-function">withMiddleware</span>(<span class="token-keyword">function</span> (Middleware <span class="token-variable">$middleware</span>) {
        <span class="token-variable">$middleware</span>-><span class="token-function">alias</span>([
            <span class="token-string">'admin'</span> => EnsureUserIsAdmin::<span class="token-keyword">class</span>,
            <span class="token-string">'vendor'</span> => EnsureUserIsVendor::<span class="token-keyword">class</span>,
        ]);
    })
    -><span class="token-function">create</span>();</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
</section>

<!-- ========== 2.4 DASHBOARDS ========== -->
<section id="seance2-dashboards" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">2.4 Création des Dashboards par Rôle</h3>
    
    <div class="section-card space-y-6">
        <div>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Configurer la redirection après login</h4>
            <p class="text-gray-700 mb-4">
                Par défaut, Breeze redirige tout le monde vers <code>/dashboard</code>. Pour rediriger selon le rôle, modifiez le contrôleur de session :
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// app/Http/Controllers/Auth/AuthenticatedSessionController.php</span>

<span class="token-keyword">public function</span> <span class="token-function">store</span>(LoginRequest <span class="token-variable">$request</span>): RedirectResponse
{
    <span class="token-variable">$request</span>-><span class="token-function">authenticate</span>();
    <span class="token-variable">$request</span>-><span class="token-function">session</span>()-><span class="token-function">regenerate</span>();

    <span class="token-comment">// Redirection basée sur le rôle</span>
    <span class="token-variable">$role</span> = <span class="token-variable">$request</span>-><span class="token-function">user</span>()->role;

    <span class="token-keyword">if</span> (<span class="token-variable">$role</span> === <span class="token-string">'admin'</span>) {
        <span class="token-keyword">return</span> <span class="token-function">redirect</span>()-><span class="token-function">route</span>(<span class="token-string">'admin.dashboard'</span>);
    } <span class="token-keyword">elseif</span> (<span class="token-variable">$role</span> === <span class="token-string">'vendor'</span>) {
        <span class="token-keyword">return</span> <span class="token-function">redirect</span>()-><span class="token-function">route</span>(<span class="token-string">'vendor.dashboard'</span>);
    }

    <span class="token-keyword">return</span> <span class="token-function">redirect</span>()-><span class="token-function">intended</span>(<span class="token-function">route</span>(<span class="token-string">'dashboard'</span>, absolute: <span class="token-keyword">false</span>));
}</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Définir les routes protégées</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">php</span>
                <pre class="code-block"><code><span class="token-comment">// routes/web.php</span>

<span class="token-comment">// Routes Admin</span>
Route::<span class="token-function">prefix</span>(<span class="token-string">'admin'</span>)-><span class="token-function">middleware</span>([<span class="token-string">'auth'</span>, <span class="token-string">'verified'</span>, <span class="token-string">'admin'</span>])-><span class="token-function">name</span>(<span class="token-string">'admin.'</span>)-><span class="token-function">group</span>(<span class="token-keyword">function</span> () {
    Route::<span class="token-function">get</span>(<span class="token-string">'/dashboard'</span>, <span class="token-keyword">fn</span>() => <span class="token-function">view</span>(<span class="token-string">'admin.dashboard'</span>))-><span class="token-function">name</span>(<span class="token-string">'dashboard'</span>);
});

<span class="token-comment">// Routes Vendeur</span>
Route::<span class="token-function">prefix</span>(<span class="token-string">'vendor'</span>)-><span class="token-function">middleware</span>([<span class="token-string">'auth'</span>, <span class="token-string">'verified'</span>, <span class="token-string">'vendor'</span>])-><span class="token-function">name</span>(<span class="token-string">'vendor.'</span>)-><span class="token-function">group</span>(<span class="token-keyword">function</span> () {
    Route::<span class="token-function">get</span>(<span class="token-string">'/dashboard'</span>, <span class="token-keyword">fn</span>() => <span class="token-function">view</span>(<span class="token-string">'vendor.dashboard'</span>))-><span class="token-function">name</span>(<span class="token-string">'dashboard'</span>);
});

<span class="token-comment">// Routes Client (authentifié)</span>
Route::<span class="token-function">middleware</span>([<span class="token-string">'auth'</span>, <span class="token-string">'verified'</span>])-><span class="token-function">group</span>(<span class="token-keyword">function</span> () {
    Route::<span class="token-function">get</span>(<span class="token-string">'/dashboard'</span>, <span class="token-keyword">fn</span>() => <span class="token-function">view</span>(<span class="token-string">'customer.dashboard'</span>))-><span class="token-function">name</span>(<span class="token-string">'dashboard'</span>);
});</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Vue dashboard vendeur</h4>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/vendor/dashboard.blade.php --&gt;</span>

&lt;x-layouts.app title="Tableau de bord Vendeur"&gt;
    &lt;div class="container py-5"&gt;
        &lt;h1 class="mb-4"&gt;
            &lt;i class="bi bi-shop me-2"&gt;&lt;/i&gt;Tableau de bord Vendeur
        &lt;/h1&gt;
        
        &lt;div class="row g-4"&gt;
            &lt;div class="col-md-4"&gt;
                &lt;div class="card bg-primary text-white"&gt;
                    &lt;div class="card-body text-center"&gt;
                        &lt;h3&gt;0&lt;/h3&gt;
                        &lt;p&gt;Produits&lt;/p&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class="col-md-4"&gt;
                &lt;div class="card bg-success text-white"&gt;
                    &lt;div class="card-body text-center"&gt;
                        &lt;h3&gt;0 €&lt;/h3&gt;
                        &lt;p&gt;Ventes&lt;/p&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class="col-md-4"&gt;
                &lt;div class="card bg-info text-white"&gt;
                    &lt;div class="card-body text-center"&gt;
                        &lt;h3&gt;0&lt;/h3&gt;
                        &lt;p&gt;Commandes&lt;/p&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/x-layouts.app&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Créer les vues Dashboard pour Admin et Client</h4>
            <p class="text-gray-700 mb-4">
                Sur le même modèle, créez les fichiers pour les autres rôles :
            </p>
            
            <div class="code-block-wrapper">
                <span class="code-lang">blade</span>
                <pre class="code-block"><code><span class="token-comment">&lt;!-- resources/views/admin/dashboard.blade.php --&gt;</span>
&lt;x-layouts.app title="Tableau de bord Admin"&gt;
    &lt;div class="container py-5"&gt;
        &lt;h1&gt;Espace Administration&lt;/h1&gt;
        &lt;p&gt;Bienvenue dans le panneau de contrôle.&lt;/p&gt;
    &lt;/div&gt;
&lt;/x-layouts.app&gt;

<span class="token-comment">&lt;!-- resources/views/customer/dashboard.blade.php --&gt;</span>
&lt;x-layouts.app title="Mon Espace"&gt;
    &lt;div class="container py-5"&gt;
        &lt;h1&gt;Mon Compte&lt;/h1&gt;
        &lt;p&gt;Bienvenue dans votre espace client.&lt;/p&gt;
    &lt;/div&gt;
&lt;/x-layouts.app&gt;</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <div class="alert-success mt-8">
        <strong>🎉 Fin de la Séance 2 !</strong> Vous avez maintenant un système d'authentification
        avec 3 rôles (Admin, Vendor, Customer) et des dashboards protégés.
    </div>
    
    <div class="text-right mt-8">
        <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a>
    </div>
</section>
