@extends('layouts.dashboard')

@section('content')
    {{-- Affichage du message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- En-tête de la page --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Liste des Clients</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">Ajouter un client</a>
    </div>

    {{-- Tableau des clients --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-secondary btn-sm">Modifier</a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun client trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
