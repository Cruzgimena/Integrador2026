@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Menú Principal de Operaciones</h1>
    <p class="text-sm text-slate-500">Selecciona una de las opciones habilitadas para tu rol actual.</p>
</div>

<!-- Grilla de Tarjetas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    
    <!-- Tarjeta 1 -->
    <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-6 flex flex-col relative overflow-hidden transition hover:shadow-md">
        <div class="absolute top-4 right-4 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Báscula</div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-truck-front"></i>
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
                    <a href="{{ route('lotes.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-truck-front w-5 text-center text-blue-400"></i>
                        <span>Entrada de Camiones</span>
                    </a>
                    <a href="{{ route('salidas.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-truck-arrow-right w-5 text-center text-indigo-400"></i>
                        <span>Salida de Camiones</span>
                    </a>
                    <a href="{{ route('calidad.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-clipboard-check w-5 text-center text-purple-400"></i>
                        <span>Control de Calidad</span>
                    </a>
                @endif

                {{-- Módulos para Encargado de Stock y Admin --}}
                @if(in_array($userRole, ['administrador', 'encargado_stock']))
                    <a href="{{ route('stock.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-boxes-stacked w-5 text-center text-emerald-400"></i>
                        <span>Consulta de Stock</span>
                    </a>
                    <a href="{{ route('consumos.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-industry w-5 text-center text-amber-400"></i>
                        <span>Consumo de Planta</span>
                    </a>
                @endif

                {{-- Módulos Exclusivos para Administrador --}}
                @if($userRole === 'administrador')
                    <a href="{{ route('reportes.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-chart-line w-5 text-center text-rose-400"></i>
                        <span>Generar Reportes</span>
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition">
                        <i class="fa-solid fa-users w-5 text-center text-cyan-400"></i>
                        <span>Gestión de Usuarios</span>
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
                        <a href="{{ route('lotes.index') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 mt-2">
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
                        <a href="{{ route('salidas.create') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 mt-2">
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
                        <a href="{{ route('calidad.create') }}" class="inline-flex items-center text-sm font-semibold text-purple-600 hover:text-purple-800 mt-2">
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
                        <a href="{{ route('stock.index') }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-800 mt-2">
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
                        <a href="{{ route('consumos.create') }}" class="inline-flex items-center text-sm font-semibold text-amber-600 hover:text-amber-800 mt-2">
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
                        <a href="{{ route('usuarios.index') }}" class="inline-flex items-center text-sm font-semibold text-cyan-600 hover:text-cyan-800 mt-2">
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
                        <a href="{{ route('reportes.index') }}" class="inline-flex items-center text-sm font-semibold text-rose-600 hover:text-rose-800 mt-2">
                            Ingresar <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>

                    
                @endif

            </div>
        </main>
    </div>

    <!-- Tarjeta 2 -->
    <div class="bg-white rounded-xl shadow-sm border border-indigo-100 p-6 flex flex-col relative overflow-hidden transition hover:shadow-md">
        <div class="absolute top-4 right-4 bg-indigo-50 text-indigo-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Báscula</div>
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-truck-arrow-right"></i>
        </div>
        <h3 class="font-bold text-slate-800 text-sm mb-2">2. Registrar Egreso de Camión</h3>
        <p class="text-xs text-slate-500 flex-1 mb-5 leading-relaxed">Selección de camión, pesaje de TARA y cálculo automático del NETO.</p>
        <a href="{{ route('salidas.create') }}" class="text-indigo-600 text-xs font-semibold hover:text-indigo-800 flex items-center gap-1 transition">
            Ingresar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Tarjeta 3 -->
    <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6 flex flex-col relative overflow-hidden transition hover:shadow-md">
        <div class="absolute top-4 right-4 bg-purple-50 text-purple-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Báscula</div>
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-clipboard-check"></i>
        </div>
        <h3 class="font-bold text-slate-800 text-sm mb-2">3. Control de Calidad</h3>
        <p class="text-xs text-slate-500 flex-1 mb-5 leading-relaxed">Análisis por lote (humedad, color e impurezas).</p>
        <a href="{{ route('calidad.create') }}" class="text-purple-600 text-xs font-semibold hover:text-purple-800 flex items-center gap-1 transition">
            Ingresar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Tarjeta 4 -->
    <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6 flex flex-col relative overflow-hidden transition hover:shadow-md">
        <div class="absolute top-4 right-4 bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Stock</div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <h3 class="font-bold text-slate-800 text-sm mb-2">4. Gestión / Consulta de Stock</h3>
        <p class="text-xs text-slate-500 flex-1 mb-5 leading-relaxed">Ver stock actual de hoja verde e histórico de movimientos.</p>
        <a href="{{ route('stock.index') ?? '#' }}" class="text-emerald-600 text-xs font-semibold hover:text-emerald-800 flex items-center gap-1 transition">
            Ingresar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Tarjeta 5 -->
    <div class="bg-white rounded-xl shadow-sm border border-amber-100 p-6 flex flex-col relative overflow-hidden transition hover:shadow-md">
        <div class="absolute top-4 right-4 bg-amber-50 text-amber-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Planta</div>
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-industry"></i>
        </div>
        <h3 class="font-bold text-slate-800 text-sm mb-2">5. Registro Consumo de Planta</h3>
        <p class="text-xs text-slate-500 flex-1 mb-5 leading-relaxed">Ingresar kg consumidos y verificar alertas de stock mínimo.</p>
        <a href="#" class="text-amber-600 text-xs font-semibold hover:text-amber-800 flex items-center gap-1 transition">
            Ingresar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Tarjeta 6 -->
    <div class="bg-white rounded-xl shadow-sm border border-cyan-100 p-6 flex flex-col relative overflow-hidden transition hover:shadow-md">
        <div class="absolute top-4 right-4 bg-cyan-50 text-cyan-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Admin</div>
        <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-users"></i>
        </div>
        <h3 class="font-bold text-slate-800 text-sm mb-2">6. Gestión de Usuarios</h3>
        <p class="text-xs text-slate-500 flex-1 mb-5 leading-relaxed">Agregar, eliminar, modificar y guardar usuarios en la BD.</p>
        <a href="{{ route('usuarios.index') ?? '#' }}" class="text-cyan-600 text-xs font-semibold hover:text-cyan-800 flex items-center gap-1 transition">
            Ingresar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Tarjeta 7 -->
    <div class="bg-white rounded-xl shadow-sm border border-rose-100 p-6 flex flex-col relative overflow-hidden transition hover:shadow-md">
        <div class="absolute top-4 right-4 bg-rose-50 text-rose-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Admin</div>
        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <h3 class="font-bold text-slate-800 text-sm mb-2">7. Generar Reportes</h3>
        <p class="text-xs text-slate-500 flex-1 mb-5 leading-relaxed">Reportes diarios, por proveedor y por rango de fechas.</p>
        <a href="{{ route('reportes.index') ?? '#' }}" class="text-rose-600 text-xs font-semibold hover:text-rose-800 flex items-center gap-1 transition">
            Ingresar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Tarjeta 8 -->
    <div class="bg-white rounded-xl shadow-sm border border-teal-100 p-6 flex flex-col relative overflow-hidden transition hover:shadow-md">
        <div class="absolute top-4 right-4 bg-teal-50 text-teal-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Admin</div>
        <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-database"></i>
        </div>
        <h3 class="font-bold text-slate-800 text-sm mb-2">8. Gestión de Datos</h3>
        <p class="text-xs text-slate-500 flex-1 mb-5 leading-relaxed">Gestionar proveedores, camiones y parámetros (stock mínimo).</p>
        <a href="{{ route('datos.index') ?? '#' }}" class="text-teal-600 text-xs font-semibold hover:text-teal-800 flex items-center gap-1 transition">
            Ingresar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

</div>
@endsection