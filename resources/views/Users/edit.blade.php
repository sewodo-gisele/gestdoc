@extends('layouts.users')
@section('title', 'Modifier le document')
@section('content')
<div class="dashboard-container" style="padding: 30px; max-width: 800px; margin: 0 auto;">
    <h2 style="color: #1e3a8a; margin-bottom: 25px;">Modifier le document</h2>

    <div style="background: white; padding: 25px; border-radius: 12px; border: 1px solid #eaeaea; box-shadow: 0 4px 12px rgba(0,0,0,.05);">
        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Titre du document</label>
                <input type="text" name="titre" value="{{ $document->titre }}" required 
                       style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Remplacer le fichier (laisser vide pour garder l'actuel)</label>
                <input type="file" name="file" 
                       style="width: 100%; padding: 10px; border: 1px dashed #cbd5e1; border-radius: 8px;">
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('dashboard') }}" style="background: #94a3b8; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection