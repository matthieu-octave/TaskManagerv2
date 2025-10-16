<?php
namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Affiche la vue du formulaire
    public function create()
    {
        return view('pages.contact');
    }
    // Traite les données du formulaire
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'content' => 'required|string|min:10',
        ]);
        // 2. Création du message en base de données
        Message::create($validated);
        // 3. Redirection vers la page précédente avec un message de succès
        return back()->with('success', 'Votre message a bien été envoyé !');
    }
}
