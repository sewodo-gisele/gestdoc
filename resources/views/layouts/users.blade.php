<!DOCTYPE html>
<html lang="fr" class="bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gest-Docs - Utilisateur')</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Scripts & Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/usersidebare.css') }}">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Sidebar adjust */
        .content-wrapper {
            margin-left: 260px; /* Match sidebar width */
            width: calc(100% - 260px);
            transition: all 0.3s;
        }
        @media(max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <x-usersidebar />

        {{-- Main Content --}}
        <div class="content-wrapper flex flex-col min-h-screen">
            {{-- Top Header --}}
            <header class="bg-white/80 backdrop-blur-md sticky top-0 z-30 border-b border-slate-200 px-6 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3 text-slate-800 font-semibold text-lg">
                    <div class="md:hidden">
                        {{-- Mobile Toggle Placeholder (if needed by sidebar JS) --}}
                        <i class="fas fa-bars cursor-pointer text-slate-500"></i>
                    </div>
                    <div class="flex items-center gap-2 text-blue-700">
                        <i class="fa-solid fa-folder"></i> 
                        <span>Gest-Docs</span>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    {{-- Notifications --}}
                    <div class="relative" id="notifWrapper">
                        <button onclick="toggleNotifs()" class="relative p-2 text-slate-500 hover:text-blue-600 transition-colors focus:outline-none">
                            <i class="fa-regular fa-bell text-xl"></i>
                            @php
                                $notifs = \App\Models\Notification::where('user_id', auth()->id())->latest()->take(5)->get();
                                $unreadCount = $notifs->where('lu', false)->count();
                            @endphp
                            
                            @if ($unreadCount > 0)
                                <span id="notifBadge" class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>

                        {{-- Notification Dropdown --}}
                        <div id="notifDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50 transform origin-top-right transition-all">
                            <div class="px-4 py-2 border-b border-slate-50 font-semibold text-sm text-slate-800">Notifications</div>
                            <div class="max-h-80 overflow-y-auto">
                                @forelse($notifs as $n)
                                    <div class="px-4 py-3 hover:bg-slate-50 border-b border-slate-50 last:border-0 transition-colors cursor-pointer {{ !$n->lu ? 'bg-blue-50/50' : '' }}">
                                        <p class="text-sm text-slate-700">{{ $n->message }}</p>
                                        <span class="text-xs text-slate-400 mt-1 block">{{ $n->created_at->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <div class="px-4 py-8 text-center text-slate-400 text-sm">
                                        <i class="far fa-bell-slash text-2xl mb-2 block opacity-50"></i>
                                        Aucune notification
                                    </div>
                                @endforelse
                            </div>
                            <a href="#" class="block text-center text-xs text-blue-600 font-medium py-2 hover:bg-slate-50 rounded-b-xl border-t border-slate-50">
                                Voir toutes les notifications
                            </a>
                        </div>
                    </div>

                    {{-- User Profile --}}
                    <div class="flex items-center gap-3 pl-6 border-l border-slate-200">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-slate-700 leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 p-[2px] shadow-sm cursor-pointer hover:shadow-md transition-shadow">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=fff&color=1e40af" 
                                alt="Avatar" class="h-full w-full rounded-full object-cover border-2 border-white">
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 overflow-x-hidden">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Notification Script --}}
    <script>
        function toggleNotifs() {
            const dropdown = document.getElementById('notifDropdown');
            const badge = document.getElementById('notifBadge');
            
            dropdown.classList.toggle('hidden');

            if (!dropdown.classList.contains('hidden') && badge) {
                // Optional: Mark as read via AJAX here
                // fetch('{{ route('notifications.read') }}');
                badge.style.display = 'none';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('notifWrapper');
            const dropdown = document.getElementById('notifDropdown');
            if (!wrapper.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
