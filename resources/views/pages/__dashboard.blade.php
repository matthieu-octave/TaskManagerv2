@extends('layouts.dashboard')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Tableau de bord</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">Créer un projet</a>
    </div>

    <hr>

    <div class="card">
        <div class="card-header">
            <h2 class="h5 mb-0">Mes projets</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">
                            <a href="{{ route('dashboard', ['sort' => 'title', 'direction' => 'asc']) }}" class="text-white text-decoration-none">Titre</a>
                        </th>
                        <th scope="col">
                            <a href="{{ route('dashboard', ['sort' => 'created_at', 'direction' => 'desc']) }}" class="text-white text-decoration-none">Date de création</a>
                        </th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>
                                <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                            </td>
                            <td>{{ $project->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-secondary btn-sm">Modifier</a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Vous n'avez encore créé aucun projet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
