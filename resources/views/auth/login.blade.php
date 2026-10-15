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
        <div class="auth-sidebar">
            <div>
                <div class="auth-brand">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    <h1>GestionandoTé</h1>
                </div>

                <p class="auth-slogan">
                    "Administrá tu producción con<br>
                    <span>precisión y cuidado</span>"
                </p>
            </div>
            
            <div class="auth-version">
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