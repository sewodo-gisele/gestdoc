<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;   
use Illuminate\Support\Facades\Storage;
use function Illuminate\Log\log;

class DocumentController extends Controller
{
    public function index()
    {
        $id = 3;
        // On récupère les docs de l'utilisateur connecté
        $documents = Document::where('user_id', Auth::id())->latest()->get();
        
        $totalCount = $documents->count();
        $pendingCount = $documents->where('statut', 'en attente')->count();
        $approvedCount = $documents->where('statut', 'validé')->count();

        return view('Users.Dashboard', compact('documents', 'totalCount', 'pendingCount', 'approvedCount'));
    }

    public function documentList()
    {
        $id = 3;
        $documents = Document::where('user_id', Auth::id())->latest()->get();
        
        $totalCount = $documents->count();
        $pendingCount = $documents->where('statut', 'en attente')->count();
        $approvedCount = $documents->where('statut', 'validé')->count();

        return view('Users.documents', compact('documents', 'totalCount', 'pendingCount', 'approvedCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,jpg,png,docx|max:5120', 
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');
            
            log('info', ['message' => 'nom du document uploader : ' . $request->file]);

            Document::create([
                'titre' => $request->titre,
                'chemin_fichier' => $path,
                'user_id' => Auth::id(),
                'statut' => 'En attente',
                'categorie_id' => null 
            ]);

            return redirect()->back()->with('success', 'Document téléversé avec succès !');
        }
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        return Storage::disk('public')->download($document->chemin_fichier);
    }

    public function show($id)
    {
        $document = Document::findOrFail($id);
        return view('Users.show', compact('document'));
    }

    public function approuved($id)
    {
        $document = Document::findOrFail($id);
        $document->statut = 'validé';
        $document->save();

        return redirect()->back()->with('success', 'Document approuvé avec succès !');
    }

    public function rejected(Request $request, $id)
    {
        $request->validate([
            'commentaire' => 'required|string|max:500',
        ]);

        $document = Document::findOrFail($id);
        
        $document->update([
            'statut' => 'rejeté',
            'commentaire_rejet' => $request->commentaire
        ]);

        return redirect()->back()->with('success', 'Document rejeté avec motif enregistré.');
    }

    // --- NOUVELLES FONCTIONS DE MODIFICATION ---

    public function edit($id)
    {
        // On vérifie que le document appartient bien à l'utilisateur connecté pour éviter les bugs de sécurité
        $document = Document::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('Users.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,jpg,png,docx|max:5120',
        ]);

        // Sécurité : Seul le propriétaire peut modifier son propre document
        $document = Document::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier pour ne pas encombrer le serveur
            Storage::disk('public')->delete($document->chemin_fichier);
            
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');
            
            $document->chemin_fichier = $path;
        }

        $document->titre = $request->titre;
        $document->statut = 'En attente'; // Reset le statut pour que l'admin re-valide le document corrigé
        $document->save();

        // Redirection vers le dashboard (vérifie bien que le nom de ta route est 'dashboard')
        return redirect()->route('dashboard')->with('success', 'Document mis à jour avec succès !');
    }
}