<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticketing System</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>
    <main>
        <header>
            <h1>Restablecer contraseña</h1>
        </header>

        <form id="form" method="POST" action="{{ url('reset-password') }}">
            @csrf

            @if(session('status'))
            <div class="alert text-center">
                <span class="text-light">{{ session('status') }}</span>
            </div>
            @endif

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->token }}">

            <!-- Email -->
            <input type="email" name="email" value="{{ $request->email }}" class="@error('email') is-invalid @enderror" placeholder="Correo" required />
            @error('email')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror

            <!-- Password -->
            <div class="input-group">
                <input type="password" name="password" placeholder="Contraseña" class="@error('password') is-invalid @enderror" required />
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required />
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror

            <!-- Button -->
            <button>Guardar</button>

        </form>

        <footer class="flex-row-center">
            <a href="{{ route('login') }}">Iniciar sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
        </footer>
    </main>
</body>

</html>