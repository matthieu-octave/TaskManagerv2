@extends('layouts.dashboard')
@section('content')
<h2>Modifier le projet</h2>
<form action="{{ route('projects.update', $project) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="title" class="form-label">Titre du projet</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $project->title) }}">
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
                @if(in_array($tag->id, old('tags', $project->tags->pluck('id')->toArray() ?? []))) checked @endif
            >
            <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
        </div>
    @endforeach
    </div>
</div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"
            rows="5">{{ old('description', $project->description) }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Mettre à jour</button>
</form>
@endsection
