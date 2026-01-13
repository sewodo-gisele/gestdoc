@extends('layouts.users')
@section('title', 'Tableau de bord Utilisateur')

@push('styles')
    <style>
        /* --- STRUCTURE GLOBALE --- */
        * {
            box-sizing: border-box;
        }

        .dashboard-container {
            width: 100%;
            padding: 20px;
            background-color: #f4f7fe;
            min-height: 100vh;
        }

        /* --- HEADER (TITRE + RECHERCHE + BOUTON) --- */
        .main-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .header-left-group {
            display: flex;
            align-items: center;
            gap: 30px;
            flex: 1;
        }

        .header-left-group h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #1e3a8a;
            white-space: nowrap;
        }

        .search-section {
            flex: 1;
            max-width: 450px;
        }

        #filterForm {
            display: flex;
            gap: 8px;
        }

        #searchInput {
            flex: 1;
            padding: 10px 15px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            outline: none;
            transition: 0.3s;
        }

        #searchInput:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        #searchBtn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        /* --- BOUTON AJOUTER --- */
        .btn-add-doc {
            background: #10b981;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-add-doc:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        /* --- SECTION FORMULAIRE D'AJOUT (IN-LINE) --- */
        #uploadContainer {
            display: none;
            /* Masqué par défaut */
            animation: fadeInDown 0.4s ease-out;
            margin-bottom: 30px;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .upload-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .form-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        /* --- CARTES DE STATS --- */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, .02);
            text-align: center;
        }

        .card h4 {
            margin: 0;
            color: #64748b;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .card p {
            font-size: 2rem;
            font-weight: bold;
            margin: 5px 0 0;
            color: #1e3a8a;
        }

        /* --- TABLEAU --- */
        .table-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, .02);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th {
            background: #f8fafc;
            padding: 15px;
            text-align: left;
            color: #64748b;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-top: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .btn-doc {
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
            color: white !important;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: 0.2s;
        }

        .btn-download-style {
            background: #27ae60;
        }

        .btn-view-style {
            background: #3498db;
        }

        @media (max-width: 768px) {
            .header-left-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .main-header-row {
                flex-direction: column;
                align-items: stretch;
            }

            .form-grid {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">

        {{-- Notifications --}}
        @if (session('success'))
            <div style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- En-tête --}}
        <div class="main-header-row">
            <div class="header-left-group" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <h2>Mon Tableau de Bord</h2>

                <section class="search-section">
                    <form action="" method="GET" id="filterForm" style="display: flex; gap: 20px;">
                        <input type="text" name="search" id="searchInput" placeholder="Rechercher un document..."
                            value="{{ request('search') }}" class="rerere">
                        <button type="submit" id="searchBtn">
                            <i class="fas fa-search" class="rerere" style="background-color: #dcfce7 !important; border-radius:10px"></i>
                        </button>
                    </form>
                </section>

                <button class="btn-add-doc" onclick="toggleUploadForm(true)">
                <i class="fas fa-plus"></i> Nouveau Document
            </button>
            </div>

            
        </div>

        {{-- FORMULAIRE D'AJOUT (Caché par défaut, apparaît sous le bouton) --}}
        <div id="uploadContainer">
            <div class="upload-card">
                <h3 style="margin-top: 0; color: #1e3a8a; font-size: 1.1rem; margin-bottom: 20px;">
                    <i class="fas fa-file-upload"></i> Ajouter un nouveau document
                </h3>
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div style="flex: 2; min-width: 250px;">
                            <label style="display:block; margin-bottom:5px; font-weight: 600; font-size: 14px;">Titre du
                                document</label>
                            <input type="text" name="titre"
                                style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;"
                                placeholder="Ex: Rapport d'activité..." required>
                        </div>

                        <div style="display:flex; min-width: 200px;margin-top: 2em;">
                            <label
                                style="display:block; margin-bottom:5px; font-weight: 600; font-size: 14px;">Fichier</label>
                            <input type="file" name="file" required style="font-size: 14px; width: 100%;">
                            <div style="display: flex; gap: 10px;">
                                <button type="button" onclick="toggleUploadForm(false)"
                                    style="padding: 10px 20px; background: #f1f5f9; border:none; border-radius:8px; cursor:pointer; font-weight: 600;">
                                    Annuler
                                </button>
                                <button type="submit"
                                    style="padding: 10px 20px; background: #3b82f6; color:white; border:none; border-radius:8px; cursor:pointer; font-weight: 600;">
                                    Téléverser
                                </button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>

        {{-- Statistiques --}}
        <div class="stats">
            <div class="card">
                <h4>Total Documents</h4>
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

        {{-- Liste des documents --}}
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
                            <td style="font-weight: 500; color: #1e293b;">{{ $doc->titre }}</td>
                            <td style="color: #64748b;">{{ $doc->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span
                                    style="padding: 4px 10px; border-radius: 20px; font-size: 12px; background: #f1f5f9; color: #475569;">
                                    {{ $doc->statut }}
                                </span>
                            </td>
                            <td>
                                <div class="doc-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('documents.download', $doc->id) }}"
                                        class="btn-doc btn-download-style">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="{{ route('document.show', $doc->id) }}" class="btn-doc btn-view-style">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fas fa-folder-open"
                                    style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                Aucun document trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        /**
         * Alterne l'affichage du formulaire d'ajout
         * @param {boolean} show
         */
        function toggleUploadForm(show) {
            const container = document.getElementById('uploadContainer');
            if (container) {
                container.style.display = show ? 'block' : 'none';
                if (show) {
                    // Scroll fluide vers le formulaire pour mobile
                    container.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }
            }
        }
    </script>
@endpush
