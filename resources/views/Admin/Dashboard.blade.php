@extends('layouts.app')
@section('title', 'Tableau de bord Admin')
@section('content')

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

        /* ===== ESPACEMENT ENTRE SECTIONS MAJEURES ===== */
        section, .dashboard-cards, .header, .graph-card {
            margin-bottom: 35px;
        }

        /* ===== HEADER ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        }

        .stat-card {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            border: 1px solid #eaeaea;
        }

        .stat-card:hover {
            transform: translateY(-5px);
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

        .card-documents .card-icon { background-color: #e8f4fc; color: #3498db; }
        .card-users .card-icon { background-color: #f0f7f0; color: #27ae60; }
        .card-files .card-icon { background-color: #f9f0f7; color: #9b59b6; }

        .card-title { font-size: 1rem; color: #7f8c8d; margin-bottom: 10px; font-weight: 600; }
        .card-value { font-size: 2.5rem; font-weight: 700; color: #2c3e50; }

        /* ===== TABLE SECTIONS ===== */
        .documents-section {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
        }

        .section-header {
            margin-bottom: 25px;
        }

        .section-header h3 {
            font-size: 1.4rem;
            color: #2c3e50;
            font-weight: 700;
        }

        /* ===== TABLES ===== */
        table {
            width: 100%;
            border-collapse: collapse;
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

        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .bg-success { background: #dcfce7; color: #166534; }
        .bg-danger { background: #fee2e2; color: #991b1b; }
        .bg-warning { background: #fef9c3; color: #854d0e; }
        
        .actions-cell { display: flex; gap: 10px; align-items: center; }
        .btn-action { border: none; background: none; cursor: pointer; font-size: 1.1rem; color: #6b7280; }

        .graph-card {
            padding: 25px; 
            background: white; 
            border-radius: 12px; 
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-top: 40px;
        }
    </style>

    <main class="main-content">
        {{-- 1. HEADER --}}
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

        {{-- 2. CARTES STATS --}}
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

        {{-- 3. SECTION TABLEAU (MILIEU) --}}
        <section class="documents-section">
            <div class="section-header">
                <h3>Tous les documents ({{ $documents->count() }})</h3>
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
                        <td class="doc-title">{{ $document->titre }}</td>
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
                                @csrf @method('PUT')
                                <button type="submit" class="btn-action" style="color: #22c55e;" title="Approuver">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif

                            @if($document->statut !== 'Rejeté')
                            <form action="{{ route('documents.rejected', $document->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
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

        {{-- 4. SECTION GRAPHIQUE (BAS) --}}
        <div class="graph-card">
            <h4 style="margin-bottom: 5px; color: #333;">Activité des documents</h4>
            <p style="font-size: 12px; color: #666; margin-bottom: 25px;">Documents validés et rejetés par mois.</p>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="documentBarChart"></canvas>
            </div>
        </div>

        <footer>
            <p>&copy; {{ date('Y') }} Gest-docs. Tous droits réservés.</p>
        </footer>
    </main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LOGIQUE DE RECHERCHE ---
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('#documentsTable tr');

            rows.forEach(row => {
                const title = row.querySelector('.doc-title');
                if (title) {
                    const textValue = title.textContent || title.innerText;
                    row.style.display = textValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
                }
            });
        });

        // --- LOGIQUE DU GRAPHIQUE ---
        const ctx = document.getElementById('documentBarChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [
                    {
                        label: 'Validés',
                        data: [20, 160, 120, 80, 140, 160],
                        backgroundColor: '#bae6fd',
                        borderRadius: 5,
                        barThickness: 20
                    },
                    {
                        label: 'Rejetés',
                        data: [10, 20, 15, 5, 12, 10],
                        backgroundColor: '#22d3ee',
                        borderRadius: 5,
                        barThickness: 20
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 80 } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection