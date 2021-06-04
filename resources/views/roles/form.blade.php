@extends('templates.main')
@section('title', $role->exists ? 'Editar rol' : 'Nuevo rol')
@section('buttons')
<x-header.link route="{{ route('roles.index') }}" />
<x-header.button />
@endsection
@section('content')
<form id="form" method="POST" action="@if($role->exists) {{ route('roles.update', $role->id) }} @else {{ route('roles.store') }} @endif">
    @if($role->exists) @method('PUT') @endif
    @csrf
    <x-card.main class="border-light">
        <x-card.header header="Datos generales" />
        <x-card.body class="my-5">
            <x-inline-input label="Título" name="title" :value="$role->title" />
        </x-card.body>
    </x-card.main>

    <x-card.main class="border-light">
        <x-card.header header="Permisos" />
        <x-card.body>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th></th>
                        @foreach($modules as $m)
                        <th><i class="{{ $m->icon }}"></i></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                    $columns = [
                    'create', 'edit', 'show', 'delete', 'access', 'user_assigment', 'ticket_close', 'ticket_resolve'
                    ];
                    $titles = [
                    'Crear', 'Editar', 'Mostrar', 'Eliminar', 'Acceder', 'Asignar usuarios', 'Cerrar ticket', 'Resolver ticket'
                    ];
                    @endphp

                    @foreach ($modules as $m)
                    @php
                    $found = null;
                    for ($i = 0; $i < 8; $i++) { foreach ($m->permissions as $p) {
                        if (strpos($p->title, $columns[$i]) !== false) $found = $p->id;
                        }
                        $arr[$m->title][$columns[$i]] = $found ? $found : null;
                        $found = null;
                        }
                        @endphp
                        @endforeach

                        @foreach($columns as $column)
                        <tr>
                            <td>{{ $titles[$loop->index] }}</td>
                            @foreach($arr as $m)
                            @if (isset($m[$column]))
                            <td>
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $m[$column] }}" @foreach($role->permissions as $rp) @if($rp->id == $m[$column]) checked @endif @endforeach>
                            </td>
                            @else
                            <td><i class="fas fa-times"></i></td>
                            @endif
                            @endforeach
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </x-card.body>
    </x-card.main>
</form>
@endsection