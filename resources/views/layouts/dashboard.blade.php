<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style simple pour la sidebar */
        body {
            font-size: .875rem;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            /* Hauteur de la barre de navigation du haut */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('dashboard') }}">TaskManager</a>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link px-3 text-white">Déconnexion</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            {{-- COLONNE DE LA SIDEBAR --}}
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">
                                <span data-feather="home"></span>
                                Tableau de bord / Projets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                <span data-feather="user"></span>
                                Mon Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clients.index') }}">
                                <span data-feather="briefcase"></span>
                                Clients
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="settings"></span>
                                Paramètres (futur)
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- COLONNE DU CONTENU PRINCIPAL --}}
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace() // Pour activer les icônes
    </script>
</body>

</html>
