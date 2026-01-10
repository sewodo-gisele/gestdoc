<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        // Correction de la faute de frappe "docments" -> "documents" pour plus de clarté
        $documents = Document::all();
        $totalDoc = $documents->count();
        $totalUsers = User::count(); // Plus rapide que de tout charger puis compter

        return view('admin.Dashboard', compact('documents', 'totalDoc', 'totalUsers'));
    }

    public function listedocument(Request $request)
    {
        $query = Document::query();

        // Filtrage par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Recherche par titre
        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }
        
        // Filtrage par date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // RÉCUPÉRATION : On utilise le résultat de la requête filtrée ($query)
        // On supprime la ligne Document::all() qui cassait tout
        $documents = $query->latest()->get();

        return view('admin.listedocument', compact('documents'));
    }

    public function utilisateur()
    {
        $users = User::all();
        return view('admin.utilisateurs', compact('users'));
    }
}