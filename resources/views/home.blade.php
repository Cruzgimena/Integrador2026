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
        <h3 class="font-bold text-slate-800 text-sm mb-2">1. Registrar Ingreso de Camión</h3>
        <p class="text-xs text-slate-500 flex-1 mb-5 leading-relaxed">Ingreso de datos del camión y proveedor. Pesaje BRUTO (kg).</p>
        <a href="{{ route('lotes.create') }}" class="text-blue-600 text-xs font-semibold hover:text-blue-800 flex items-center gap-1 transition">
            Ingresar <i class="fa-solid fa-arrow-right"></i>
        </a>
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