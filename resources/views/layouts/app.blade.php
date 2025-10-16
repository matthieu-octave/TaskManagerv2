<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">TaskManager</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @auth
                        @can('view-admin-panel')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.messages.index') }}">Messages</a>
                        </li>
                        @endcan

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                            </form>
                        </li>
                        @endauth

                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                        </li>
                        @endguest
                    </ul>
            </div>
        </div>
    </nav>


    <main class="container mt-4">
        @yield('content')
    </main>

</body>

</html>
