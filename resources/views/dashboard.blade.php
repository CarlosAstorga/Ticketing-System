@extends('templates.main')
@section('title', 'Dashboard')
@section('content')
<div class="row g-3 mb-3">
    <div class="col-12">
        <canvas id="chart" style="max-height: 69vh; width: auto"></canvas>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12 col-sm-6 col-lg-3">
        <x-card.main class="border-3">
            <x-card.body class="dash-card">
                <div>
                    <p class="card-title fs-1 mb-0">{{ $tickets->open }}</p>
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
                    <p class="card-title fs-1 mb-0">{{ $tickets->pending }}</p>
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
                    <p class="card-title fs-1 mb-0">{{ $tickets->solving }}</p>
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
                    <p class="card-title fs-1 mb-0">{{ $tickets->solved }}</p>
                    <p class="card-text lead fs-5">Tickets resueltos</p>
                </div>
                <i class="far fa-check-circle text-midnight dash-card-icon"></i>
            </x-card.body>
        </x-card.main>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/chart.js') }}" defer></script>
@endsection