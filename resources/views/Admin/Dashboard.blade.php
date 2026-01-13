@extends('layouts.app')
@section('title', 'Tableau de bord Admin')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f5f7fa; color: #333; min-height: 100vh; }
        .main-content { padding: 25px; }
        section, .dashboard-cards, .header, .graph-card { margin-bottom: 35px; }
        .header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .header h2 { font-size: 1.8rem; color: #2c3e50; font-weight: 700; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .search-bar { display: flex; background-color: white; border-radius: 8px; overflow: hidden; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08); padding: 10px 15px; width: 300px; }
        .search-bar input { border: none; outline: none; flex: 1; padding: 5px; font-size: 0.95rem; background: transparent; }
        .search-bar button { background: none; border: none; color: #7f8c8d; cursor: pointer; }
        .user-avatar { width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #3498db, #2c3e50); display: flex; align-items: center; justify-content: center; font-weight: 600; color: white; box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3); }
        
        /* Dashboard Cards */
        .dashboard-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; }
        .stat-card { background-color: white; border-radius: 12px; padding: 25px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease; border: 1px solid #eaeaea; }
        .stat-card:hover { transform: translateY(-5px); }
        .card-icon { width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 15px; }
        .card-documents .card-icon { background-color: #e8f4fc; color: #3498db; }
        .card-users .card-icon { background-color: #f0f7f0; color: #27ae60; }
        .card-files .card-icon { background-color: #f9f0f7; color: #9b59b6; }
        .card-title { font-size: 1rem; color: #7f8c8d; margin-bottom: 10px; font-weight: 600; }
        .card-value { font-size: 2.5rem; font-weight: 700; color: #2c3e50; }

        /* Filtrage */
        .filter-container { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .filter-btn { padding: 8px 16px; border-radius: 25px; border: 1px solid #e2e8f0; background: white; cursor: pointer; font-size: 13px; font-weight: 600; color: #64748b; transition: all 0.2s; }
        .filter-btn.active { background: #1e3a8a; color: white; border-color: #1e3a8a; }
        .filter-btn:hover:not(.active) { background: #f1f5f9; }

        /* Table Section */
        .documents-section { background-color: white; border-radius: 12px; padding: 25px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); border: 1px solid #eaeaea; }
        .section-header { margin-bottom: 25px; }
        .section-header h3 { font-size: 1.4rem; color: #2c3e50; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; }
        th { padding: 15px; text-align: left; font-weight: 600; color: #2c3e50; border-bottom: 2px solid #eee; font-size: 0.9rem; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #eee; color: #2c3e50; }
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: capitalize; }
        .bg-success { background: #dcfce7; color: #166534; }
        .bg-danger { background: #fee2e2; color: #991b1b; }
        .bg-warning { background: #fef9c3; color: #854d0e; }
        .actions-cell { display: flex; gap: 10px; align-items: center; }
        .btn-action { border: none; background: none; cursor: pointer; font-size: 1.1rem; color: #6b7280; transition: 0.2s; }
        .btn-action:hover { transform: scale(1.2); }
        
        .graph-card { padding: 25px; background: white; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); border: 1px solid #eaeaea; }
        footer { text-align: center; padding: 20px; color: #7f8c8d; font-size: 0.9rem; margin-top: 40px; }

        /* Modals */
        #previewModal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 10000; align-items: center; justify-content: center; padding: 20px; }
        .preview-container { background: white; width: 90%; height: 90%; border-radius: 15px; overflow: hidden; position: relative; display: flex; flex-direction: column; }
        .preview-header { padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
    </style>

    <main class="main-content">
        <div class="header">
            <h2>Tableau de bord Administrateur</h2>
            <div class="user-info">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Rechercher un document...">
                    <button id="searchButton"><i class="fas fa-search"></i></button>
                </div>
                <div class="user-avatar">
                    @auth {{ strtoupper(substr(Auth::user()->name, 0, 2)) }} @else AD @endauth
                </div>
            </div>
        </div>

        <div class="dashboard-cards">
            <div class="stat-card card-documents">
                <div class="card-icon"><i class="fas fa-file-alt"></i></div>
                <div class="card-title">Documents totaux</div>
                <div class="card-value">{{ $totalDoc ?? 0 }}</div>
            </div>
            <div class="stat-card card-users">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <div class="card-title">Utilisateurs</div>
                <div class="card-value">{{ $totalUsers ?? 0 }}</div>
            </div>
            <div class="stat-card card-files">
                <div class="card-icon"><i class="fas fa-lock"></i></div>
                <div class="card-title">Fichiers sécurisés</div>
                <div class="card-value">{{ $stats['secure_files'] ?? 0 }}</div>
            </div>
        </div>

        <section class="documents-section">
            <div class="section-header">
                <h3>Gestion des documents</h3>
            </div>

            <div class="filter-container">
                <button class="filter-btn active" onclick="filterByStatus('all', this)">Tous</button>
                <button class="filter-btn" onclick="filterByStatus('en attente', this)">En attente</button>
                <button class="filter-btn" onclick="filterByStatus('validé', this)">Validés</button>
                <button class="filter-btn" onclick="filterByStatus('rejeté', this)">Rejetés</button>
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
                    <tr class="document-row" data-status="{{ strtolower($document->statut) }}">
                        <td class="doc-title">{{ $document->titre }}</td>
                        <td>{{ $document->user->name ?? 'Anonyme' }}</td>
                        <td>{{ $document->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $document->statut == 'validé' ? 'bg-success' : ($document->statut == 'rejeté' ? 'bg-danger' : 'bg-warning') }}">
                                {{ $document->statut }}
                            </span>
                        </td>
                        <td class="actions-cell">
                            <button type="button" class="btn-action" style="color: #6366f1;" 
                                    onclick="openPreview('{{ asset('storage/' . $document->chemin_fichier) }}', '{{ addslashes($document->titre) }}')" 
                                    title="Aperçu">
                                <i class="fas fa-eye"></i>
                            </button>

                            <a href="{{ route('documents.download', $document->id) }}" class="btn-action" style="color: #3b82f6;" title="Télécharger">
                                <i class="fas fa-download"></i>
                            </a>

                            @if($document->statut !== 'validé')
                            <form action="{{ route('documents.approuved', $document->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PUT')
                                <button type="submit" class="btn-action" style="color: #22c55e;" title="Approuver">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif

                            @if($document->statut !== 'rejeté')
                            <button type="button" class="btn-action" style="color: #ef4444;" 
                                    onclick="openRejectModal({{ $document->id }}, '{{ addslashes($document->titre) }}')" 
                                    title="Rejeter">
                                <i class="fas fa-xmark"></i>
                            </button>
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

        <div class="graph-card">
            <h4 style="margin-bottom: 5px; color: #333;">Activité des documents</h4>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="documentBarChart"></canvas>
            </div>
        </div>

        <footer>
            <p>&copy; {{ date('Y') }} Gest-docs. Tous droits réservés.</p>
        </footer>
    </main>

<div id="rejectModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
    <div style="background:white; padding:30px; border-radius:15px; width:450px;">
        <h3 id="modalTitle" style="margin-bottom:15px;">Motif du rejet</h3>
        <form id="rejectForm" method="POST">
            @csrf @method('DELETE')
            <textarea name="commentaire" required placeholder="Expliquez pourquoi..." style="width:100%; height:120px; border-radius:10px; border:1px solid #e2e8f0; padding:12px; outline:none;"></textarea>
            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:20px;">
                <button type="button" onclick="closeRejectModal()" style="padding:10px 18px; border-radius:8px; border:1px solid #cbd5e1; background:white; cursor:pointer;">Annuler</button>
                <button type="submit" style="padding:10px 18px; border-radius:8px; border:none; background:#ef4444; color:white; cursor:pointer;">Confirmer</button>
            </div>
        </form>
    </div>
</div>

<div id="previewModal">
    <div class="preview-container">
        <div class="preview-header">
            <h3 id="previewTitle">Aperçu</h3>
            <button onclick="closePreview()" style="background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        <iframe id="previewFrame" style="flex:1; width:100%; border:none;"></iframe>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- FILTRAGE PAR STATUT ---
    function filterByStatus(status, btn) {
        // Update boutons
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Update lignes
        const rows = document.querySelectorAll('.document-row');
        rows.forEach(row => {
            if (status === 'all' || row.getAttribute('data-status') === status) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // --- LOGIQUE PREVIEW ---
    function openPreview(url, titre) {
        document.getElementById('previewTitle').innerText = titre;
        document.getElementById('previewFrame').src = url;
        document.getElementById('previewModal').style.display = 'flex';
    }
    function closePreview() {
        document.getElementById('previewModal').style.display = 'none';
        document.getElementById('previewFrame').src = '';
    }

    // --- LOGIQUE REJET ---
    function openRejectModal(id, titre) {
        document.getElementById('rejectModal').style.display = 'flex';
        document.getElementById('modalTitle').innerText = "Rejeter : " + titre;
        document.getElementById('rejectForm').action = "/documents/rejected/" + id;
    }
    function closeRejectModal() { document.getElementById('rejectModal').style.display = 'none'; }

    // Click outside
    window.onclick = function(e) {
        if (e.target == document.getElementById('previewModal')) closePreview();
        if (e.target == document.getElementById('rejectModal')) closeRejectModal();
    }

    // --- RECHERCHE ---
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('.document-row').forEach(row => {
            const title = row.querySelector('.doc-title').textContent.toLowerCase();
            row.style.display = title.includes(filter) ? "" : "none";
        });
    });

    // --- CHART ---
    const ctx = document.getElementById('documentBarChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            datasets: [
                { label: 'Validés', data: [20, 160, 120, 80, 140, 160], backgroundColor: '#bae6fd', borderRadius: 5 },
                { label: 'Rejetés', data: [10, 20, 15, 5, 12, 10], backgroundColor: '#22d3ee', borderRadius: 5 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endsection