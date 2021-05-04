<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ticketing System</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">T-System</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 col-xxl-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky d-flex flex-column p-3">
                    <ul id="sidebarLinks" class="nav flex-column">

                        <li class="nav-item">
                            <a class="btn btn-toggle d-flex justify-content-center" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                                <img src="{{ auth()->user()->avatar() }}" alt="avatar" width="32" height="32" class="rounded-circle me-2">
                                <strong>{{ auth()->user()->name }}</strong>
                            </a>
                            <div class="collapse show" id="home-collapse">
                                <ul class="btn-toggle-nav list-unstyled">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <span class="fas fa-address-card me-2 fs-6 w-9"></span>Mi perfil
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();" class="nav-link">
                                            <span class="fas fa-sign-out-alt me-2 fs-6 w-9"></span>Cerrar sesión
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="nav-item">
                            <a class="nav-link  @if($module == 'dashboard') active @endif" href="/">
                                <span class="fas fa-home me-2 fs-6 w-9"></span>Dashboard
                            </a>
                        </li>
                        @can('user_management_access')

                        <li class="nav-item">
                            <a class="nav-link  @if($module == 'users') active @endif" href="{{ route('admin.users.index') }}">
                                <span class="fas fa-users me-2 fs-6 w-9"></span>Usuarios
                            </a>
                        </li>
                        @endcan
                        @can('project_access')

                        <li class="nav-item">
                            <a class="nav-link  @if($module == 'projects') active @endif" href="{{ route('projects.index') }}">
                                <span class="fas fa-project-diagram me-2 fs-6 w-9"></span>Proyectos
                            </a>
                        </li>
                        @endcan
                        @can('ticket_access')

                        <li class="nav-item">
                            <a class="nav-link  @if($module == 'ticket') active @endif" href="{{ route('tickets.index') }}">
                                <span class="fas fa-ticket-alt me-2 fs-6 w-9"></span>Tickets
                            </a>
                        </li>
                        @endcan

                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 col-xxl-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src=" {{ asset('js/app.js') }}" defer></script>
</body>

</html>