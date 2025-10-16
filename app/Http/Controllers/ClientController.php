<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClientController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Client::class);
        $clients = Client::all();
        return view('clients.index', ['clients' => $clients]);
    }
    public function create()
    {
        $this->authorize('create', Client::class);
        return view('clients.create');
    }
    public function store(Request $request)
    {
        $this->authorize('create', Client::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string',
        ]);

        Client::create($validated);
        return redirect()->route('clients.index')->with('success', 'Client créé !');
    }

    /**
     * Affiche les détails d'un client spécifique.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function show(Client $client)
    {
        // Retourne une vue qui pourrait afficher plus de détails sur le client
        // return view('clients.show', ['client' => $client]);
    }

    /**
     * Affiche le formulaire pour modifier un client spécifique.
     * (Vous devriez déjà avoir cette méthode)
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function edit(Client $client)
    {
        $this->authorize('create', Client::class);
        return view('clients.edit', ['client' => $client]);
    }

    /**
     * Met à jour un client spécifique dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Client $client)
    {
        $this->authorize('create', Client::class);
        // 1. Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                // Règle d'unicité qui ignore l'email du client actuel
                Rule::unique('clients')->ignore($client->id),
            ],
            'phone' => 'nullable|string|max:20',
        ]);

        // 2. Mise à jour du client
        $client->update($validated);

        // 3. Redirection avec un message de succès
        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès !');
    }

    /**
     * Supprime un client spécifique de la base de données.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Client $client)
    {
        $this->authorize('create', Client::class);
        // 1. Suppression du client
        $client->delete();

        // 2. Redirection avec un message de succès
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès !');
    }
}
