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
        
        
    
