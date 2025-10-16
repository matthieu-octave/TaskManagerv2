<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Policies\ProjectPolicy;
use Illuminate\Validation\Rule;
use App\Models\Client;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Affiche la liste des projets de l'utilisateur avec une option de tri.
     */
    public function index(Request $request)
    {
        // On récupère le filtre de statut depuis l'URL, par défaut 'Actif'
        $statusFilter = $request->query('status', 'Actif');


        // 1. On récupère les paramètres de tri depuis l'URL, avec des valeurs par défaut.
        $sortColumn = $request->query('sort', 'created_at'); // Par défaut, on trie par date de création
        $sortDirection = $request->query('direction', 'desc'); // Par défaut, du plus récent au plus ancien
        // Petite validation pour éviter les erreurs si l'URL est modifiée manuellement
        if (!in_array($sortColumn, ['title', 'created_at'])) {
            $sortColumn = 'created_at';
        }
        // 2. On construit la requête Eloquent en appliquant le tri.
        $projects = Auth::user()
            ->projects()
            ->filterByStatus($statusFilter) // <-- On utilise notre nouveau scope !
            ->orderBy($sortColumn, $sortDirection)
            ->get();
        // On récupère le nombre total de projets
        $projectCount = $projects->count();
        // 3. On passe les projets triés à la vue et les paramètres de tri actuels à la vue
        return view('pages.dashboard', [
            'projects' => $projects,
            'projectCount' => $projectCount,
            'statusFilter' => $statusFilter, // On passe le filtre actuel à la vue
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection
        ]);
    }

    public function edit(Project $project)
    {
        // On vérifie l'autorisation via la Policy avant d'afficher la page
        $this->authorize('update', $project);
        $clients = Client::all();
        return view('projects.edit', ['project' => $project, 'clients' => $clients]);
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
            'client_id' => 'nullable|exists:clients,id',
        ]);

        $project->update($validated);

        return redirect()->route('dashboard')->with('success', 'Projet mis à jour avec succès !');
    }

    public function create()
    {
        $clients = Client::all();
        return view('projects.create', ['clients' => $clients]);
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
            'client_id' => 'nullable|exists:clients,id',
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

    /**
     * Archives or unarchives a specific project.
     */
    public function archive(Project $project)
    {
        // 1. Authorize the action (only the owner can archive)
        $this->authorize('update', $project);

        // 2. Determine the new status
        $newStatus = $project->status === 'Actif' ? 'Archivé' : 'Actif';
        $message = $project->status === 'Actif' ? 'Projet archivé avec succès !' : 'Projet restauré avec succès !';

        // 3. Update the project's status
        $project->update(['status' => $newStatus]);

        // 4. Redirect back with a success message
        return back()->with('success', $message);
    }

    public function trash()
    {
        // Récupère uniquement les projets "soft-deleted" de l'utilisateur
        $projects = Auth::user()->projects()->onlyTrashed()->get();
        return view('projects.trash', ['projects' => $projects]);
    }

    public function restore($id)
    {
        // On doit utiliser withTrashed() pour trouver le projet, car par défaut Eloquent les ignore
        $project = Auth::user()->projects()->onlyTrashed()->findOrFail($id);
        $this->authorize('delete', $project); // On peut réutiliser une policy existante

        $project->restore();

        return redirect()->route('projects.trash')->with('success', 'Projet restauré avec succès !');
    }
}
