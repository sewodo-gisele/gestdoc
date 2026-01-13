@extends('layouts.users')
@section('title', 'Tableau de bord Utilisateur')

@push('styles')
<style>
    /* Structure globale */
    * { box-sizing: border-box; }
    
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
        border-radius: 12px; 
        padding: 25px; 
        border: 1px solid #eaeaea; 
        box-shadow: 0 4px 12px rgba(0,0,0,.05); 
        text-align: center;
    }
    .card h4 { margin: 0; color: #64748b; font-size: 0.9rem; text-transform: uppercase; }
    .card p { font-size: 1.8rem; font-weight: bold; margin: 10px 0 0; color: #1e3a8a; }

    .table-container { 
        background: #fff; 
        border-radius: 12px; 
        border: 1px solid #eaeaea; 
        overflow-x: auto; 
        width: 100%;
    }

    table { width: 100%; border-collapse: collapse; min-width: 600px; }
    th { background: #f8fafc; padding: 15px; text-align: left; color: #1e3a8a; font-weight: 600; }
    td { padding: 15px; border-top: 1px solid #f1f5f9; vertical-align: middle; }

    /* Badges de statut */
    .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; }
    .status-valide { background: #dcfce7; color: #166534; }
    .status-rejete { background: #fee2e2; color: #991b1b; }
    .status-attente { background: #fef9c3; color: #854d0e; }

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

    .doc-actions { display: flex; gap: 8px; }
    .btn-doc {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        color: white !important;
        font-size: 13px;
        transition: 0.2s;
    }
    .btn-download-style { background: #27ae60; }
    .btn-view-style { background: #3498db; }
    .btn-doc:hover { opacity: 0.8; transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <h1 class="welcome-title">Bienvenue, {{ Auth::user()->name }} !</h1>

    <div class="main-header">
        <h2>Mon Tableau de Bord</h2>
    </div>

    @if(session('success'))
        <div style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="stats">
        <div class="card">
            <h4>Documents Total</h4>
            <p>{{ $totalCount }}</p>
        </div>
        <div class="card">
            <h4>En attente</h4>
            <p>{{ $pendingCount ?? 0 }}</p>
        </div>
        <div class="card">
            <h4>Approuvés</h4>
            <p>{{ $approvedCount ?? 0 }}</p>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nom du fichier</th>
                    <th>Date d'ajout</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                    <tr>
                        <td style="font-weight: 500;">
                            {{ $doc->titre }}
                            {{-- AFFICHAGE DU MOTIF SI REJETÉ --}}
                            @if($doc->statut == 'rejeté' && $doc->commentaire_rejet)
                                <div class="rejection-reason">
                                    <i class="fas fa-circle-exclamation"></i> <strong>Motif :</strong> {{ $doc->commentaire_rejet }}
                                </div>
                            @endif
                        </td>
                        <td style="color: #64748b;">{{ $doc->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $doc->statut == 'validé' ? 'status-valide' : ($doc->statut == 'rejeté' ? 'status-rejete' : 'status-attente') }}">
                                {{ $doc->statut }}
                            </span>
                        </td>
                        <td>
                            <div class="doc-actions">
                                <a href="{{ route('documents.download', $doc->id) }}" class="btn-doc btn-download-style" title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="{{ route('document.show', $doc->id) }}" class="btn-doc btn-view-style" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Aucun document trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection