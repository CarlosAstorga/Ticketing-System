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
            <h1>Crear cuenta</h1>
        </header>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Name -->
            @error('name')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror
            <input type="text" name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror" placeholder="Nombre" required>

            <!-- Email -->
            @error('email')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror
            <input type="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" placeholder="Correo" required />

            <!-- Password -->
            @error('password')
            <span class="invalid-feedback" role="alert">
                {{ $message}}
            </span>
            @enderror
            <input type="password" name="password" placeholder="Contraseña" class="@error('password') is-invalid @enderror" required />
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required />

            <!-- Button -->
            <button>Registrar</button>
        </form>

        <footer class="stripe">
            <p class="text">¿Ya eres usuario? <a href="{{ route('login') }}">Inicia sesión</a></p>
        </footer>
    </main>
</body>

</html>