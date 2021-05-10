@extends('templates.main')
@section('header', $ticket->exists ? 'Editar ticket' : 'Nuevo ticket')
@section('route', route('tickets.index'))
@section('button', '')
@section('content')
@can('ticket_create')
<form id="form" method="POST" class="row" action="@if($ticket->exists) {{ route('tickets.update', $ticket->id) }} @else {{ route('tickets.store') }} @endif">
    @if($ticket->exists) @method('PUT') @endif
    @csrf

    <!-- Title -->
    <div class="col-12 @cannot('user_assigment') col-xl-6 @endcannot mb-3">
        <label for="title" class="form-label fw-bold">Asunto</label>
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $ticket->title) }}" autofocus maxlength="100">
        @error('title')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <!-- Category -->
    <div class="col-sm-12 col-md-12 @if(Auth::user()->can('user_assigment')) col-xl-4 @else col-xl-3 @endif mb-3">
        <label for="category" class="form-label fw-bold">Categoría</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-chart-pie"></i></span>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" id="category">
                <option hidden value="0"></option>
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

    <!-- Date -->
    <div class="col-sm-12 col-md-12 @if(Auth::user()->can('user_assigment')) col-xl-4 @else col-xl-3 @endif mb-3">
        <label for="due_date" class="form-label fw-bold">Fecha requerido</label>
        <div class="input-group">
            <span class="input-group-text">
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

    @can('user_assigment')
    <!-- Priority -->
    <div class="col-sm-12 col-md-12 col-xl-4 mb-3">
        <label for="priority" class="form-label fw-bold">Prioridad</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i>
            </span><select name="priority_id" class="form-select @error('priority_id') is-invalid @enderror" id="priority">
                <option hidden value="0"></option>
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

    <!-- Developer -->
    <div class="col-sm-12 col-md-12 col-xl mb-3">
        <label for="developer" class="form-label fw-bold">Resolverá</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
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

    <!-- Project -->
    <div class="col-sm-12 col-md-12 col-xl mb-3">
        <label for="project" class="form-label fw-bold">Proyecto</label>
        <div class="input-group">
            <span class="input-group-text">
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
    @endcan

    @if(Auth::user()->can('ticket_close') || Auth::user()->can('ticket_resolve'))
    <!-- Status -->
    <div class="col-sm-12 col-md col-xl mb-3">
        <label for="status" class="form-label fw-bold">Estatus</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="far fa-eye"></i>
            </span>
            <select name="status_id" class="form-select @error('status_id') is-invalid @enderror" id="status">
                <option hidden value="0"></option>
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
    @endif

    <div class="col-12 mb-3">
        <label for="name" class="form-label fw-bold">Descripción</label>
        <textarea id="description" style="resize: none;" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" maxlength="150">{{ old('description', $ticket->description) }}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</form>
@endcan
@endsection