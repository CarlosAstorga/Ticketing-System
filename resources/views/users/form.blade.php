@extends('templates.main')
@section('header', $user->exists ? 'Editar usuario' : 'Nuevo usuario')
@section('route', route('admin.users.index'))
@section('button', '')
@section('content')
<form id="form" method="POST" action="@if($user->exists) {{ route('admin.users.update', $user->id) }} @else {{ route('admin.users.store') }} @endif">
    @if($user->exists) @method('PUT') @endif
    @csrf

    <div class="card">
        <div class="card-header">Datos generales</div>
        <div class="card-body my-3 my-sm-5">

            <!-- Name -->
            <div class="row mb-3 align-items-center">
                <label for="name" class="col-12 col-sm-2 text-sm-end mb-2 mb-sm-0 fw-bold">Nombre</label>
                <div class="col-12 col-sm-9 col-lg-8">
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
                <label for="email" class="col-12 col-sm-2 text-sm-end mb-2 mb-sm-0 fw-bold">Correo</label>
                <div class="col-12 col-sm-9 col-lg-8">
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required />
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        {{ $message}}
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Role -->
            <div class="row mb-3 align-items-center">
                <label for="roles" class="col-12 col-sm-2 text-sm-end mb-2 mb-sm-0 fw-bold">Roles</label>
                <div class="col-12 col-sm-9 col-lg-8">
                    @foreach($roles as $role)
                    <div class="form-check">
                        @if ($user->roles()->count() > 0)
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="{{ $role->title }}" @foreach($user->roles as $userRole) @if($userRole->title == $role->title) checked @endif @endforeach>
                        @else
                        <input class="form-check-input" type="checkbox" name="roles[]" id="{{ $role->title }}" value="{{ $role->id }}">
                        @endif
                        <label class="form-check-label" for="{{ $role->title }}">{{ $role->title }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</form>
@endsection