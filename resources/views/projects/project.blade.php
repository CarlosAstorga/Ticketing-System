@extends('templates.main')
@section('header', 'Proyecto #' . $project->id)
@section('buttons')
<div class="btn-group">
    <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ route('projects.index') }}"><i class="fas fa-th-list"></i></a>
</div>
@endsection
@section('button', '')
@section('content')
<div class="card">
    <div class="card-header">Datos generales</div>
    <div class="card-body my-3 my-sm-5">
        <div class="row mb-2">
            <p class="col-12 col-sm-4 text-sm-end mb-0 fw-bold">Título</p>
            <p class="col-12 col-sm-8 mb-0">{{ $project->title }}</p>
        </div>
        <div class="row mb-2">
            <p class="col-12 col-sm-4 text-sm-end mb-0 fw-bold">Descripción</p>
            <p class="col-12 col-sm-8 mb-0">{{ $project->description }}</p>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">Tickets</div>
    <div class="card-body">
        <div id="project-tickets"></div>
    </div>
</div>
@endsection