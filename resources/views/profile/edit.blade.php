@extends('layouts.dashboard')

@section('content')
<h2>Mon Profil</h2>
<hr>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"> {{-- Très important !--}}
            @csrf
            @method('PUT')

            {{-- Affichage de l'avatar actuel --}}
            @if ($user->avatar)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" width="100"
                    height="100">
            </div>
            @endif

            {{-- Champ Avatar --}}
            <div class="mb-3">
                <label for="avatar" class="form-label">Changer l'avatar</label>
                <input class="form-control @error('avatar') is-invalid @enderror" type="file" id="avatar" name="avatar">
                @error('avatar')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Champ Nom --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Champ Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h4>Changer le mot de passe</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('profile.updatePassword') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="current_password" class="form-label">Mot de passe actuel</label>
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                    id="current_password" name="current_password" required>
                @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" required>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
        </form>
    </div>
</div>
@endsection
