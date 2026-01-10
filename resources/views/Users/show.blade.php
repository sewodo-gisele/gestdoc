
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
                        <a href="{{ route('documents.download', $document->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download"></i> Télécharger le fichier
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection