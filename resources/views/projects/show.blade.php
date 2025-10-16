@extends('layouts.dashboard')
@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm mb-3">Retour</a>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">{{ $project->title }}</h1>
        <p class="card-text">{{ $project->description }}</p>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Ajouter une tâche</h5>
        <form action="{{ route('tasks.store', $project) }}" method="POST">
            @csrf
            <div class="row g-2">
                <div class="col-md-6">
                    <label for="title" class="form-label visually-hidden">Titre</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Titre de la tâche..."
                        required>
                </div>
                <div class="col-md-4">
                    <label for="assigned_user_id" class="form-label visually-hidden">Assigner à</label>
                    <select name="assigned_user_id" id="assigned_user_id" class="form-select">
                        <option value="">Ne pas assigner</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Ajouter</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header">
        <h2>Tâches</h2>
    </div>
    <div class="card-body">
        <ul class="list-group">
            @forelse ($project->tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span style="{{ $task->is_done ? 'text-decoration: line-through;' : '' }}">{{ $task->title }}
                    @if ($task->assignedUser)
                    <small class="badge bg-secondary">{{ $task->assignedUser->name }}</small>
                    @endif
                </span>
                <div class="d-flex gap-2">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">@csrf @method('PATCH')<button
                            type="submit" class="btn btn-success btn-sm">{{ $task->is_done ? 'Invalider' : 'Valider'
                            }}</button></form>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">@csrf @method('DELETE')<button
                            type="submit" class="btn btn-danger btn-sm">Supprimer</button></form>
                </div>
            </li>
            @empty
            <li class="list-group-item">Aucune tâche pour ce projet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
