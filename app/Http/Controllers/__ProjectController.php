<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Policies\ProjectPolicy;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Affiche la liste des projets de l'utilisateur avec une option de tri.
     */
    public function index(Request $request)
    {
        // 1. On récupère les paramètres de tri depuis l'URL, avec des valeurs par défaut.
        $sortColumn = $request->query('sort', 'created_at'); // Par défaut, on trie par date de création
        $sortDirection = $request->query('direction', 'desc'); // Par défaut, du plus récent au plus ancien

        // 2. On construit la requête Eloquent en appliquant le tri.
        $projects = Auth::user()
                        ->projects()
                        ->orderBy($sortColumn, $sortDirection)
                        ->get();

        // 3. On passe les projets triés à la vue.
        return view('pages.dashboard', ['projects' => $projects]);
    }

    public function edit(Project $project)
    {
        // On vérifie l'autorisation via la Policy avant d'afficher la page
        $this->authorize('update', $project);

        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Met à jour un projet dans la base de données.
     */
    public function update(Request $request, Project $project)
    {
        // On vérifie l'autorisation
        $this->authorize('update', $project);

        $validated = $request->validate([
        'title' => [
            'required',
            'string',
            'max:255',
            'min:5',
            // La règle est la même que pour 'store', mais on lui dit
            // d'ignorer le projet avec l'ID actuel lors de la vérification.
            Rule::unique('projects')->where(function ($query) {
                return $query->where('user_id', Auth::id());
            })->ignore($project->id)
        ],
        'description' => 'nullable|string',
    ]);

        $project->update($validated);

        return redirect()->route('dashboard')->with('success', 'Projet mis à jour avec succès !');
    }

    public function create()
    {
        return view('projects.create');
    }
    public function store(Request $request)
    {
        // 1. Validation (Atelier 1)
        $validated = $request->validate([
        'title' => [
            'required',
            'string',
            'max:255',
            'min:5',
            // Le titre doit être unique dans la table 'projects',
            // mais seulement pour les projets de l'utilisateur actuel.
            Rule::unique('projects')->where(function ($query) {
                return $query->where('user_id', Auth::id());
            })
        ],
        'description' => 'nullable|string',
    ]);
        // 2. Création via la relation, cela assigne le bon user_id
        Auth::user()->projects()->create($validated);
        // 3. Redirection
        return redirect()->route('dashboard')->with('success', 'Projet créé avec succès !');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        $users = User::all();

        return view('projects.show', [
            'project' => $project,
            'users' => $users
        ]);
    }

    /**
     * Supprime un projet de la base de données.
     */
    public function destroy(Project $project)
    {
        // On vérifie l'autorisation
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Projet supprimé avec succès !');
    }
}
