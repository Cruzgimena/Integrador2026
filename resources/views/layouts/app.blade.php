<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestionandoTé</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800 font-sans min-h-screen flex flex-col">

    @php
        $idPerfil = Auth::check() ? (Auth::user()->id_perfil ?? 1) : 1; 
        $nombrePerfil = match((int) $idPerfil) {
            1 => 'Administrador',
            2 => 'Operador de Báscula',
            3 => 'Encargado de Stock',
            default => 'Usuario',
        };
    @endphp

    <!-- Header / Barra Superior -->
    <header class="bg-slate-900 text-white shadow-md flex justify-between items-center px-6 py-4">
        <div class="flex items-center space-x-3">
            <i class="fa-solid fa-leaf text-emerald-400 text-2xl"></i>
            <span class="text-xl font-bold tracking-wide">GestionandoTé</span>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="text-sm font-semibold">{{ Auth::user()->name ?? 'Usuario Sistema' }}</p>
                <p class="text-xs text-emerald-400 font-medium capitalize">
                    Perfil: {{ $nombrePerfil }}
                </p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-2 rounded-lg font-medium transition flex items-center gap-1.5 shadow">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </header>

    <div class="flex flex-1 w-full">
        <!-- Sidebar / Menú Lateral Centralizado -->
        <aside class="w-64 bg-slate-800 text-slate-300 flex flex-col justify-between p-4 shadow-lg min-h-full">
            <nav class="space-y-1">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Módulos Disponibles</p>

                <a href="{{ route('home') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Menú Principal</span>
                </a>

                @if(in_array($idPerfil, [1, 2]))
                    <a href="{{ route('lotes.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-truck-front w-5 text-center text-blue-400"></i>
                        <span>Entrada Camiones</span>
                    </a>
                    <a href="{{ route('salidas.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-truck-arrow-right w-5 text-center text-indigo-400"></i>
                        <span>Salida Camiones</span>
                    </a>
                    <a href="{{ route('calidad.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-clipboard-check w-5 text-center text-purple-400"></i>
                        <span>Calidad</span>
                    </a>
                @endif

                @if(in_array($idPerfil, [1, 2, 3]))
                    <a href="{{ route('stock.index') ?? '#' }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-boxes-stacked w-5 text-center text-emerald-400"></i>
                        <span>Stock</span>
                    </a>
                @endif

                @if(in_array($idPerfil, [1, 3]))
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-industry w-5 text-center text-amber-400"></i>
                        <span>Consumo Planta</span>
                    </a>
                @endif

                @if($idPerfil === 1)
                    <a href="{{ route('reportes.index') ?? '#' }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-chart-line w-5 text-center text-rose-400"></i>
                        <span>Reportes</span>
                    </a>
                    <a href="{{ route('usuarios.index') ?? '#' }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-users w-5 text-center text-cyan-400"></i>
                        <span>Usuarios</span>
                    </a>
                    <a href="{{ route('datos.index') ?? '#' }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-database w-5 text-center text-teal-400"></i>
                        <span>Datos</span>
                    </a>
                @endif
            </nav>

            <div class="border-t border-slate-700 pt-4 text-xs text-slate-400 text-center">
                GestionandoTé © 2026
            </div>
        </aside>

        <!-- Área Principal de Contenido (AQUÍ SE INYECTAN LAS OTRAS VISTAS) -->
        <main class="flex-1 p-8 overflow-y-auto w-full">
            @yield('content')
        </main>
    </div>

</body>
</html>