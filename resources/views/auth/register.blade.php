<x-guest-layout>

<!-- Bootstrap y FontAwesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        background: #eef2f6;
    }

    .register-container {
        max-width: 420px;
        margin: auto;
        margin-top: 60px;
        background: white;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        position: relative;
        padding-bottom: 25px;
    }

    .register-header {
        background: #073c5f;
        padding: 45px 20px 30px 20px;
        border-radius: 12px 12px 0 0;
        text-align: center;
        color: white;
        font-weight: bold;
        font-size: 26px;
    }

    .register-logo {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: white;
        position: absolute;
        top: -55px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        align-items: center;
        border: 4px solid #073c5f;
    }

    .register-logo img {
        width: 85px;
    }

    .form-label {
        font-weight: 600;
        margin-top: 10px;
    }

    .input-group-text {
        background: #f1f1f1;
    }

    .btn-registrar {
        width: 100%;
        background: #073c5f;
        color: white;
        border-radius: 8px;
        padding: 10px;
        border: none;
        font-size: 16px;
        margin-top: 15px;
    }

    .btn-registrar:hover {
        background: #052c47;
        color: white;
    }

    .password-toggle {
        cursor: pointer;
    }
</style>

<div class="register-container">

    <!-- Logo -->
    <div class="register-logo">
        <img src="/img/icono.png" alt="Logo">
    </div>

    <!-- Header -->
    <div class="register-header">
        Crear Cuenta
    </div>

    <div class="p-4">

        <!-- Errores -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <label for="name" class="form-label">Nombre</label>
            <div class="input-group mb-3">
                <input id="name" type="text" name="name" required autofocus
                       value="{{ old('name') }}" class="form-control"
                       placeholder="Ingrese su nombre">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>

            <!-- Email -->
            <label for="email" class="form-label">Email</label>
            <div class="input-group mb-3">
                <input id="email" type="email" name="email" required
                       value="{{ old('email') }}" class="form-control"
                       placeholder="Ingrese su correo">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>

            <!-- Password -->
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group mb-3">
                <input id="password" type="password" name="password" required
                       class="form-control" placeholder="Ingrese su contraseña">
                <span class="input-group-text password-toggle" onclick="togglePassword('password','eye1')">
                    <i id="eye1" class="fas fa-eye-slash"></i>
                </span>
            </div>

            <!-- Confirm Password -->
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <div class="input-group mb-3">
                <input id="password_confirmation" type="password"
                       name="password_confirmation" required
                       class="form-control" placeholder="Confirme su contraseña">
                <span class="input-group-text password-toggle" onclick="togglePassword('password_confirmation','eye2')">
                    <i id="eye2" class="fas fa-eye-slash"></i>
                </span>
            </div>

            <!-- Botón -->
            <button class="btn-registrar" type="submit">
                <i class="fas fa-user-plus me-2"></i> Registrarse
            </button>

            <!-- Link Login -->
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none">
                    ¿Ya tienes cuenta? Inicia sesión
                </a>
            </div>

        </form>

    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>

</x-guest-layout>