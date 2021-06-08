@extends('templates.main')
@if(count($tickets)) @section('title', 'Dashboard') @else @section('header', '') @endif
@section('content')
@if(count($tickets))
<div class="row g-3 mb-3">
    <div class="col-12">
        <canvas id="chart" style="max-height: 69vh; width: auto"></canvas>
    </div>
</div>

<div id="cards" class="row g-3 mb-3 d-none">
    <div class="col-12 col-sm-6 col-lg-3">
        <x-card.main class="border-3">
            <x-card.body class="dash-card">
                <div>
                    <p class="card-title fs-1 mb-0">{{ $tickets[1] ?? 0 }}</p>
                    <p class="card-text lead fs-5">Tickets abiertos</p>
                </div>
                <i class="fas fa-plus-circle text-midnight dash-card-icon"></i>
            </x-card.body>
        </x-card.main>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <x-card.main class="border-3">
            <x-card.body class="dash-card">
                <div>
                    <p class="card-title fs-1 mb-0">{{ $tickets[3] ?? 0 }}</p>
                    <p class="card-text lead fs-5">Tickets pendientes</p>
                </div>
                <i class="far fa-pause-circle text-midnight dash-card-icon"></i>
            </x-card.body>
        </x-card.main>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <x-card.main class="border-3">
            <x-card.body class="dash-card">
                <div>
                    <p class="card-title fs-1 mb-0">{{ $tickets[2] ?? 0 }}</p>
                    <p class="card-text lead fs-5">Tickets en proceso</p>
                </div>
                <i class="far fa-play-circle text-midnight dash-card-icon"></i>
            </x-card.body>
        </x-card.main>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <x-card.main class="border-3">
            <x-card.body class="dash-card">
                <div>
                    <p class="card-title fs-1 mb-0">{{ $tickets[4] ?? 0 }}</p>
                    <p class="card-text lead fs-5">Tickets resueltos</p>
                </div>
                <i class="far fa-check-circle text-midnight dash-card-icon"></i>
            </x-card.body>
        </x-card.main>
    </div>
</div>
@else
<x-card.main class="border-light text-center mt-3">
    <x-card.header>
        <i class="fas fa-exclamation-circle text-midnight fs-2"></i>
    </x-card.header>
    <x-card.body class="my-3 my-sm-5">
        <h5 class="display-6 text-midnight">Sin tickets registrados</h5>
        @if(auth()->user()->hasPermission('ticket_create'))
        <p class="lead">Crea tu primer ticket y comienza a darle seguimiento!</p>
        <a href="{{ route('tickets.create') }}" type="button" class="btn btn-sm btn-outline-secondary">Crear ticket</a>
        @else 
        <p class="lead">Ponte en contacto con un <span class="text-blue">Administrador</span> para comenzar a crear tus tickets!</p>
        @endif
    </x-card.body>
</x-card.main>
@endif
@endsection
@section('scripts')
<script src="{{ asset('js/chart.js') }}" defer></script>
@endsection