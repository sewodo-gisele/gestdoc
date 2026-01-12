@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/listedocument.css') }}">
    <style>
        /* Styles pour les badges de statut */
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .bg-success { background: #dcfce7; color: #166534; }
        .bg-danger { background: #fee2e2; color: #991b1b; }
        .bg-warning { background: #fef9c3; color: #854d0e; }
        .actions-cell { display: flex; gap: 10px; align-items: center; }
        .btn-action { border: none; background: none; cursor: pointer; font-size: 1.1rem; }
    </style>
@endsection

@section('content')
    <div class="header">
        <h2>Liste des utilisateurs</h2>
        <div class="user-info">
            <div class="user-avatar">AD</div>
            <span>Admin</span>
        </div>
    </div>

    <section class="search-section">
        <form action="{{ route('admin.listedocument') }}" method="GET" id="filterForm">
            <div class="search-box">
                <input type="text" name="search" id="searchInput" placeholder="Rechercher par titre..." value="{{ request('search') }}">
                <button type="submit" id="searchBtn">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
            
            <div class="filter-section" style="display: flex; gap: 20px; align-items: flex-end; margin-top: 15px;">
                <div class="filter-group">
                    <label for="docStatus">Statut</label>
                    <select name="statut" id="docStatus" class="filter-select" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        <option value="Approuvé" {{ request('statut') == 'Approuvé' ? 'selected' : '' }}>Validé</option>
                        <option value="En attente" {{ request('statut') == 'En attente' ? 'selected' : '' }}>En attente</option>
                        <option value="Rejeté" {{ request('statut') == 'Rejeté' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="docDate">Date</label>
                    <input type="date" name="date" id="docDate" class="filter-input" value="{{ request('date') }}" onchange="this.form.submit()">
                </div>
                
                <div class="filter-group">
                    <a href="{{ route('admin.listedocument') }}" class="btn-clear" style="background-color: #ef4444; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; display: inline-block;">
                        <i class="fas fa-times"></i> Effacer
                    </a>
                </div>
            </div>
        </form>
    </section>
      
    <section class="documents-section">
        <div class="section-header">
            <h3> Les documents recents ({{ $documents->count() }})</h3>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="documentsTable">
                @forelse($documents as $document)
                <tr>
                    <td>{{ $document->titre }}</td>
                    <td>{{ $document->user->name ?? 'Anonyme' }}</td>
                    <td>{{ $document->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $document->statut == 'Approuvé' ? 'bg-success' : ($document->statut == 'Rejeté' ? 'bg-danger' : 'bg-warning') }}">
                            {{ $document->statut }}
                        </span>
                    </td>
                    <td class="actions-cell">
                        <a href="{{ route('documents.download', $document->id) }}" class="btn-action" style="color: #3b82f6;" title="Télécharger">
                            <i class="fas fa-download"></i>
                        </a>

                        @if($document->statut !== 'Approuvé')
                        <form action="{{ route('documents.approuved', $document->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn-action" style="color: #22c55e;" title="Approuver">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @endif

                        @if($document->statut !== 'Rejeté')
                        <form action="{{ route('documents.rejected', $document->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action" style="color: #ef4444;" title="Rejeter">
                                <i class="fas fa-xmark"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Aucun document trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
    
    <footer>
        <p>© 2026 Gest-Docs Tous droits réservés.</p>
    </footer>
@endsection