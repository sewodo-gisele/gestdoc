@extends('layouts.users')
@section('title', 'Tableau de bord - Documents')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8 animate-fade-in-down">
        
        {{-- Notifications --}}
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Header & Actions --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Mes Documents</h1>
                <p class="text-slate-500 mt-1">Gérez et suivez l'état de vos documents administratifs.</p>
            </div>
            
            <button onclick="toggleUploadForm(true)" 
                class="group bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-md shadow-blue-500/20 transition-all active:scale-95 flex items-center gap-2">
                <i class="fas fa-plus transition-transform group-hover:rotate-90"></i>
                <span>Nouveau Document</span>
            </button>
        </div>

        {{-- Search Section (Styled as requested) --}}
        <div class="bg-white p-1 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('user.documents') }}" method="GET" class="flex flex-col sm:flex-row gap-2 p-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full pl-11 pr-4 py-3 bg-slate-50 border-0 text-slate-900 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors placeholder:text-slate-400"
                        placeholder="Rechercher par titre, référence...">
                </div>
                <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3 rounded-xl font-medium transition-colors">
                    Rechercher
                </button>
            </form>
        </div>

        {{-- Upload Form (Hidden by default) --}}
        <div id="uploadContainer" class="hidden transform transition-all duration-300 ease-in-out">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        Envoi de document
                    </h3>
                    <button onclick="toggleUploadForm(false)" class="text-slate-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Titre du document</label>
                            <input type="text" name="titre" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none"
                                placeholder="Ex: Justificatif de domicile">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Fichier joint</label>
                            <div class="relative">
                                <input type="file" name="file" required 
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all border border-slate-200 rounded-xl cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" onclick="toggleUploadForm(false)" 
                            class="px-5 py-2.5 rounded-xl text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 font-medium transition-colors">
                            Annuler
                        </button>
                        <button type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 shadow-md shadow-blue-500/20 transition-all">
                            Envoyer le fichier
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['label' => 'Total Documents', 'count' => $totalCount, 'icon' => 'fa-folder', 'color' => 'blue', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                ['label' => 'En attente', 'count' => $pendingCount ?? 0, 'icon' => 'fa-clock', 'color' => 'amber', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
                ['label' => 'Validés', 'count' => $approvedCount ?? 0, 'icon' => 'fa-check-circle', 'color' => 'emerald', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600']
            ] as $stat)
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">{{ $stat['label'] }}</p>
                            <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stat['count'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl {{ $stat['bg'] }} {{ $stat['text'] }} flex items-center justify-center text-xl">
                            <i class="fas {{ $stat['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Documents List --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                {{-- Desktop Table --}}
                <table class="w-full text-left hidden md:table">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Document</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Date d'ajout</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                            <i class="fas fa-file-alt text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800 group-hover:text-blue-600 transition-colors">{{ $doc->titre }}</p>
                                            <p class="text-xs text-slate-400">PDF • 2.4 MB</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $doc->created_at->format('d/m/Y') }}
                                    <span class="block text-xs text-slate-400">{{ $doc->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusStyles = [
                                            'en attente' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'validé' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'rejeté' => 'bg-red-100 text-red-700 border-red-200',
                                        ];
                                        $style = $statusStyles[$doc->statut] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $style }}">
                                        {{ ucfirst($doc->statut) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('documents.download', $doc->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Télécharger">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="{{ route('document.show', $doc->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-folder-open text-3xl text-slate-300"></i>
                                        </div>
                                        <p class="text-lg font-medium text-slate-600">Aucun document trouvé</p>
                                        <p class="text-sm">Essayez de modifier votre recherche ou ajoutez un nouveau document.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards View --}}
            <div class="md:hidden space-y-4 p-4">
                @foreach($documents as $doc)
                    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-slate-900">{{ $doc->titre }}</h4>
                                    <p class="text-xs text-slate-500">{{ $doc->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            @php
                                $statusColors = [
                                    'en attente' => 'text-amber-600 bg-amber-50',
                                    'validé' => 'text-emerald-600 bg-emerald-50',
                                    'rejeté' => 'text-red-600 bg-red-50',
                                ];
                                $color = $statusColors[$doc->statut] ?? 'text-slate-600 bg-slate-50';
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $color }}">
                                {{ ucfirst($doc->statut) }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                             <a href="{{ route('documents.download', $doc->id) }}" class="flex-1 py-2 text-center text-sm font-medium text-slate-600 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                                <i class="fas fa-download mr-1"></i> Télécharger
                            </a>
                            <a href="{{ route('document.show', $doc->id) }}" class="flex-1 py-2 text-center text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <i class="fas fa-eye mr-1"></i> Voir
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination (if available) --}}
            @if(method_exists($documents, 'links'))
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleUploadForm(show) {
            const container = document.getElementById('uploadContainer');
            if(show) {
                container.classList.remove('hidden');
                setTimeout(() => {
                    container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Focus first input
                    container.querySelector('input[name="titre"]').focus();
                }, 100);
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
@endpush
