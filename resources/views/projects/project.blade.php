@extends('templates.main')
@section('header', 'Proyecto #' . $project->id)
@section('buttons', '')
@section('button', '')
@section('contentHeader')
<div class="row align-items-center mt-5 pt-5">
    <p class="col-sm-2 text-md-end form-label fw-bold mb-sm-1 mb-md-0">Título</p>
    <p class="col-sm-10 mb-sm-1 mb-md-0">{{ $project->title }}</p>
</div>
<div class="row align-items-center mb-5 pb-5">
    <p class="col-sm-2 text-md-end form-label fw-bold mb-sm-1 mb-md-0">Descripción</p>
    <p class="col-sm-10 mb-sm-1 mb-md-0">{{ $project->description }}</p>
</div>
<h2 class="mb-3">Tickets relacionados</h2>
@endsection
@section('component', 'project-tickets')