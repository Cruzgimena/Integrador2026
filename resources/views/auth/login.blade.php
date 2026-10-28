<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - GestionandoTé</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <div class="auth-card">
        
        <!-- PANEL IZQUIERDO: Branding e Institucional -->
        <div class="auth-sidebar" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                <div class="auth-brand" style="display: flex; justify-content: center; width: 100%;">
                    <!-- Logo centrado -->
                    <img src="{{ asset('img/logo.png') }}" alt="Logo GestionandoTé" style="max-width: 200px; height: auto; margin-bottom: 20px;">
                </div>

                <p class="auth-slogan" style="text-align: center; margin: 0 auto;">
                    "Administrá tu producción con<br>
                    <span>precisión y cuidado</span>"
                </p>
            </div>
            
            <div class="auth-version" style="text-align: center; width: 100%;">
                Versión v2.4.0
            </div>
        </div>

        <!-- PANEL DERECHO: Formulario de Login -->
        <div class="auth-form">
            <h2 class="auth-title">Bienvenido</h2>
            <p class="auth-subtitle">Por favor, ingresá tus credenciales para continuar.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Campo Usuario / Email -->
                <div class="form-group">
                    <label for="login" class="form-label">
                        Usuario o Correo Electrónico
                    </label>
                    <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                        class="form-input @error('login') input-error @enderror"
                        placeholder="Usuario o correo@ejemplo.com">
                    @error('login')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo de Contraseña -->
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" required 
                        class="form-input @error('password') input-error @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recordarme y Enlace de Recuperación -->
                <div class="form-options">
                    <label for="remember" class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <span>Recordarme</span>
                    </label>
                    <div>
                        <a href="#" class="link-primary">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>

                <!-- Botón de Ingreso -->
                <button type="submit" class="btn-primary">
                    Ingresar al Sistema
                </button>

                <!-- Enlace de registro -->
                <div class="auth-footer">
                    ¿No tenés una cuenta? 
                    <a href="{{ route('register') }}" class="link-primary">
                        Registrate aquí
                    </a>
                </div>
            </form>
        </div>

    </div>

</body>
</html>