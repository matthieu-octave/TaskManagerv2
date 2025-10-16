@extends('layouts.dashboard')

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Projets au total</h5>
                <p class="display-4 fw-bold">{{ $projectCount }}</p>
                <a href="{{ route('projects.create') }}" class="btn btn-primary">Créer un nouveau projet</a>
            </div>
        </div>
    </div>
    {{-- Vous pourriez ajouter d'autres cartes de résumé ici plus tard (ex: tâches, etc.) --}}
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Tableau de bord</h1>
    <div>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">Créer un projet</a>
        <a href="{{ route('projects.trash') }}" class="btn btn-outline-secondary">Corbeille</a>
    </div>

</div>

<hr>
<div class="d-flex justify-content-end mb-3">
    <div class="btn-group" role="group">
        <a href="{{ route('dashboard', ['status' => 'Actif']) }}"
            class="btn {{ $statusFilter == 'Actif' ? 'btn-primary' : 'btn-outline-primary' }}">
            Actifs
        </a>
        <a href="{{ route('dashboard', ['status' => 'Archivé']) }}"
            class="btn {{ $statusFilter == 'Archivé' ? 'btn-primary' : 'btn-outline-primary' }}">
            Archivés
        </a>
    </div>
</div>
<div class="mb-3">
    <strong>Filtrer par étiquette :</strong>
    <a href="{{ route('dashboard') }}" class="btn btn-sm {{ !$currentTag ? 'btn-primary' : 'btn-outline-primary' }}">
        Toutes
    </a>
    @foreach ($allTags as $tag)
    <a href="{{ route('dashboard', ['tag' => $tag->name]) }}"
        class="btn btn-sm {{ $currentTag == $tag->name ? 'btn-primary' : 'btn-outline-primary' }}">
        {{ $tag->name }}
    </a>
    @endforeach
</div>
<div class="card">
    <div class="card-header">
        <h2 class="h5 mb-0">Mes projets</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    {{-- En-tête pour la colonne TITRE --}}
                    <th scope="col">
                        @php
                        // Si on trie déjà par titre en ascendant, le prochain clic sera descendant. Sinon, ascendant.
                        $directionForTitle = ($sortColumn == 'title' && $sortDirection == 'asc') ? 'desc' : 'asc';
                        @endphp
                        <a href="{{ route('dashboard', ['sort' => 'title', 'direction' => $directionForTitle]) }}"
                            class="text-white text-decoration-none">
                            Titre
                            {{-- On affiche la flèche uniquement si on trie par cette colonne --}}
                            @if ($sortColumn == 'title')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                            @endif
                        </a>
                    </th>

                    {{-- En-tête pour la colonne DATE DE CRÉATION --}}
                    <th scope="col">
                        @php
                        // Si on trie déjà par date en ascendant, le prochain clic sera descendant. Sinon, ascendant.
                        $directionForDate = ($sortColumn == 'created_at' && $sortDirection == 'asc') ? 'desc' : 'asc';
                        @endphp
                        <a href="{{ route('dashboard', ['sort' => 'created_at', 'direction' => $directionForDate]) }}"
                            class="text-white text-decoration-none">
                            Date de création
                            {{-- On affiche la flèche uniquement si on trie par cette colonne --}}
                            @if ($sortColumn == 'created_at')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                            @endif
                        </a>
                    </th>
                    <th>Client</th>

                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                <tr>
                    {{-- Dans la boucle @forelse du tableau, modifiez la cellule du titre --}}

                    <td>
                        <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                        <div class="mt-1">
                            @foreach ($project->tags as $tag)
                            <span class="badge bg-info">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>{{ $project->created_at->format('d/m/Y') }}</td>

                    <td>{{ ($project->client) ? $project->client->name : 'Aucun client associé'}}</td>

                    <td>
                        <div class="d-flex gap-2 justify-content-end">

                            {{-- Archiver/Désarchiver le projet en fonction de son statut--}}
                            <form action="{{ route('projects.archive', $project) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-info btn-sm">
                                    {{-- Change the button text based on the current status --}}
                                    {{ $project->status === 'Actif' ? 'Archiver' : 'Désarchiver' }}
                                </button>
                            </form>
                            {{-- End Archiver/Désarchiver --}}

                            <a href="{{ route('projects.edit', $project) }}"
                                class="btn btn-secondary btn-sm">Modifier</a>
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
