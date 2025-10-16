@extends('layouts.app')

@section('content')
<div class="container my-5">
    {{-- Le conteneur principal qui a les bordures et l'ombre --}}
    <div class="row align-items-center rounded-3 border shadow-lg overflow-hidden">
        {{-- Colonne de gauche : Texte et boutons centrés --}}
        <div class="col-lg-7 p-5">
            <div class="text-center text-lg-center">
                <h1 class="display-4 fw-bold lh-1 mb-3">TaskManager</h1>
                <p class="badge text-bg-success">{{ $userCount }} utilisateurs connectés</p>
                <p class="lead">Organisez vos projets, assignez des tâches et collaborez efficacement avec votre équipe. L'outil simple et puissant pour ne plus rien oublier.</p>
                {{-- Appels à l'action principaux --}}
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-md-2">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">S'inscrire</a>
                </div>
            </div>
            <p class="text-muted text-center mt-5">
                Une question ? <a href="{{ route('contact.create') }}">Contactez-nous</a>.
            </p>
        </div>
        {{-- Colonne de droite : Visuel sans marges --}}
        <div class="col-lg-5 p-0">
            <img src="{{ asset('images/taskmanager.jpg') }}" class="img-fluid" alt="Aperçu du tableau de bord" style="height: 100%; object-fit: cover;">
        </div>
    </div>
</div>
@endsection
