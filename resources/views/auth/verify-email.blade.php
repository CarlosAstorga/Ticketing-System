@extends('templates.main')
@section('header', '')
@section('content')
<div class="card border-light text-center mt-3">
    <div class="card-header">
        <i class="fas fa-exclamation-circle fs-2"></i>
    </div>
    <div class="card-body my-3 my-sm-5">
        <h5 class="display-6">Cuenta de correo no verificada</h5>
        <p class="lead">Debes verificar tu dirección de correo electrónico para poder acceder a esta pagina.</p>
        <form id="form" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('form').submit();">Reenviar correo de verificación</button>
        </form>
    </div>
</div>
@endsection