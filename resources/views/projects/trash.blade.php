@extends('layouts.dashboard')
@section('content')
    <h1>Corbeille</h1>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm mb-3">Retour</a>
    <div class="card"><div class="card-body">
        <ul class="list-group">
            @forelse ($projects as $project)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $project->title }}
                    <form action="{{ route('projects.restore', $project->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">Restaurer</button>
                    </form>
                </li>
            @empty
                <li class="list-group-item">La corbeille est vide.</li>
            @endforelse
        </ul>
    </div></div>
@endsection
