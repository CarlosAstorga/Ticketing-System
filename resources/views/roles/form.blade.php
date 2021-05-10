@extends('templates.main')
@section('header', $role->exists ? 'Editar rol' : 'Nuevo rol')
@section('route', route('roles.index'))
@section('button', '')
@section('content')
<form id="form" method="POST" action="@if($role->exists) {{ route('roles.update', $role->id) }} @else {{ route('roles.store') }} @endif">
    @if($role->exists) @method('PUT') @endif
    @csrf

    <!-- Title -->
    <div class="row mb-3 align-items-center">
        <label for="title" class="col-sm-2 text-md-end form-label fw-bold mb-sm-1 mb-md-0">Titulo</label>
        <div class="col-sm-10">
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $role->title) }}" autofocus maxlength="100">
            @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <!-- Permissions -->
    <div class="row mb-3">
        <label class="col-sm-2 text-md-end form-label fw-bold mb-sm-1 mb-md-0 mt-md-2">Permisos</label>
        <div class="col-sm-10">
            <div class="row g-0 gy-3">
                @foreach($modules as $m)
                <div class="card col-12 col-md-6">
                    <card class="body">
                        <div class="list-group list-group-flush">
                            <label class="list-group-item text-center">{{ $m->title }}</label>
                            @foreach($m->permissions as $p)
                            <label class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" name="permissions[]" value="{{ $p->id }}" @foreach($role->permissions as $rp) @if($rp->id == $p->id) checked @endif @endforeach>
                                {{ $p->title }}
                                <i class="{{ $m->icon }} position-absolute end-0 me-3 mt-1"></i>
                            </label>
                            @endforeach
                        </div>
                    </card>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection