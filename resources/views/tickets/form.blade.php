@extends('templates.main')
@section('styles')
<link href="{{ asset('css/ticket.css') }}" rel="stylesheet">
@endsection
@section('header', $ticket->exists ? 'Editar ticket' : 'Nuevo ticket')
@section('route', route('tickets.index'))
@section('button', '')
@section('content')
@can('ticket_create')
<div class="card">
    <div class="card-header">Datos generales</div>
    <div class="card-body my-3">
        <form id="form" method="POST" action="@if($ticket->exists) {{ route('tickets.update', $ticket->id) }} @else {{ route('tickets.store') }} @endif">
            @if($ticket->exists) @method('PUT') @endif
            @csrf

            <!-- Title -->
            <div class="row mb-3 align-items-center">
                <label for="title" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Asunto</label>
                <div class="col-12 col-sm-9 col-lg-6">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $ticket->title) }}" autofocus maxlength="100">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Category -->
            <div class="row mb-3 align-items-center">
                <label for="category" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Categoría</label>
                <div class="col-12 col-sm-9 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text input-group-sm"><i class="fas fa-chart-pie"></i></span>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" id="category">
                            @foreach($catalogs['category'] as $category)
                            @if (old('category_id') == $category->id)
                            <option value="{{ $category->id }}" selected>
                                {{ $category->title }}
                            </option>
                            @elseif ($ticket->category_id == $category->id && old('category_id') == null)
                            <option value="{{ $category->id }}" selected>
                                {{ $category->title }}
                            </option>
                            @else
                            <option value="{{ $category->id }}">
                                {{ $category->title }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Date -->
            <div class="row mb-3 align-items-center">
                <label for="due_date" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Fecha requerido</label>
                <div class="col-12 col-sm-9 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text input-group-sm">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" id="due_date" min="{{ date('Y-m-d') }}" value="{{ old('due_date', explode(' ', $ticket->due_date)[0]) }}">
                        @error('due_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            @can('user_assigment')
            <!-- Priority -->
            <div class="row mb-3 align-items-center">
                <label for="priority" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Prioridad</label>
                <div class="col-12 col-sm-9 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text input-group-sm"><i class="fas fa-exclamation-triangle"></i>
                        </span><select name="priority_id" class="form-select @error('priority_id') is-invalid @enderror" id="priority">
                            @foreach($catalogs['priority'] as $priority)
                            @if (old('priority_id') == $priority->id)
                            <option value="{{ $priority->id }}" selected>
                                {{ $priority->title }}
                            </option>
                            @elseif ($ticket->priority_id == $priority->id && old('priority_id') == null)
                            <option value="{{ $priority->id }}" selected>
                                {{ $priority->title}}
                            </option>
                            @else
                            <option value="{{ $priority->id }}">
                                {{ $priority->title}}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('priority_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Developer -->
            <div class="row mb-3 align-items-center">
                <label for="developer" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Resolverá</label>
                <div class="col-12 col-sm-9 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text input-group-sm"><i class="fas fa-user"></i></span>
                        <select name="developer_id" class="form-select @error('developer_id') is-invalid @enderror" id="developer">
                            @if (count($catalogs['user']) <= 0) <option disabled>No hay usuarios disponibles</option>@endif
                                <option hidden value="0"></option>
                                @foreach($catalogs['user'] as $user)
                                @if (old('developer_id') == $user->id)
                                <option value="{{ $user->id }}" selected>{{ $user->email }}</option>
                                @elseif ($ticket->developer_id == $user->id && old('developer_id') == null)
                                <option value="{{ $user->id }}" selected>{{ $user->email }}</option>
                                @else
                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                                @endif
                                @endforeach
                        </select>
                        @error('developer_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Project -->
            <div class="row mb-3 align-items-center">
                <label for="project" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Proyecto</label>
                <div class="col-12 col-sm-9 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text input-group-sm">
                            <i class="fas fa-archive"></i>
                        </span>
                        <select name="project_id" class="form-select @error('project_id') is-invalid @enderror" id="project">
                            @if (count($catalogs['project']) <= 0) <option disabled>No hay proyectos disponibles</option>@endif
                                <option hidden value="0"></option>
                                @foreach($catalogs['project'] as $project)
                                @if (old('project_id') == $project->id)
                                <option value="{{ $project->id }}" selected>
                                    {{ $project->title }}
                                </option>
                                @elseif ($ticket->project_id == $project->id && old('project_id') == null)
                                <option value="{{ $project->id }}" selected>
                                    {{ $project->title }}
                                </option>
                                @else
                                <option value="{{ $project->id }}">
                                    {{ $project->title }}
                                </option>
                                @endif
                                @endforeach
                        </select>
                        @error('project_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            @endcan

            @if(Auth::user()->can('ticket_close') || Auth::user()->can('ticket_resolve'))
            <!-- Status -->
            <div class="row mb-3 align-items-center">
                <label for="status" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Estatus</label>
                <div class="col-12 col-sm-9 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text input-group-sm">
                            <i class="far fa-eye"></i>
                        </span>
                        <select name="status_id" class="form-select @error('status_id') is-invalid @enderror" id="status">
                            @foreach($catalogs['status'] as $status)
                            @if (old('status_id') == $status->id)
                            <option value="{{ $status->id }}" selected>
                                {{ $status->title }}
                            </option>
                            @elseif ($ticket->status_id == $status->id && old('status_id') == null)
                            <option value="{{ $status->id }}" selected>
                                {{ $status->title }}
                            </option>
                            @else
                            <option value="{{ $status->id }}">
                                {{ $status->title }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('status_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            <div class="row mb-3 align-items-center">
                <label for="name" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Descripción</label>
                <div class="col-12 col-sm-9 col-lg-6">
                    <textarea id="description" style="resize: none;" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" maxlength="150">{{ old('description', $ticket->description) }}</textarea>
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
@endcan
@endsection