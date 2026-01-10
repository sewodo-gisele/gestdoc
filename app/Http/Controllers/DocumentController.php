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
        // $documents = Document::all();
        // ATTENTION : Utilisez 'statut' (avec un 'u') car c'est ce qui est dans votre modèle
        $totalCount = $documents->count();
        $pendingCount = $documents->where('statut', 'en attente')->count();
        $approvedCount = $documents->where('statut', 'validé')->count();

        // Assurez-vous que le nom de votre vue est bien 'dashboard' ou 'users.dashboard'
        return view('Users.Dashboard', compact('documents', 'totalCount', 'pendingCount', 'approvedCount'));
    }
    public function documentList()
    {
        $id = 3;
        // On récupère les docs de l'utilisateur connecté
        $documents = Document::where('user_id', Auth::id())->latest()->get();
        // $documents = Document::all();
        // ATTENTION : Utilisez 'statut' (avec un 'u') car c'est ce qui est dans votre modèle
        $totalCount = $documents->count();
        $pendingCount = $documents->where('statut', 'en attente')->count();
        $approvedCount = $documents->where('statut', 'validé')->count();

        // Assurez-vous que le nom de votre vue est bien 'dashboard' ou 'users.dashboard'
        return view('Users.documents', compact('documents', 'totalCount', 'pendingCount', 'approvedCount'));
    }

    public function store(Request $request)
    {
        // 1. Validation : utilisez 'titre' car c'est le name de votre input HTML
        $request->validate([
            'titre' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,jpg,png,docx|max:5120', // Augmenté à 5MB pour être tranquille
        ]);
        if ($request->hasFile('file')) {
            // 2. Sauvegarder le fichier
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAS('documents', $filename, 'public');
            log('info', ['message' => 'nom du document uploader : ' . $request->file]);
            // 3. Création en base de données
            Document::create([
                'titre' => $request->titre, // Récupère <input name="titre">
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

    public function rejected($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return redirect()->back()->with('success', 'Document rejeté avec succès !');
    }
}