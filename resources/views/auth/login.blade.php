<x-guest-layout>

<!-- Bootstrap y FontAwesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        background: #eef2f6;
    }

    .login-container {
        max-width: 420px;
        margin: auto;
        margin-top: 60px;
        background: white;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        position: relative;
        padding-bottom: 25px;
    }

    /* Encabezado azul */
    .login-header {
        background: #073c5f;
        padding: 45px 20px 30px 20px;
        border-radius: 12px 12px 0 0;
        text-align: center;
        color: white;
        font-weight: bold;
        font-size: 26px;
    }

    /* Logo */
    .login-logo {
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

    .login-logo img {
        width: 85px;
    }

    .form-label {
        font-weight: 600;
        margin-top: 10px;
    }

    .input-group-text {
        background: #f1f1f1;
    }

    .btn-ingresar {
        width: 100%;
        background: #073c5f;
        color: white;
        border-radius: 8px;
        padding: 10px;
        border: none;
        font-size: 16px;
        margin-top: 15px;
    }

    .btn-ingresar:hover {
        background: #052c47;
        color: white;
    }

    .password-toggle {
        cursor: pointer;
    }
</style>


<div class="login-container">

    <!-- Logo redondo -->
    <div class="login-logo">
        <img src="/img/icono.png" alt="Logo">
    </div>

    <!-- Header Azul -->
    <div class="login-header">
        Iniciar Sesión
    </div>

    <div class="p-4">

        <!-- Error -->
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                Usuario o contraseña incorrectos.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Usuario -->
            <label for="email" class="form-label">Usuario</label>
            <div class="input-group mb-3">
                <input id="email" type="email" name="email" required autofocus
                       value="{{ old('email') }}" class="form-control"
                       placeholder="Ingrese su usuario">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>

            <!-- Contraseña -->
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group mb-3">
                <input id="password" type="password" name="password" required
                       class="form-control" placeholder="Ingrese su contraseña">
                <span class="input-group-text password-toggle" onclick="togglePassword()">
                    <i id="eyeIcon" class="fas fa-eye-slash"></i>
                </span>
            </div>

            <!-- Mantener sesión -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    Mantener la sesión iniciada
                </label>
            </div>

            <!-- Botón Ingresar -->
            <button class="btn-ingresar" type="submit">
                <i class="fas fa-sign-in-alt me-2"></i> Ingresar
            </button>

            <div class="text-center mt-3">
                <span class="text-muted">¿No tienes cuenta?</span>
                <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">
                    Regístrate aquí
                </a>
            </div>

        </form>

    </div>
</div>

<script>
function togglePassword() {
    const pass = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        pass.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>

</x-guest-layout>