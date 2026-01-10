<aside class="sidebar" id="sidebar">
    <div class="logo">
        <div class="logo-img">
            <img src="{{ asset('assets/images/logo1.jpeg') }}" alt="Logo Gest-Docs">
        </div>
        <div class="logo-text">
            <h1>Gest-<span>Docs</span></h1>
        </div>
    </div>
    
    <ul class="menu">
        <li class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Tableau de Bord</span>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('user.documents.upload') ? 'active' : '' }}">
            <a href="">
                <i class="fas fa-cloud-upload-alt"></i>
                <span class="menu-text">Téléversement</span>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('user.documents') ? 'active' : '' }}">
            <a href="{{ route('user.documents') }}">
                <i class="fas fa-folder-open"></i>
                <span class="menu-text">Mes Documents</span>
            </a>
        </li>
    </ul>
</aside>