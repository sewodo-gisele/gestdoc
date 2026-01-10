@extends('layouts.app')
@section('title', 'Tableau de bord Admin')
@section('content')
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administrateur - Gest-Docs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
       
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            min-height: 100vh;
        }

        .main-content {
            padding: 25px;
        }

        /* ===== HEADER ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header h2 {
            font-size: 1.8rem;
            color: #2c3e50;
            font-weight: 700;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-bar {
            display: flex;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            padding: 10px 15px;
            width: 300px;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex: 1;
            padding: 5px;
            font-size: 0.95rem;
            background: transparent;
        }

        .search-bar button {
            background: none;
            border: none;
            color: #7f8c8d;
            cursor: pointer;
            padding: 0 5px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3);
        }

        /* ===== DASHBOARD CARDS ===== */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eaeaea;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .card-documents .card-icon {
            background-color: #e8f4fc;
            color: #3498db;
        }

        .card-users .card-icon {
            background-color: #f0f7f0;
            color: #27ae60;
        }

        .card-files .card-icon {
            background-color: #f9f0f7;
            color: #9b59b6;
        }

        .card-title {
            font-size: 1rem;
            color: #7f8c8d;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .card-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        /* ===== TABLE SECTIONS ===== */
        .table-section {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid #eaeaea;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h3 {
            font-size: 1.4rem;
            color: #2c3e50;
            font-weight: 700;
        }

        /* ===== BUTTONS ===== */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2980b9, #1c6ea4);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        /* ===== TABLES ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f8f9fa;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #2c3e50;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* ===== DOC TYPE BADGES ===== */
        .doc-type {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            background-color: #e8f4fc;
            color: #3498db;
            display: inline-block;
        }

        /* ===== STATUS BADGES ===== */
        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            min-width: 100px;
            text-align: center;
        }

        .status.approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status.rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* ===== ACTION BUTTONS ===== */
        .btn-action {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
            margin: 0 3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-action:hover {
            color: #1e3a8a;
            background-color: #f3f4f6;
        }

        /* ===== MODAL ===== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            width: 500px;
            max-width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            font-size: 1.5rem;
            color: #2c3e50;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #7f8c8d;
            padding: 5px;
        }

        .close-btn:hover {
            color: #2c3e50;
        }

        /* ===== FORM STYLES ===== */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-group input[type="file"] {
            padding: 8px;
            background-color: #f9f9f9;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        /* ===== FOOTER ===== */
        footer {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-size: 0.9rem;
            border-top: 1px solid #eee;
            margin-top: 20px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1100px) {
            .dashboard-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .search-bar {
                width: 100%;
            }
            
            .dashboard-cards {
                grid-template-columns: 1fr;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .modal-content {
                padding: 20px;
                width: 95%;
            }
        }

        /* ===== UTILITY ===== */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
            color: #ddd;
        }

        small {
            color: #7f8c8d;
            font-size: 0.85rem;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-content {
            animation: fadeIn 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <div class="header">
            <h2>Tableau de bord Administrateur</h2>
            <div class="user-info">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Rechercher un document...">
                    <button id="searchButton"><i class="fas fa-search"></i></button>
                </div>
                <div class="user-avatar">
                    @auth
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    @else
                        AD
                    @endauth
                </div>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card card-documents">
                <div class="card-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-title">Documents totaux</div>
                <div class="card-value">
                    {{ $totalDoc ?? 0 }}
                </div>
            </div>
            
            <div class="card card-users">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-title">Utilisateurs</div>
                <div class="card-value">
                 {{ $totalUsers ?? 0 }}
                </div>
            </div>
            
            <div class="card card-files">
                <div class="card-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="card-title">Fichiers sécurisés</div>
                <div class="card-value">
                    {{ $stats['secure_files'] ?? 0 }}
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 30px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h4 style="margin-bottom: 5px; font-family: sans-serif; color: #333;">Activité des documents</h4>
    <p style="font-size: 12px; color: #666; margin-bottom: 20px;">Documents validés et rejetés par mois.</p>
    
    <div style="position: relative; height: 300px; width: 100%;">
        <canvas id="documentBarChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('documentBarChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar', // Type barres comme sur l'image
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [
                    {
                        label: 'Validés',
                        data: [20, 160, 120, 80, 140, 160], // Tes données
                        backgroundColor: '#bae6fd', // Bleu clair (image)
                        borderRadius: 5,
                        barThickness: 20
                    },
                    {
                        label: 'Rejetés',
                        data: [10, 20, 15, 5, 12, 10], // Tes données
                        backgroundColor: '#22d3ee', // Cyan (image)
                        borderRadius: 5,
                        barThickness: 20
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom', // Légende en bas
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: '#f1f5f9'
                        },
                        ticks: {
                            stepSize: 80
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>

        <!-- Documents Table -->
        {{-- <div class="table-section">
            <div class="section-header">
                <h3>Liste des documents ({{ count($documents ?? []) }})</h3>
                <button class="btn btn-primary" id="addDocumentBtn">
                    <i class="fas fa-plus"></i> Ajouter un document
                </button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Nom du document</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Propriétaire</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="documentsTable">
                    @if(isset($documents) && count($documents) > 0)
                        @foreach($documents as $document)
                        <tr>
                            <td>
                                @php
                                    $icon = 'fa-file';
                                    $color = '#7f8c8d';
                                    
                                    if ($document->chemin_fichier) {
                                        $extension = strtolower(pathinfo($document->chemin_fichier, PATHINFO_EXTENSION));
                                        
                                        if (in_array($extension, ['doc', 'docx'])) {
                                            $icon = 'fa-file-word';
                                            $color = '#2b579a';
                                        } elseif ($extension == 'pdf') {
                                            $icon = 'fa-file-pdf';
                                            $color = '#f40f02';
                                        } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                            $icon = 'fa-file-excel';
                                            $color = '#217346';
                                        } elseif (in_array($extension, ['ppt', 'pptx'])) {
                                            $icon = 'fa-file-powerpoint';
                                            $color = '#d24726';
                                        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                            $icon = 'fa-file-image';
                                            $color = '#e74c3c';
                                        }
                                    }
                                @endphp
                                <i class="fas {{ $icon }}" style="color: {{ $color }}; margin-right: 10px;"></i>
                                {{ $document->titre ?? 'Sans titre' }}
                            </td>
                            <td>
                                <span class="doc-type">
                                    @if($document->chemin_fichier)
                                        {{ strtoupper(pathinfo($document->chemin_fichier, PATHINFO_EXTENSION)) }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </td>
                            <td>
                                {{ $document->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ $document->user->name ?? 'Inconnu' }}
                            </td>
                            <td>
                                @php
                                    $statusClass = 'pending';
                                    $statusText = $document->statut ?? 'Inconnu';
                                    
                                    if ($statusText == 'approuvé' || $statusText == 'approved') {
                                        $statusClass = 'approved';
                                    } elseif ($statusText == 'rejeté' || $statusText == 'rejected') {
                                        $statusClass = 'rejected';
                                    }
                                @endphp
                                <span class="status {{ $statusClass }}">
                                    {{ ucfirst($statusText) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    @if($document->chemin_fichier)
                                        <a href="{{ asset('storage/' . $document->chemin_fichier) }}" 
                                           class="btn-action" title="Télécharger" target="_blank" download>
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @endif
                                    <button class="btn-action view-doc" title="Voir les détails" data-id="{{ $document->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action" title="Supprimer" onclick="confirmDelete({{ $document->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <p>Aucun document dans le système</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div> --}}

        <!-- Users Table -->
        {{-- @if(isset($users) && count($users) > 0)
        <div class="table-section">
            <div class="section-header">
                <h3>Utilisateurs ({{ count($users) }})</h3>
            </div> --}}
            
            {{-- <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Inscription</th>
                        <th>Documents</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="status {{ $user->role == 'admin' ? 'approved' : 'pending' }}">
                                {{ ucfirst($user->role ?? 'utilisateur') }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            {{ $user->documents()->count() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> --}}
        {{-- </div>
        @endif --}}

        <!-- Footer -->
        <footer>
            <p>&copy; {{ date('Y') }} Gest-docs. Tous droits réservés.</p>
        </footer>
    </main>

    <!-- Modal pour ajouter un document -->
    {{-- <div id="addDocumentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-upload"></i> Téléverser un document</h3>
                <button class="close-btn" id="closeModalBtn">&times;</button>
            </div>
            
            <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="documentName"><i class="fas fa-heading"></i> Titre du document *</label>
                    <input type="text" name="titre" id="documentName" required 
                           placeholder="Ex: Contrat Client X">
                </div>
                
                <div class="form-group">
                    <label for="documentCategory"><i class="fas fa-folder"></i> Catégorie</label>
                    <select name="categorie_id" id="documentCategory">
                        <option value="">Sans catégorie</option>
                        @if(isset($categories))
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="documentOwner"><i class="fas fa-user"></i> Assigner à un utilisateur</label>
                    <select name="user_id" id="documentOwner">
                        <option value="{{ Auth::id() ?? '' }}">Moi-même (Admin)</option>
                        @if(isset($users))
                            @foreach($users as $user)
                                @if($user->id != (Auth::id() ?? 0))
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="documentFile"><i class="fas fa-file"></i> Fichier *</label>
                    <input type="file" name="document_file" id="documentFile" 
                           accept=".doc,.docx,.pdf,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png" required>
                    <small>Max. 10MB - Formats acceptés: PDF, Word, Excel, images</small>
                </div>
                
                <div class="form-group">
                    <label for="documentStatus"><i class="fas fa-info-circle"></i> Statut</label>
                    <select name="statut" id="documentStatus">
                        <option value="en attente">En attente</option>
                        <option value="approuvé">Approuvé</option>
                        <option value="rejeté">Rejeté</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="documentDescription"><i class="fas fa-align-left"></i> Description (optionnelle)</label>
                    <textarea name="description" id="documentDescription" rows="3" 
                              placeholder="Description du document..."></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Téléverser
                    </button>
                </div>
            </form>
        </div>
    </div> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== VARIABLES =====
            
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const addDocumentBtn = document.getElementById('addDocumentBtn');
            const addDocumentModal = document.getElementById('addDocumentModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const uploadForm = document.getElementById('uploadForm');
            
            // ===== FONCTION DE RECHERCHE =====
            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const rows = document.querySelectorAll('#documentsTable tr');
                
                let visibleCount = 0;
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Mettre à jour le compteur
                const countElement = document.querySelector('.section-header h3');
                if (countElement) {
                    const total = countElement.textContent.match(/\((\d+)\)/);
                    if (total) {
                        countElement.innerHTML = countElement.innerHTML.replace(
                            `(${total[1]})`, 
                            `(${visibleCount}/${total[1]})`
                        );
                    }
                }
            }
            
            // ===== GESTION MODAL =====
            function openModal() {
                addDocumentModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
            
            function closeModal() {
                addDocumentModal.style.display = 'none';
                document.body.style.overflow = 'auto';
                uploadForm.reset();
            }
            
            // ===== ÉVÉNEMENTS =====
            // Recherche
            searchButton.addEventListener('click', performSearch);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') performSearch();
            });
            
            // Modal
            addDocumentBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);
            
            // Fermer modal en cliquant dehors
            window.addEventListener('click', function(event) {
                if (event.target === addDocumentModal) closeModal();
            });
            
            // Échap pour fermer modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && addDocumentModal.style.display === 'flex') {
                    closeModal();
                }
            });
            
            // ===== BOUTONS D'ACTION =====
            // Bouton "Voir"
            document.addEventListener('click', function(e) {
                if (e.target.closest('.view-doc')) {
                    const button = e.target.closest('.view-doc');
                    const docId = button.getAttribute('data-id');
                    alert(`Visualisation du document ID: ${docId}\n\nCette fonctionnalité affichera les détails complets du document.`);
                }
            });
            
            // ===== ANIMATION DES CARTES =====
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                });
            });
            
            // ===== VALIDATION DU FORMULAIRE =====
            uploadForm.addEventListener('submit', function(e) {
                const fileName = document.getElementById('documentName').value.trim();
                const fileInput = document.getElementById('documentFile');
                
                if (!fileName) {
                    e.preventDefault();
                    alert('Veuillez saisir un titre pour le document.');
                    document.getElementById('documentName').focus();
                    return;
                }
                
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Veuillez sélectionner un fichier.');
                    fileInput.focus();
                    return;
                }
                
                const file = fileInput.files[0];
                const maxSize = 10 * 1024 * 1024; // 10MB
                
                if (file.size > maxSize) {
                    e.preventDefault();
                    alert('Le fichier est trop volumineux. Taille max: 10MB.');
                    return;
                }
                
                // Afficher un message de chargement
                const submitBtn = uploadForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Téléversement en cours...';
                submitBtn.disabled = true;
                
                // Le formulaire sera soumis normalement
            });
            
            // ===== PRÉVISUALISATION DU NOM DE FICHIER =====
            document.getElementById('documentFile').addEventListener('change', function(e) {
                const fileName = this.files[0]?.name;
                const nameInput = document.getElementById('documentName');
                
                // Si le titre est vide, suggérer le nom du fichier
                if (fileName && !nameInput.value.trim()) {
                    nameInput.value = fileName.replace(/\.[^/.]+$/, ""); // Retirer l'extension
                }
            });
        });
        
        // ===== FONCTION DE SUPPRESSION =====
        function confirmDelete(docId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?\nCette action est irréversible.')) {
                // Ici, tu feras une requête AJAX pour supprimer
                alert(`Document ${docId} marqué pour suppression.\n\nEn production, cela enverrait une requête DELETE à /documents/${docId}`);
                
                // Exemple de code AJAX (à décommenter quand tu auras la route)
                /*
                fetch(`/documents/${docId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
                */
            }
        }
        
        // ===== FONCTION POUR LES STATISTIQUES =====
        function updateStats() {
            // Cette fonction pourrait rafraîchir les stats via AJAX
            console.log('Mise à jour des statistiques...');
        }
    </script> --}}
</body>
</html>
@endsection