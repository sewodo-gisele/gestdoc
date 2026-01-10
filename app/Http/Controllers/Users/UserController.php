<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Récupère tous les utilisateurs de la table 'users'
        $users = User::all(); 

        // Retourne la vue en passant la variable $users
        return view('Admin.utilisateurs', compact('users'));
    }

    public function show($id)
    {
        // Récupère un utilisateur spécifique par son ID
        $user = User::findOrFail($id); 

        // Retourne la vue en passant la variable $user
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        // Récupère un utilisateur spécifique par son ID pour l'édition
        $user = User::findOrFail($id); 

        // Retourne la vue en passant la variable $user
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Valide les données entrantes
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        // Récupère l'utilisateur à mettre à jour
        $user = User::findOrFail($id); 

        // Met à jour les informations de l'utilisateur
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Redirige vers la liste des utilisateurs avec un message de succès
        return redirect()->route('Admin.utilisateurs')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // Récupère l'utilisateur à supprimer
        $user = User::findOrFail($id); 

        // Supprime l'utilisateur
        $user->delete();

        // Redirige vers la liste des utilisateurs avec un message de succès
        return redirect()->route('Admin.utilisateurs')->with('success', 'Utilisateur supprimé avec succès.');
    }
    
}