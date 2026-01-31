<header class="main-header">
    <div class="logo">
        <img src="{{ asset('assets/images/log.png') }}" alt="Logo Gest-Docs" class="logo-img">
        <span>Gest-Docs</span>
    </div>
    <nav class="main-nav">
        <a href="/" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Accueil
        </a>
        <a href="{{ route('pages.fonctionnalite') }}" class="{{ request()->routeIs('pages.fonctionnalite') ? 'active' : '' }}">
            <i class="fas fa-cogs"></i> Fonctionnalités
        </a>
        <a href="{{ route('pages.Apropos') }}" class="{{ request()->routeIs('pages.Apropos') ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i> A propos
        </a>
        <a href="{{ route('pages.contact') }}" class="{{ request()->routeIs('pages.contact') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Contact
        </a>
    </nav>
    <a href="{{ route('auth.login') }}" class="btn-connect">
        <i class="fas fa-sign-in-alt"></i> Se connecter
    </a>
</header>