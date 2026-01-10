<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class register extends Controller
{
    public function showRegistrationForm()
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        // Validation des données du formulaire
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'organisation' => 'nullable|string|min:1',
            ]);

        // Déterminer le rôle (admin si premier utilisateur, sinon user)
            $roleId = 2; // user par défaut
            if (User::count() === 0) {
                $roleId = 1; // admin pour le tout premier utilisateur
            }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organisation' => $request->organisation,
            'role_id' => $roleId,
        ]);

        // Connexion automatique après inscription
        auth()->login($user);

        // Redirection selon le rôle
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
}
