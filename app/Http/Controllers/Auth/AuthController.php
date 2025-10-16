<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Traite les données du formulaire d'inscription.
     */
    public function register(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Connexion automatique de l'utilisateur
        Auth::login($user);

        // 4. Redirection vers le  tableau de bord
        return redirect()->route('dashboard');
    }

    /**
     * Affiche le formulaire de connexion.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    /**
     * Traite les données du formulaire de connexion.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
