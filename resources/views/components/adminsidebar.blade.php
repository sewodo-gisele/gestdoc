<aside class="sidebar">
    <div class="logo">
        <div class="logo-img">
            <img src="{{ asset('assets/images/log.png') }}" alt="Logo Gest-Docs">
        </div>
        <div class="logo-text">
            <h1>Gest-<span>Docs</span></h1>
        </div>
    </div>
    
    <ul class="menu">
        <li class="menu-item active">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </li>
        <li class="menu-item">
            <!-- Utilisez url() au lieu de route() si la route n'existe pas -->
            <a href="{{ route('admin.listedocument') }}">
                <i class="fas fa-list"></i>
                Liste des documents
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.utilisateurs') }}">
                <i class="fas fa-users"></i>
                Utilisateurs
            </a>
        </li>
       
        <li class="menu-item">
            <a href="/">
                <i class="fas fa-sign-out-alt"></i>
                Déconnexion
            </a>
        </li>
    </ul>
</aside>