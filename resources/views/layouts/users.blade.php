<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gest-Docs - Utilisateur')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/usersidebare.css') }}">
    <style>
        /* Structure globale */
        * {
            box-sizing: border-box;
        }

        .dashboard-container {
            width: 100%;
            padding: 20px;
            overflow-x: hidden;
        }

        .welcome-title {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .main-header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 30px;
        }

        .main-header h2 {
            margin: 0;
            color: #1e3a8a;
            font-size: 1.8rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            width: 100%;
        }

        .card {
            background: #fff;
            /* display: flex !important; */
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #eaeaea;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
            text-align: center;
        }

        .card h4 {
            margin: 0;
            color: #64748b;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .card p {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 10px 0 0;
            color: #1e3a8a;
        }

        .table-container {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #eaeaea;
            overflow-x: auto;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th {
            background: #f8fafc;
            padding: 15px;
            text-align: left;
            color: #1e3a8a;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-top: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* Badges de statut */
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-valide {
            background: #dcfce7;
            color: #166534;
        }

        .status-rejete {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-attente {
            background: #fef9c3;
            color: #854d0e;
        }

        /* Motif de rejet */
        .rejection-reason {
            margin-top: 8px;
            font-size: 0.8rem;
            color: #b91c1c;
            background: #fff5f5;
            padding: 8px;
            border-radius: 6px;
            border-left: 3px solid #ef4444;
        }

        .rerere{
            display: flex;
            align-items: center;
            border: 1px solid #cbd5e1;
            padding: 10px 20px;
            border-radius: 8px;
            overflow: hidden;
            width: 400px;
        }

        .btn-add-doc {
            background: #3b82f6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .doc-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-doc {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: white !important;
            font-size: 13px;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 35px;
            height: 32px;
        }

        .btn-download-style {
            background: #27ae60;
        }

        .btn-view-style {
            background: #3498db;
        }

        .btn-edit-style {
            background: #f59e0b;
        }

        .btn-doc:hover:not(.disabled) {
            opacity: 0.8;
            transform: translateY(-1px);
        }


        .page-with-sidebar {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            margin-left: 260px;
            width: calc(100% - 260px);
            background: #f5f7fb;
        }

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

        /* NOTIFICATIONS UI */
        .notification-bell {
            position: relative;
            cursor: pointer;
            padding: 5px;
        }

        #uploadContainer {
            display: none;
            /* Masqué par défaut */
            animation: fadeInDown 0.4s ease-out;
            margin-bottom: 30px;
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        .notif-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 40px;
            width: 300px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            z-index: 1000;
        }

        .notif-item {
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .notif-item:hover {
            background: #f9fafb;
        }

        .notif-unread {
            background: #f0f9ff;
            border-left: 3px solid #3b82f6;
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
            border: 2px solid #e5e7eb;
            overflow: hidden;
        }

        .main-content {
            padding: 30px;
            min-height: calc(100vh - 70px);
        }
    </style>
</head>

<body>
    <div class="page-with-sidebar">
        <x-usersidebar />
        <div class="content-wrapper">
            <div class="header">
                <div class="logo-header"><i class="fa-solid fa-folder"></i> Gest-Docs</div>
                <div class="header-right">

                    <div class="notification-bell" id="notifBtn" onclick="toggleNotifs()">
                        <i class="fa-regular fa-bell" style="font-size: 1.2rem; color: #6b7280;"></i>
                        @php
                            $notifs = \App\Models\Notification::where('user_id', auth()->id())
                                ->latest()
                                ->take(5)
                                ->get();
                            $unreadCount = $notifs->where('lu', false)->count();
                        @endphp
                        @if ($unreadCount > 0)
                            <span class="notification-badge" id="notifBadge">{{ $unreadCount }}</span>
                        @endif

                        <div class="notif-dropdown" id="notifDropdown">
                            <div style="padding: 10px; font-weight: bold; border-bottom: 1px solid #eee;">Notifications
                            </div>
                            @forelse($notifs as $n)
                                <div class="notif-item {{ !$n->lu ? 'notif-unread' : '' }}">
                                    {{ $n->message }}
                                    <div style="font-size: 0.7rem; color: #9ca3af; margin-top: 4px;">
                                        {{ $n->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <div style="padding: 20px; text-align: center; color: #9ca3af;">Aucune notification
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="user-avatar">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e3a8a&color=fff"
                            alt="Avatar">
                    </div>
                </div>
            </div>
            <main class="main-content">@yield('content')</main>
        </div>
    </div>

    <script>
        function toggleNotifs() {
            const dropdown = document.getElementById('notifDropdown');
            const badge = document.getElementById('notifBadge');
            const isOpen = dropdown.style.display === 'block';

            dropdown.style.display = isOpen ? 'none' : 'block';

            if (!isOpen && badge) {
                // Marquer comme lu via AJAX
                fetch('{{ route('notifications.read') }}').then(() => badge.style.display = 'none');
            }
        }

        window.onclick = function(e) {
            if (!document.getElementById('notifBtn').contains(e.target)) {
                document.getElementById('notifDropdown').style.display = 'none';
            }
        }
    </script>
    @stack('scripts')
</body>

</html>
