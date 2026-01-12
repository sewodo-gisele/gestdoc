
@extends('layouts.users')
@section('title', 'Details du Document')
@section('content')
    <div class="dashboard-container">
        <h1>Détails du Document</h1>

        <div class="table-container">
            <table>
                <tr>
                    <th>Titre</th>
                    <td>{{ $document->titre }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>{{ $document->type }}</td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td>{{ $document->statut }}</td>
                </tr>
                <tr>
                    <th>Date de création</th>
                    <td>{{ $document->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Fichier</th>
                    <td>
                        <style>
    .btn-action-container {
        display: inline-flex;
        gap: 8px;
    }

    .btn-modern {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 50px; /* Forme pilule très moderne */
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
        border: none;
        color: white !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Style Vert (Télécharger) */
    .btn-modern-download {
        background: #2ecc71;
    }
    .btn-modern-download:hover {
        background: #27ae60;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
    }

    .btn-modern i {
        margin-right: 7px;
    }
</style>

<div class="btn-action-container">
    <a href="{{ route('documents.download', $document->id) }}" class="btn-modern btn-modern-download">
        <i class="fas fa-download"></i> Télécharger le fichier
    </a>
</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection