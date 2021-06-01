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
    @yield('styles')
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-1 col-lg-2 me-0 px-3" href="/">T-System</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-1 col-lg-2 col-xxl-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky d-flex flex-column">
                    <ul class="nav flex-column">
                        <li class="nav-item border-bottom text-center">
                            <a href="{{ route('user.profile') }}" class="nav-link py-3 @if($module == 'profile') active @endif" title="Perfil">
                                <img src="{{ auth()->user()->avatar() }}" alt="avatar" width="36" height="36" class="rounded-circle image-cover"><strong class="d-md-none d-lg-inline-block ms-2">{{ auth()->user()->name }}</strong>
                            </a>
                        </li>
                        <li class="nav-item ms-2 overflow-hidden">
                            <a href="/" class="nav-link py-3 @if($module == 'dashboard') active @endif" title="Dashboard">
                                <i class="fas fa-home icon"></i><span class="d-md-none d-lg-inline-block ms-2">Dashboard</span>
                            </a>
                        </li>
                        @can('user_access')
                        <li class="nav-item ms-2">
                            <a href="{{ route('admin.users.index') }}" class="nav-link py-3 @if($module == 'users') active @endif" title="Usuarios">
                                <i class="fas fa-users icon"></i><span class="d-md-none d-lg-inline-block ms-2">Usuarios</span>
                            </a>
                        </li>
                        @endcan
                        @can('role_access')
                        <li class="nav-item ms-2">
                            <a href="{{ route('roles.index') }}" class="nav-link py-3 @if($module == 'roles') active @endif" title="Roles">
                                <i class="fas fa-tags icon"></i></i><span class="d-md-none d-lg-inline-block ms-2">Roles</span>
                            </a>
                        </li>
                        @endcan
                        @can('project_access')
                        <li class="nav-item ms-2">
                            <a href="{{ route('projects.index') }}" class="nav-link py-3 @if($module == 'projects') active @endif" title="Proyectos">
                                <i class="fas fa-project-diagram icon"></i><span class="d-md-none d-lg-inline-block ms-2">Proyectos</span>
                            </a>
                        </li>
                        @endcan
                        @can('ticket_access')
                        <li class="nav-item ms-2">
                            <a href="{{ route('tickets.index') }}" class="nav-link py-3 @if($module == 'tickets') active @endif" title="Tickets">
                                <i class="fas fa-ticket-alt icon"></i><span class="d-md-none d-lg-inline-block ms-2">Tickets</span>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item ms-2">
                            <a href="{{ route('logout') }}" title="Salir" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="nav-link py-3">
                                <i class="fas fa-sign-out-alt icon"></i><span class="d-md-none d-lg-inline-block ms-2">Salir</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-11 ms-sm-auto col-lg-10 col-xxl-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('header')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @section('buttons')
                        <div class="btn-group">
                            <a type="button" class="btn btn-sm btn-outline-secondary" href="@yield('route')"><i class="fas fa-th-list"></i></a>
                            <button class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('form').submit();">Guardar</button>
                        </div>
                        @show
                        @section('button')
                        <a type="button" class="btn btn-sm btn-outline-secondary" href="@yield('route')">@yield('link')</a>
                        @show
                    </div>
                </div>
                @section('contentHeader')
                @show
                @section('content')
                <div id="@yield('component')"></div>
                @show
            </main>
        </div>
    </div>
    <script src=" {{ asset('js/app.js') }}" defer></script>
    @yield('scripts')
</body>

</html>