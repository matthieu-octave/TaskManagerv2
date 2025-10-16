<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire pour modifier le profil de l'utilisateur.
     */
    public function edit()
    {
        // Récupère l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Retourne la vue et lui passe l'objet utilisateur
        return view('profile.edit', ['user' => $user]);
    }

    /**
     * Met à jour les informations du profil de l'utilisateur.
     */
    public function update(Request $request)
    {
        // Récupère l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Valide les données entrantes
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Validation de l'image
        ]);

        // Gérer le téléversement de l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Stocker le nouveau et récupérer son chemin
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        // Met à jour les informations de l'utilisateur
        $user->update($validated);

        // Redirige vers la page de profil avec un message de succès
        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès !');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // 1. Validation
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // 2. Mise à jour du mot de passe
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Redirection
        return back()->with('success', 'Mot de passe mis à jour avec succès !');
    }
}
