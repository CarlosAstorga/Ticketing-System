@extends('templates.main')
@section('header', $role->exists ? 'Editar rol' : 'Nuevo rol')
@section('route', route('roles.index'))
@section('button', '')
@section('content')
<form id="form" method="POST" action="@if($role->exists) {{ route('roles.update', $role->id) }} @else {{ route('roles.store') }} @endif">
    @if($role->exists) @method('PUT') @endif
    @csrf
    <div class="card">
        <div class="card-header">Datos generales</div>
        <div class="card-body my-3 my-sm-5">

            <!-- Title -->
            <div class="row mb-3 align-items-center">
                <label for="title" class="col-12 col-sm-2 text-sm-end mb-2 mb-sm-0 fw-bold">Titulo</label>
                <div class="col-12 col-sm-9 col-lg-8">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $role->title) }}" autofocus maxlength="100">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-header">Permisos</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2 table-responsive">
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
                            for ($i = 0; $i < 8; $i++) { 
                                foreach ($m->permissions as $p) {
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
                </div>
            </div>
        </div>
    </div>
</form>
@endsection