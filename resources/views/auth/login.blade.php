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
        <header class="stripe">
            <h1>Iniciar sesión</h1>
        </header>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email -->
            @error('email')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror
            <input type="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" placeholder="Correo" required />

            <!-- Password -->
            <input type="password" name="password" placeholder="Contraseña" class="@error('email') is-invalid @enderror" required />

            <!-- Button -->
            <button>Entrar</button>
        </form>

        <footer class="stripe">
            <p class="text">¿No tienes cuenta? <a href="{{ route('register') }}">Registrate</a></p>
        </footer>
    </main>
</body>

</html>