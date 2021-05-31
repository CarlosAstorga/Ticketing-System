@extends('templates.main')
@section('header', 'Dashboard')
@section('buttons', '')
@section('button', '')
@section('content')
<!-- Cards row -->
@if($tickets->tickets_count)
<div class="row g-3 mb-3">

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card @if(!$tickets->open) text-muted @endif">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p id="open" class="card-title fs-1 mb-0">{{ $tickets->open }}</p>
                    <p class="card-text lead fs-5">Tickets abiertos</p>
                </div>
                <i class="fas fa-ticket-alt dash-card-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card @if(!$tickets->pending) text-muted @endif">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p id="pending" class="card-title fs-1 mb-0">{{ $tickets->pending }}</p>
                    <p class="card-text lead fs-5">Tickets pendientes</p>
                </div>
                <i class="fas fa-ticket-alt text-danger dash-card-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card @if(!$tickets->solving) text-muted @endif">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p id="solving" class="card-title fs-1 mb-0">{{ $tickets->solving }}</p>
                    <p class="card-text lead fs-5">Tickets en proceso</p>
                </div>
                <i class="fas fa-ticket-alt text-warning dash-card-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card @if(!$tickets->closed) text-muted @endif">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p id="closed" class="card-title fs-1 mb-0">{{ $tickets->closed }}</p>
                    <p class="card-text lead fs-5">Tickets cerrados</p>
                </div>
                <i class="fas fa-ticket-alt text-orange dash-card-icon"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-6">
        <div class="card h-100">
            <div class="card-header lead">Tickets recientes</div>
            <div class="card-body">
                @if($tickets->tickets_count)
                @foreach($tickets->submittedTickets as $ticket)
                @php
                $statusId = $ticket->status->id;
                switch ($statusId) {
                case 1:
                $width = '25%';
                $class = 'bg-dark';
                break;
                case 2:
                $width = '50%';
                $class = 'bg-warning';
                break;
                case 3:
                $width = '50%';
                $class = 'bg-danger';
                break;
                case 4:
                $width = '75%';
                $class = 'bg-info';
                break;
                case 5:
                $width = '100%';
                $class = 'bg-orange';
                break;

                default:
                $class = 'bg-dark';
                $width = '25%';
                break;
                }
                @endphp
                <div class="row mb-3 align-items-center">
                    <a href="{{ route('tickets.show', $ticket->id) }}" class="col-12 col-lg-4 text-lg-end mb-2 mb-lg-0 text-decoration-none text-dark">{{ $ticket->title }}</a>
                    <div class="col-12 col-lg-8">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped {{ $class }}" role="progressbar" style="width: {{ $width }}"><strong>{{ $ticket->status->title }}</strong></div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <canvas id="chart" style="max-height: 300px; width:100%;" data-open="{{ $tickets->open }}" data-solving="{{ $tickets->solving }}" data-pending="{{ $tickets->pending }}" data-solved="{{ $tickets->solved }}" data-closed="{{ $tickets->closed }}"></canvas>
            </div>
        </div>
    </div>
</div>
@else
<div class="card border-light text-center">
    <div class="card-header bg-info">
        <i class="fas fa-exclamation-circle text-white fs-4"></i>
    </div>
    <div class="card-body my-3 my-sm-5">
        <h5 class="card-title">Sin tickets registrados!</h5>
        <p class="card-text">Crea tu primer ticket y empieza a darle seguimiento!</p>
        <a href="{{ route('tickets.create') }}" class="btn btn-outline-secondary">Crear ticket</a>
    </div>
</div>
@endif
@endsection
@if($tickets->tickets_count)
@section('scripts')
<script src="{{ asset('js/chart.js') }}" defer></script>
@endsection
@endif