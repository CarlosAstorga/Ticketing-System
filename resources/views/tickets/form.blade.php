@extends('templates.main')
@section('content')
@can('ticket_create')
<form id="form" method="POST" class="row" action="@if($ticket->exists) {{ route('tickets.update', $ticket->id) }} @else {{ route('tickets.store') }} @endif">
    @if($ticket->exists) @method('PUT') @endif
    @csrf
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@if($ticket->exists)Editar ticket @else Nuevo ticket @endif</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group">
                <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ route('tickets.index')}}">
                    <i class="fas fa-th-list"></i>
                </a>
                <button id="submit" type="submit" class="btn btn-sm btn-outline-secondary">
                    Guardar
                </button>
            </div>
        </div>
    </div>
    <!-- Title -->
    <div class="col-12 @cannot('user_assigment') col-xl-6 @endcannot mb-3">
        <label for="title" class="form-label fw-bold">Asunto</label>
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $ticket->title) }}" autofocus maxlength="100" required>
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
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" id="category" required>
                <option hidden value="0"></option>
                @foreach($catalogs['category'] as $option)
                @if(old('category_id') == $option->id)
                <option value="{{$option->id}}" selected>{{$option->title}}</option>
                @elseif($ticket->category_id == $option->id && old('category_id') == null)
                <option value="{{$option->id}}" selected>{{$option->title}}</option>
                @else
                <option value="{{$option->id}}">{{$option->title}}</option>
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
        <label for="due_date" class="form-label fw-bold">Fecha</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="far fa-calendar-alt"></i>
            </span>
            <input type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" id="due_date" min="{{ date('Y-m-d') }}" value="{{ old('due_date') }}">
            <!-- min="{{ date('Y-m-d') }}" -->
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
            </span><select name="priority_id" class="form-select @error('priority_id') is-invalid @enderror" id="priority" required>
                <option hidden value="0"></option>
                @foreach($catalogs['priority'] as $option)
                @if(old('priority_id') == $option->id)
                <option value="{{$option->id}}" selected>{{$option->title}}</option>
                @elseif($ticket->priority_id == $option->id && old('priority_id') == null)
                <option value="{{$option->id}}" selected>{{$option->title}}</option>
                @else
                <option value="{{$option->id}}">{{$option->title}}</option>
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
            <select name="developer_id" class="form-select @error('developer_id') is-invalid @enderror" id="developer" required>
                <option hidden value="0"></option>
                @foreach($catalogs['user'] as $option)
                @if(old('developer_id') == $option->id)
                <option value="{{$option->id}}" selected>{{$option->email}}</option>
                @elseif($ticket->developer_id == $option->id && old('developer_id') == null)
                <option value="{{$option->id}}" selected>{{$option->email}}</option>
                @else
                <option value="{{$option->id}}">{{$option->email}}</option>
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
                @if (count($catalogs['project']) <= 0) <option disabled>No hay proyectos disponibles</option>
                    @endif
                    @foreach($catalogs['project'] as $option)
                    @if(old('project_id') == $option->id)
                    <option value="{{$option->id}}" selected>{{$option->title}}</option>
                    @elseif($ticket->project_id == $option->id && old('project_id') == null)
                    <option value="{{$option->id}}" selected>{{$option->title}}</option>
                    @else
                    <option value="{{$option->id}}">{{$option->title}}</option>
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
        <label for="status" class="form-label fw-bold">Estado</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="far fa-eye"></i>
            </span>
            <select name="status_id" class="form-select @error('status_id') is-invalid @enderror" id="status" required>
                <option hidden value="0"></option>
                @foreach($catalogs['status'] as $option)
                @if(old('status_id') == $option->id)
                <option value="{{$option->id}}" selected>{{$option->title}}</option>
                @elseif($ticket->status_id == $option->id && old('status_id') == null)
                <option value="{{$option->id}}" selected>{{$option->title}}</option>
                @elseif(!$ticket->exists && $option->id == 1)
                <option value="{{$option->id}}" selected>{{$option->title}}</option>
                @else
                <option value="{{$option->id}}">{{$option->title}}</option>
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
    <div class="col-12 mb-3 mb-3">
        <label for="name" class="form-label fw-bold">Comentarios</label>
        <textarea id="description" style="resize: none;" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" maxlength="150">{{ old('description', $ticket->description) }}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</form>
@endcan
@endsection