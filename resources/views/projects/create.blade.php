@extends('layouts.dashboard')

@section('content')
<h2>Créer un nouveau projet</h2>

<form action="{{ route('projects.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
            value="{{ old('title') }}">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="client_id" class="form-label">Associer à un client (Optionnel)</label>
        <select class="form-select" id="client_id" name="client_id">
            <option value="">Aucun client</option>
            @foreach ($clients as $client)
            <option value="{{ $client->id }}" @selected(old('client_id', $project->client_id ?? '') == $client->id)>
                {{ $client->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Étiquettes</label>
        <div>
            @foreach ($tags as $tag)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}"
    @if(is_array(old('tags')) && in_array($tag->id, old('tags'))) checked @endif>
                <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Créer le projet</button>
</form>
@endsection
