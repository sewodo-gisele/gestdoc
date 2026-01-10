<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gest-Docs - Gestion de Documents</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Sidebar (réutilisable) -->
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
    
    <!-- CSS spécifique à la page -->
    @yield('styles')
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <x-adminsidebar />        
        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- JavaScript spécifique à la page -->
    @yield('scripts')
</body>
</html>