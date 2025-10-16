<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class PageController extends Controller
{
    /**
     * Affiche la page d'accueil.
     */
    public function welcome()
    {
        // On met en cache le nombre d'utilisateurs pour 600 secondes (10 minutes).
        $userCount = Cache::remember('user_count', 600, function () {
            // Cette fonction ne sera exécutée que toutes les 10 minutes.
            return User::count();
        });

        // On déplace la logique qui était dans le fichier de routes ici.
        return view('pages.welcome', ['userCount' => $userCount]);
    }
}
