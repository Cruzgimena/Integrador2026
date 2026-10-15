<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GestionandoTé - Inicio</title>
    
    <!-- Vinculación del CSS clásico (sin Vite) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <header>
        <!-- Asegurate de tener el logo en public/img/logo_gestionandote.png -->
        <img src="{{ asset('img/logo_gestionandote.png') }}" alt="Logo GestionandoTé" width="200">
        
        <nav>
            <ul>
                <!-- Menú adaptado al diseño de la materia -->
                <li><a href="{{ url('/') }}">Inicio</a></li>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Registrarse</a></li>
                        @endif
                    @endauth
                @endif
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2 class="destacado">Bienvenido a GestionandoTé</h2>
            <p>Sistema integral para la gestión de pesaje y stock de yerba mate.</p>
            
            <div class="contenedor-articulo">
                <div>
                    <h3 id="principal">Acceso rápido</h3>
                    <p>Por favor, inicie sesión en el menú superior para acceder a los módulos de registro de camiones, control de stock y reportes.</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>GestionandoTé &copy; {{ date('Y') }} - Cruz, Millán, Jarque</p>
    </footer>

<div class="flex space-x-4">
    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Iniciar Sesión</a>
    <a href="{{ route('register') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50">Registrarse</a>
</div>

</body>
</html>
