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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            @if(session('status'))
            <div class="alert text-center">
                <span class="text-light">{{ session('status') }}</span>
            </div>
            @endif

            <!-- Email -->
            <input type="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" placeholder="Correo" required />
            @error('email')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror

            <!-- Button -->
            <button>Restablecer</button>
        </form>

        <footer class="flex-row-center">
            <a href="{{ route('login') }}">Iniciar sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
        </footer>
    </main>
</body>

</html>