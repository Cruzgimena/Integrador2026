<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestionandoTé - Panel Principal</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800 font-sans min-h-screen flex flex-col">

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
                    Rol: {{ Auth::user()->role ?? 'administrador' }}
                </p>
            </div>
            
            <!-- Botón Cerrar Sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-2 rounded-lg font-medium transition flex items-center gap-1.5 shadow">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </header>

    <div class="flex flex-1">
        
        @php
            $userRole = Auth::user()->role ?? 'administrador'; 
        @endphp

        <!-- Sidebar / Menú Lateral -->
        <aside class="w-64 bg-slate-800 text-slate-300 flex flex-col justify-between p-4 shadow-lg">
            <nav class="space-y-1">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Módulos Disponibles</p>

                <a href="{{ route('home') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg bg-emerald-600 text-white font-medium shadow-sm">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Menú Principal</span>
                </a>

                {{-- Módulos para Operador de Báscula y Admin --}}
                @if(in_array($userRole, ['administrador', 'operador_bascula']))
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-truck-front w-5 text-center text-blue-400"></i>
                        <span>Entrada de Camiones</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-truck-arrow-right w-5 text-center text-indigo-400"></i>
                        <span>Salida de Camiones</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-clipboard-check w-5 text-center text-purple-400"></i>
                        <span>Control de Calidad</span>
                    </a>
                @endif

                {{-- Módulos para Encargado de Stock y Admin --}}
                @if(in_array($userRole, ['administrador', 'encargado_stock']))
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-boxes-stacked w-5 text-center text-emerald-400"></i>
                        <span>Consulta de Stock</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-industry w-5 text-center text-amber-400"></i>
                        <span>Consumo de Planta</span>
                    </a>
                @endif

                {{-- Módulos Exclusivos para Administrador --}}
                @if($userRole === 'administrador')
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-chart-line w-5 text-center text-rose-400"></i>
                        <span>Generar Reportes</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-users w-5 text-center text-cyan-400"></i>
                        <span>Gestión de Usuarios</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-database w-5 text-center text-teal-400"></i>
                        <span>Gestión de Datos</span>
                    </a>
                @endif
            </nav>

            <div class="border-t border-slate-700 pt-4 text-xs text-slate-400 text-center">
                GestionandoTé © 2026
            </div>
        </aside>

        <!-- Área Principal de Contenido -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-900">Menú Principal de Operaciones</h1>
                <p class="text-slate-600 text-sm mt-1">Selecciona una de las opciones habilitadas para tu rol actual.</p>
            </div>

            <!-- Grilla de Tarjetas Exclusivas de Procesos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- 1. OPERADOR DE BÁSCULA & ADMIN --}}
                @if(in_array($userRole, ['administrador', 'operador_bascula']))
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-blue-500 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                                    <i class="fa-solid fa-truck-front text-2xl"></i>
                                </div>
                                <span class="text-xs bg-blue-100 text-blue-800 font-semibold px-2 py-1 rounded">Báscula</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-1">1. Registrar Ingreso de Camión</h3>
                            <p class="text-slate-500 text-sm mb-4">Ingreso de datos del camión y proveedor. Pesaje BRUTO (kg).</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-indigo-500 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                                    <i class="fa-solid fa-truck-arrow-right text-2xl"></i>
                                </div>
                                <span class="text-xs bg-indigo-100 text-indigo-800 font-semibold px-2 py-1 rounded">Báscula</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-1">2. Registrar Egreso de Camión</h3>
                            <p class="text-slate-500 text-sm mb-4">Selección de camión, pesaje de TARA y cálculo automático del NETO.</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-purple-500 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                                    <i class="fa-solid fa-clipboard-check text-2xl"></i>
                                </div>
                                <span class="text-xs bg-purple-100 text-purple-800 font-semibold px-2 py-1 rounded">Báscula</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-1">3.Control de Calidad</h3>
                            <p class="text-slate-500 text-sm mb-4">Análisis por lote (humedad, color e impurezas).</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-sm font-semibold text-purple-600 hover:text-purple-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                @endif

                {{-- 2. ENCARGADO DE STOCK & ADMIN --}}
                @if(in_array($userRole, ['administrador', 'encargado_stock']))
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-emerald-500 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600">
                                    <i class="fa-solid fa-boxes-stacked text-2xl"></i>
                                </div>
                                <span class="text-xs bg-emerald-100 text-emerald-800 font-semibold px-2 py-1 rounded">Stock</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-1">4. Gestión / Consulta de Stock</h3>
                            <p class="text-slate-500 text-sm mb-4">Ver stock actual de hoja verde e histórico de movimientos.</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-amber-500 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-amber-50 rounded-lg text-amber-600">
                                    <i class="fa-solid fa-industry text-2xl"></i>
                                </div>
                                <span class="text-xs bg-amber-100 text-amber-800 font-semibold px-2 py-1 rounded">Planta</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-1">5.Registro Consumo de Planta</h3>
                            <p class="text-slate-500 text-sm mb-4">Ingresar kg consumidos y verificar alertas de stock mínimo.</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-sm font-semibold text-amber-600 hover:text-amber-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                @endif

                {{-- 3. EXCLUSIVOS DEL ADMINISTRADOR --}}
                @if($userRole === 'administrador')
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-cyan-500 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-cyan-50 rounded-lg text-cyan-600">
                                    <i class="fa-solid fa-users text-2xl"></i>
                                </div>
                                <span class="text-xs bg-cyan-100 text-cyan-800 font-semibold px-2 py-1 rounded">Admin</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-1">6. Gestión de Usuarios</h3>
                            <p class="text-slate-500 text-sm mb-4">Agregar, eliminar, modificar y guardar usuarios en la BD.</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-sm font-semibold text-cyan-600 hover:text-cyan-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-rose-500 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-rose-50 rounded-lg text-rose-600">
                                    <i class="fa-solid fa-chart-line text-2xl"></i>
                                </div>
                                <span class="text-xs bg-rose-100 text-rose-800 font-semibold px-2 py-1 rounded">Admin</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-1">7. Generar Reportes</h3>
                            <p class="text-slate-500 text-sm mb-4">Reportes diarios, por proveedor y por rango de fechas.</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-sm font-semibold text-rose-600 hover:text-rose-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-teal-500 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-teal-50 rounded-lg text-teal-600">
                                    <i class="fa-solid fa-database text-2xl"></i>
                                </div>
                                <span class="text-xs bg-teal-100 text-teal-800 font-semibold px-2 py-1 rounded">Admin</span>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-1">8. Gestión de Datos</h3>
                            <p class="text-slate-500 text-sm mb-4">Gestionar proveedores, camiones y parámetros (stock mínimo).</p>
                        </div>
                        <a href="#" class="inline-flex items-center text-sm font-semibold text-teal-600 hover:text-teal-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                @endif

            </div>
        </main>
    </div>

</body>
</html>