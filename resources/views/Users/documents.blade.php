@extends('layouts.users')
@section('title', 'Tableau de bord Utilisateur')
@section('content')
    {{-- <div class="dashboard-container"> --}}
        <h1>Bienvenue sur votre tableau de bord, {{ Auth::user()->name }}!</h1>
       


@push('styles')
<style>
    /* Empêcher le débordement global */
    * { box-sizing: border-box; }

    /* Conteneur principal pour isoler le dashboard */
    .dashboard-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden; /* Sécurité anti-scroll */
        padding: 10px;
    }

    .main-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 30px;
        flex-wrap: wrap; /* Pour mobile */
        gap: 10px;
    }

    /* Stats : On utilise 1fr pour que ça ne dépasse jamais */
    .stats { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
        gap: 20px; 
        margin-bottom: 30px;
        width: 100%;
    }

    .card { background: #fff; border-radius: 12px; padding: 25px; border: 1px solid #eaeaea; box-shadow: 0 4px 12px rgba(0,0,0,.05); text-align: center;}
    .card h4 { margin: 0; color: #64748b; font-size: 0.9rem; }
    .card p { font-size: 1.8rem; font-weight: bold; margin: 10px 0 0; color: #1e3a8a; }

    /* SOLUTION AU SCROLL : Conteneur de table responsive */
    .table-container { 
        background: #fff; 
        border-radius: 12px; 
        border: 1px solid #eaeaea; 
        overflow-x: auto; /* Permet le scroll SEULEMENT à l'intérieur de la table */
        width: 100%;
    }

    table { 
        width: 100%; 
        border-collapse: collapse; 
        min-width: 600px; /* Empêche l'écrasement des colonnes */
    }

    th { background: #f8fafc; padding: 15px; text-align: left; color: #1e3a8a; }
    td { padding: 15px; border-top: 1px solid #f1f5f9; }

    /* Modal */
    .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000; padding: 15px; }
    .modal-content { background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 450px; }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="main-header">
        @if(session('success'))
    <div style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif
        <h2>Mon Tableau de Bord</h2>
        <button class="btn btn-primary" onclick="toggleModal(true)">
            <i class="fa-solid fa-plus"></i> Nouveau Document
        </button>
    </div>

    <div class="stats">
        <div class="card">
            <h4>Documents</h4>
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
        <table id="docsTable">
            <thead>
                <tr>
                    <th>Nom du fichier</th>
                    <th>Date</th>
                    <th>Statut</th>
                     <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($documents) && $documents->count() > 0)
                    @foreach($documents as $doc)
                        <tr>
                            <td>{{ $doc->titre }}</td>
                            <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                            <td>{{ $doc->statut }}</td>
                            <td>
                                <a href="{{ route('documents.download', $doc->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                                <a href="{{ route('document.show', $doc->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Voir 
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 30px; color: #94a3b8;">
                            Aucun document trouvé.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="uploadModal">
    <div class="modal-content">
        <h3>Ajouter un document</h3>
       <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="margin-bottom: 15px;">
        <label style="display:block; margin-bottom:5px;">Titre du document</label>
        {{-- On utilise "titre" car c'est ce qu'attend votre Modèle --}}
        <input type="text" name="titre" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:5px;" required>
    </div>
    
    <div style="margin-bottom: 20px;">
        <label style="display:block; margin-bottom:5px;">Fichier</label>
        <input type="file" name="file" required>
    </div>

    {{-- Si vous voulez que l'utilisateur choisisse une catégorie, ajoutez-la ici, 
         sinon il faudra lui donner une valeur par défaut dans le contrôleur --}}

    <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" onclick="toggleModal(false)" style="padding: 8px 15px; background: #e2e8f0; border:none; border-radius:5px; cursor:pointer;">
            Annuler
        </button>
        <button type="submit" style="padding: 8px 15px; background: #3b82f6; color:white; border:none; border-radius:5px; cursor:pointer;">
            Téléverser
        </button>
    </div>
</form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleModal(show) {
        const modal = document.getElementById('uploadModal');
        if(modal) {
            modal.style.display = show ? 'flex' : 'none';
        }
    }
</script>
@endpush
        
        
    
