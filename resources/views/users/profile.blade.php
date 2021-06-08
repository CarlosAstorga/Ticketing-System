@extends('templates.main')
@section('btn-group', '')
@section('title', 'Mi perfil')
@section('content')
<div class="row g-3">
    <!-- Avatar columns -->
    <div class="col-lg-3">
        <div class="row g-3 h-100">
            <!-- Avatar -->
            <div class="col-12 h-100">
                <x-card.main class="h-100">
                    <div class="avatar-profile-container flex-column-center mt-5">
                        <img id="avatar" src="{{ auth()->user()->avatar() }}" alt="avatar" class="rounded-circle avatar-profile @error('file', 'avatar') is-invalid @enderror">
                        @error('file', 'avatar')
                        <span class="invalid-feedback text-center" role="alert">
                            {{ $message}}
                        </span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center py-3 border-bottom">
                        <form method="POST" action="{{ route('user.avatar', auth()->user()->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="btn-group">
                                <button id="avatarButton" class="btn btn-sm btn-outline-secondary">Examinar...</button>
                                <button id="avatarSaveButton" type="submit" class="btn btn-sm btn-outline-success d-none">Guardar</button>
                            </div>
                            <input class="d-none" type="file" name="file" id="fileInput" accept=".jpg, .png">
                        </form>
                    </div>
                    <x-card.body class="flex-column-center my-md-3">
                        <p class="lead fw-bold mb-0">{{ auth()->user()->name }}</p>
                        <p class="fst-italic text-blue">{{ auth()->user()->email }}</p>
                        @foreach(auth()->user()->roles as $role)
                        <p class="mb-0">{{ $role->title }}</p>
                        @endforeach
                    </x-card.body>
                </x-card.main>
            </div>
        </div>
    </div>

    <!-- Form columns -->
    <div class="col-lg-9">
        <div class="row g-3">
            <!-- Update user info -->
            <div class="col-12">
                <x-card.main class="border-light">
                    <x-card.header header="Actualizar usuario" />
                    <x-card.body class="my-md-3">
                        <form id="userForm" method="POST" action="{{ route('user-profile-information.update') }}">
                            @csrf
                            @method("PUT")
                            <x-inline-input class="mb-3" label="Nombre" name="name" value="{{ auth()->user()->name }}" errorBag="updateProfileInformation" />

                            <x-inline-input class="mb-3" label="Correo" name="email" value="{{ auth()->user()->email }}" type="email" errorBag="updateProfileInformation" />

                            <div class="row">
                                <div class="col-12 col-sm-2 offset-sm-3 offset-lg-2">
                                    <button type="submit" class="btn btn-sm btn-outline-success w-100">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </x-card.body>
                </x-card.main>
            </div>
            <!-- Update password -->
            <div class="col-12">
                <x-card.main class="border-light">
                    <x-card.header header="Actualizar contraseña" />
                    <x-card.body class="my-md-3">
                        <form id="passForm" method="POST" action="{{ route('user-password.update') }}">
                            @csrf
                            @method("PUT")
                            <x-inline-input class="mb-3" label="Contraseña" name="current_password" type="password" errorBag="updatePassword" />

                            <x-inline-input class="mb-3" label="Nueva Contraseña" name="password" type="password" errorBag="updatePassword" />

                            <x-inline-input class="mb-3" label="Confirmar" name="password_confirmation" type="password" errorBag="updatePassword" />

                            <div class="row">
                                <div class="col-12 col-sm-2 offset-sm-3 offset-lg-2">
                                    <button type="submit" class="btn btn-sm btn-outline-success w-100">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </x-card.body>
                </x-card.main>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    const avatar = document.getElementById('avatar');
    const fileInput = document.getElementById('fileInput');
    const buttonGroup = document.getElementById('buttonGroup');
    const avatarButton = document.getElementById('avatarButton');
    const avatarSaveButton = document.getElementById('avatarSaveButton');

    avatarButton.addEventListener('click', () => {
        event.preventDefault();
        fileInput.click()
    });

    fileInput.addEventListener('change', () => {
        const reader = new FileReader();

        reader.readAsDataURL(fileInput.files[0]);
        reader.onloadend = x => {
            avatar.src = reader.result;
        };

        avatarSaveButton.classList.remove('d-none');
    });
</script>
@endsection