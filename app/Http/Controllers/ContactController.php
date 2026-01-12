<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // 1. Validation des données
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'organisation' => 'nullable|string',
            'sujet' => 'required',
            'message' => 'required',
        ]);

        // 2. Envoi de l'email à ton adresse
        Mail::to('sewodogisele77@gmail.com')->send(new ContactMessage($data));

        // 3. Retour avec message de succès
        return back()->with('success', 'Votre message a bien été envoyé !');
    }
}