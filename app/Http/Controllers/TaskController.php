<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Mail\TaskAssignedMail;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_user_id' => 'nullable|exists:users,id'
        ]);
        $task = $project->tasks()->create($validated);

        // Si la tâche a été assignée à un utilisateur
        if ($task->assignedUser) {
            // On envoie l'email de manière synchrone
            Mail::to($task->assignedUser)->send(new TaskAssignedMail($task));
        }

        return back()->with('success', 'Tâche ajoutée !');
    }

    public function update(Task $task)
    {
        $this->authorize('update', $task->project);
        $task->update(['is_done' => !$task->is_done]);
        return back()->with('success', 'Tâche mise à jour !');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task->project);
        $task->delete();
        return back()->with('success', 'Tâche supprimée !');
    }
}
