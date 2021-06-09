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
            <h1>Iniciar sesión</h1>
        </header>

        <form method="POST" action="{{ route('login') }}">
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

            <!-- Password -->
            <input type="password" name="password" placeholder="Contraseña" class="@error('password') is-invalid @enderror" required />
            @error('password')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror

            <!-- Button -->
            <button>Entrar</button>
        </form>

        <footer class="flex-column-center">
            <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
            <p>¿Olvidaste tu contraseña? <a href="{{ route('password.request') }}">Restablécela</a></p>
            <p>¿Quieres probar el sitio? <a href="{{ route('demo') }}">Demo</a></p>
        </footer>
    </main>
</body>

</html>