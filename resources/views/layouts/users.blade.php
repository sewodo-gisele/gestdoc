<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gest-Docs - Utilisateur')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/usersidebare.css') }}">
    <style>
        /* LAYOUT AVEC SIDEBAR */
        .page-with-sidebar {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            background: #f5f7fb;
        }

        /* Header */
        .header {
            height: 70px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
        }

        .logo-header {
            font-weight: 600;
            color: #1e3a8a;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Contenu principal */
        .main-content {
            padding: 30px;
            width: 100%;
            min-height: calc(100vh - 70px);
        }

        /* Boutons */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
            
            .header {
                padding: 0 15px;
            }
            
            .main-content {
                padding: 20px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="page-with-sidebar">
        {{-- Sidebar utilisateur --}}
        <x-usersidebar />        
        {{-- Contenu principal --}}
        <div class="content-wrapper">
            <!-- Header -->
            <div class="header">
                <div class="logo-header">
                    <i class="fa-solid fa-folder"></i> Gest-Docs
                </div>
                <div class="header-right">
                    <div class="notification-bell" id="notificationBell">
                        <i class="fa-regular fa-bell" style="font-size: 1.2rem; color: #6b7280;"></i>
                        <span class="notification-badge" id="notificationCount">3</span>
                    </div>
                    <div class="user-avatar">
                        @auth
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e3a8a&color=fff" alt="{{ Auth::user()->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name=Utilisateur&background=1e3a8a&color=fff" alt="Utilisateur">
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Contenu de la page -->
            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>