<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestionandoTé</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Vinculación del CSS usando Vite -->
</head>
<body>

    <header>
        <!-- Logo centrado según la regla del header -->
        <img src="{{ asset('img/logo_gestionandote.png') }}" alt="Logo GestionandoTé" width="200">
        
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Entrada de Camiones</a></li>
                <li><a href="#">Salida de Camiones</a></li>
                <li><a href="#">Control de Stock</a></li>
                <li><a href="#">Reportes</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Las vistas específicas se agrupan visualmente aquí para mantener la consistencia gráfica -->
        @yield('content')
    </main>

    <footer>
        <p>GestionandoTé &copy; 2026 - Néxus Informatico.</p>
    </footer>

</body>
</html>