<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ticketing System</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>

    <nav class="sidenav">
        <a href="" class="item" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
            <i class="fas fa-chart-pie"></i>
        </a>
        <a href="" class="item" title="Usuarios" data-bs-toggle="tooltip" data-bs-placement="right">
            <i class="fas fa-users"></i>
        </a>
        <a href="" class="item" title="Proyectos" data-bs-toggle="tooltip" data-bs-placement="right">
            <i class="fas fa-project-diagram"></i>
        </a>
        <a href="" class="item" title="Tickets" data-bs-toggle="tooltip" data-bs-placement="right">
            <i class="fas fa-tasks"></i>
        </a>
    </nav>

    <script src=" {{ asset('js/app.js') }}" defer></script>
    <script src=" {{ asset('js/tooltip.js') }}" defer></script>
</body>

</html>