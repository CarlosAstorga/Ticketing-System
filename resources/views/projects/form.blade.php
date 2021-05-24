@extends('templates.main')
@section('header', $project->exists ? 'Editar proyecto' : 'Nuevo proyecto')
@section('button', '')
@section('route', route('projects.index'))
@section('content')
<div class="card">
    <div class="card-header">Datos generales</div>
    <div class="card-body my-3 my-sm-5">
        <form id="form" method="POST" action="@if($project->exists) {{ route('projects.update', $project->id) }} @else {{ route('projects.store') }} @endif">
            @if($project->exists) @method('PUT') @endif
            @csrf

            <!-- Title -->
            <div class="row mb-3 align-items-center">
                <label for="title" class="col-12 col-sm-2 text-sm-end mb-2 mb-sm-0 fw-bold">Asunto</label>
                <div class="col-12 col-sm-10 col-lg-8">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $project->title) }}" autofocus maxlength="100">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="row align-items-center">
                <label for="name" class="col-12 col-sm-2 text-sm-end mb-2 mb-sm-0 fw-bold">Descripción</label>
                <div class="col-12 col-sm-10 col-lg-8">
                    <textarea id="description" style="resize: none;" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" maxlength="150">{{ old('description', $project->description) }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

        </form>
    </div>
</div>
@endsection