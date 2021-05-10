@extends('templates.main')
@section('header', $user->exists ? 'Editar usuario' : 'Nuevo usuario')
@section('route', route('admin.users.index'))
@section('button', '')
@section('content')
<form id="form" method="POST" action="@if($user->exists) {{ route('admin.users.update', $user->id) }} @else {{ route('admin.users.store') }} @endif">
    @if($user->exists) @method('PUT') @endif
    @csrf

    <!-- Name -->
    <div class="row mb-3 align-items-center">
        <label for="name" class="col-2 text-md-end form-label fw-bold mb-sm-1 mb-md-0">Nombre</label>
        <div class="col-sm-10">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" autofocus maxlength="100">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <!-- Email -->
    <div class="row mb-3 align-items-center">
        <label for="email" class="col-2 text-md-end form-label fw-bold mb-sm-1 mb-md-0">Correo</label>
        <div class="col-sm-10">
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required />
            @error('email')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror
        </div>
    </div>

    <!-- Role -->
    <div class="row mb-3 align-items-center">
        <label for="email" class="col-2 text-md-end form-label fw-bold mb-sm-1 mb-md-0">Roles</label>
        <div class="col-sm-10">
            <div class="list-group list-group-horizontal flex-wrap">
                @foreach($roles as $role)
                <label class="list-group-item flex-fill">
                    @if (count($user->roles) > 0)
                    <input class="form-check-input me-1" type="checkbox" name="roles[]" value="{{ $role->id }}" id="{{ $role->title }}" @foreach($user->roles as $userRole) @if($userRole->title == $role->title) checked @endif @endforeach>
                    @else
                    <input class="form-check-input me-1" type="checkbox" name="roles[]" value="{{ $role->id }}" id="{{ $role->title }}">
                    @endif
                    {{ $role->title }}
                </label>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection