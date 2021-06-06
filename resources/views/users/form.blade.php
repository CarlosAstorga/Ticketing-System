@extends('templates.main')
@section('title', $user->exists ? 'Editar usuario' : 'Nuevo usuario')
@section('buttons')
<x-header.link route="{{ route('admin.users.index') }}" />
<x-header.button />
@endsection
@section('content')
<x-card.main class="border-light">
    <form id="form" method="POST" action="@if($user->exists) {{ route('admin.users.update', $user->id) }} @else {{ route('admin.users.store') }} @endif">
        @if($user->exists) @method('PUT') @endif
        @csrf
        <x-card.header header="Datos ganerales" />
        <x-card.body class="my-md-3">
            <x-inline-input class="mb-3" label="Nombre" name="name" :value="$user->name" />
            <x-inline-input class="mb-3" label="Correo" name="email" :value="$user->email" />

            @if(!$user->exists)
            <x-inline-input class="mb-3" label="Contraseña" name="password" type="password" />
            <x-inline-input class="mb-3" label="Confirmar" name="password_confirmation" type="password" />
            @endif

            <x-inline-input label="Roles" name="roles" required="0">
                @foreach($roles as $role)
                <div class="form-check mt-2">
                    @if ($user->roles()->count())
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="{{ $role->title }}" @foreach($user->roles as $userRole) @if($userRole->title == $role->title) checked @endif @endforeach>
                    @else
                    <input class="form-check-input" type="checkbox" name="roles[]" id="{{ $role->title }}" value="{{ $role->id }}">
                    @endif
                    <label class="form-check-label" for="{{ $role->title }}">{{ $role->title }}</label>
                </div>
                @endforeach
            </x-inline-input>
        </x-card.body>
    </form>
</x-card.main>
@endsection