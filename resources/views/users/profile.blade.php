@extends('templates.main')
@section('buttons', '')
@section('button', '')
@section('header', 'Mi perfil')
@section('content')

<div class="row g-3">
    <!-- Avatar columns -->
    <div class="col-lg-3">
        <div class="row g-3 h-100">
            <!-- Avatar -->
            <div class="col-12 h-100">
                <div class="card h-100">
                    <div class="avatar-profile-container flex-column-center mt-3 pb-3">
                        <img id="avatar" src="{{ auth()->user()->avatar() }}" alt="avatar" class="rounded-circle avatar-profile @error('file', 'avatar') is-invalid @enderror">
                        @error('file', 'avatar')
                        <span class="invalid-feedback text-center" role="alert">
                            {{ $message}}
                        </span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center pb-3 border-bottom">
                        <form method="POST" action="{{ route('user.avatar', auth()->user()->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input class="d-none" type="file" name="file" id="fileInput" accept=".jpg, .png">
                            <button id="avatarButton" class="btn btn-sm btn-outline-secondary border-0">Examinar...</button>
                            <button id="avatarSaveButton" type="submit" class="btn btn-sm btn-outline-success border-0 d-none">Guardar</button>
                        </form>
                    </div>
                    <div class="card-body my-3 flex-column-center">
                        <p class="fs-4 mb-0">{{ auth()->user()->name }}</p>
                        <p class="fst-italic">{{ auth()->user()->email }}</p>
                        @foreach(auth()->user()->roles as $role)
                        @if($loop->index < 4) <p class="mb-0">{{ $role->title }}</p>
                            @endif
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form columns -->
    <div class="col-lg-9">
        <div class="row g-3">
            <!-- Update user info -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Actualizar usuario</div>
                    <div class="card-body">
                        <form id="userForm" method="POST" action="{{ route('user-profile-information.update') }}">
                            @csrf
                            @method("PUT")
                            <!-- Name -->
                            <div class="row mb-3 align-items-center">
                                <label for="name" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Nombre</label>
                                <div class="col-12 col-sm-9 col-lg-8">
                                    <input id="name" type="text" class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" autofocus maxlength="100">
                                    @error('name', 'updateProfileInformation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="row mb-3 align-items-center">
                                <label for="email" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Correo</label>
                                <div class="col-12 col-sm-9 col-lg-8">
                                    <input id="email" type="email" name="email" value="{{ auth()->user()->email }}" class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" required />
                                    @error('email', 'updateProfileInformation')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message}}
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3 offset-sm-3">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Guardar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- Update password -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Actualizar contraseña</div>
                    <div class="card-body">
                        <form id="passForm" method="POST" action="{{ route('user-password.update') }}">
                            @csrf
                            @method("PUT")
                            <!-- Password -->
                            <div class="row mb-3 align-items-center">
                                <label for="currentPassword" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Contraseña</label>
                                <div class="col-12 col-sm-9 col-lg-8">
                                    <input id="currentPassword" type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" required />
                                    @error('current_password', 'updatePassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- New password -->
                            <div class="row mb-3 align-items-center">
                                <label for="password" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Nueva contraseña</label>
                                <div class="col-12 col-sm-9 col-lg-8">
                                    <input id="password" type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" required />
                                    @error('password', 'updatePassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm password -->
                            <div class="row mb-3 align-items-center">
                                <label for="password" class="col-12 col-sm-3 text-sm-end mb-2 mb-sm-0 fw-bold">Confirmar contraseña</label>
                                <div class="col-12 col-sm-9 col-lg-8">
                                    <input id="password" type="password" name="password_confirmation" class="form-control" required />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3 offset-sm-3">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Guardar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
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