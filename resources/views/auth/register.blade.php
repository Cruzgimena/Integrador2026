<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestionandoTé - Registro de Usuario</title>
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

        <!-- PANEL DERECHO: Formulario de Registro -->
        <div class="auth-form">
            <h2 class="auth-title">Registro de Usuario</h2>
            <p class="auth-subtitle">Ingresá los datos correspondientes según el perfil.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre de Usuario -->
                <div class="form-group">
                    <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                    <input id="nombre_usuario" type="text" name="nombre_usuario" value="{{ old('nombre_usuario') }}" required autofocus
                        class="form-input @error('nombre_usuario') input-error @enderror"
                        placeholder="Ej: gjarque">
                    @error('nombre_usuario')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombres y Apellido en 2 columnas -->
                <div class="form-row">
                    <div class="form-group form-col">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input id="nombres" type="text" name="nombres" value="{{ old('nombres') }}" required
                            class="form-input @error('nombres') input-error @enderror"
                            placeholder="Ej: Gastón">
                        @error('nombres')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group form-col">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}" required
                            class="form-input @error('apellido') input-error @enderror"
                            placeholder="Ej: Jarque">
                        @error('apellido')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Correo Electrónico -->
                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="form-input @error('email') input-error @enderror"
                        placeholder="ejemplo@educacionadventista.org.ar">
                    @error('email')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Selección de Perfil / Rol -->
                <div class="form-group">
                    <label for="id_perfil" class="form-label">Perfil / Rol Asignado</label>
                    <select id="id_perfil" name="id_perfil" required class="form-input">
                        <option value="1" {{ old('id_perfil') == 1 ? 'selected' : '' }}>Administrador</option>
                        <option value="2" {{ old('id_perfil') == 2 ? 'selected' : '' }}>Operador de Báscula</option>
                        <option value="3" {{ old('id_perfil') == 3 ? 'selected' : '' }}>Encargado de Stock</option>
                    </select>
                </div>

                <!-- Contraseña y Confirmación -->
                <div class="form-row">
                    <div class="form-group form-col">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password" name="password" required
                            class="form-input @error('password') input-error @enderror"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group form-col">
                        <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                        <input id="password-confirm" type="password" name="password_confirmation" required
                            class="form-input"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Botón de Registro -->
                <button type="submit" class="btn-primary">
                    Registrar Usuario
                </button>

                <!-- Volver al Login -->
                <div class="auth-footer">
                    ¿Ya tenés cuenta? 
                    <a href="{{ route('login') }}" class="link-primary">
                        Iniciar Sesión
                    </a>
                </div>
            </form>
        </div>

    </div>

</body>
</html>