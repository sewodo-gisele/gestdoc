<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Notification; // AJOUT : Import du modèle
use App\Models\User; // AJOUT : Pour notifier l'admin
use Illuminate\Support\Facades\Auth;   
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * MODIFICATION : Ajout de la logique de recherche
     * Le reste de la structure est conservé à l'identique.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // On part de la requête de base pour l'utilisateur connecté
        $query = Document::where('user_id', Auth::id());

        // Si une recherche est effectuée
        if (!empty($search)) {
            $query->where('titre', 'LIKE', "%{$search}%");
        }

        $documents = $query->latest()->get();

        // Statistiques calculées sur l'ensemble des documents de l'utilisateur
        $totalCount = Document::where('user_id', Auth::id())->count();
        $pendingCount = Document::where('user_id', Auth::id())->where('statut', 'en attente')->count();
        $approvedCount = Document::where('user_id', Auth::id())->where('statut', 'validé')->count();

        return view('Users.Dashboard', compact('documents', 'totalCount', 'pendingCount', 'approvedCount'));
    }

  public function documentList(Request $request)
{
    $search = $request->input('search');

    // 1. On commence par filtrer par l'utilisateur connecté
    $query = Document::where('user_id', Auth::id());

    // 2. On ajoute la condition de recherche si elle existe
    if ($request->filled('search')) {
        $query->where('titre', 'like', '%' . $search . '%');
    }

    // 3. On récupère les documents une seule fois
    $documents = $query->latest()->get();

    // 4. On calcule les stats à partir de la collection déjà filtrée (ou non)
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
            
            $document = Document::create([
                'titre' => $request->titre,
                'chemin_fichier' => $path,
                'user_id' => Auth::id(),
                'statut' => 'En attente',
                'categorie_id' => null 
            ]);

            // NOTIFICATION POUR L'ADMIN (quand un doc est déposé)
            $admin = User::where('role', 'admin')->first(); 
            if($admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => "📄 Nouveau document déposé par " . Auth::user()->name . " : " . $request->titre,
                    'lu' => false
                ]);
            }

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

        // NOTIFICATION POUR L'UTILISATEUR (Validation)
        Notification::create([
            'user_id' => $document->user_id,
            'message' => "✅ Votre document '{$document->titre}' a été validé avec succès !",
            'lu' => false
        ]);

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

        // NOTIFICATION POUR L'UTILISATEUR (Rejet)
        Notification::create([
            'user_id' => $document->user_id,
            'message' => "❌ Votre document '{$document->titre}' a été rejeté. Motif : " . $request->commentaire,
            'lu' => false
        ]);

        return redirect()->back()->with('success', 'Document rejeté avec motif enregistré.');
    }

    public function edit($id)
    {
        $document = Document::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('Users.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,jpg,png,docx|max:5120',
        ]);

        $document = Document::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->chemin_fichier);
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');
            $document->chemin_fichier = $path;
        }

        $document->titre = $request->titre;
        $document->statut = 'En attente';
        $document->save();

        // NOTIFICATION POUR L'ADMIN (Correction d'un doc rejeté)
        $admin = User::where('role', 'admin')->first();
        if($admin) {
            Notification::create([
                'user_id' => $admin->id,
                'message' => "🔄 " . Auth::user()->name . " a modifié le document rejeté : " . $document->titre,
                'lu' => false
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Document mis à jour avec succès !');
    }
}