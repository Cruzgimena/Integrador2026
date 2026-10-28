@extends('layouts.app')

@section('content')
    @php
        $idPerfil = Auth::check() ? (Auth::user()->id_perfil ?? 1) : 1; 
    @endphp

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Menú Principal de Operaciones</h1>
        <p class="text-slate-600 text-sm mt-1">Selecciona una de las opciones habilitadas para tu rol actual.</p>
    </div>

    <!-- Grilla de Tarjetas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @if(in_array($idPerfil, [1, 2]))
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-blue-500 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">1. Registrar Ingreso</h3>
                    <p class="text-slate-500 text-sm mb-4">Pesaje BRUTO (kg).</p>
                </div>
                <a href="{{ route('lotes.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">Ingresar <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-indigo-500 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">2. Registrar Egreso</h3>
                    <p class="text-slate-500 text-sm mb-4">Selección de camión, pesaje TARA y NETO.</p>
                </div>
                <a href="{{ route('salidas.create') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">Ingresar <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-purple-500 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">3. Control de Calidad</h3>
                    <p class="text-slate-500 text-sm mb-4">Análisis por lote.</p>
                </div>
                <a href="{{ route('calidad.create') }}" class="text-purple-600 hover:text-purple-800 font-semibold text-sm">Ingresar <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @endif

        @if(in_array($idPerfil, [1, 2, 3]))
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-emerald-500 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">4. Consulta de Stock</h3>
                    <p class="text-slate-500 text-sm mb-4">Ver stock e histórico.</p>
                </div>
                <a href="{{ route('stock.index') ?? '#' }}" class="text-emerald-600 hover:text-emerald-800 font-semibold text-sm">Ingresar <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @endif

        @if(in_array($idPerfil, [1, 3]))
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-amber-500 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">5. Consumo de Planta</h3>
                    <p class="text-slate-500 text-sm mb-4">Registro de consumo diario.</p>
                </div>
                <a href="#" class="text-amber-600 hover:text-amber-800 font-semibold text-sm">Ingresar <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @endif

        @if($idPerfil === 1)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-cyan-500 flex flex-col justify-between">
                <div><h3 class="font-bold text-lg text-slate-800 mb-1">6. Gestión Usuarios</h3></div>
                <a href="{{ route('usuarios.index') ?? '#' }}" class="text-cyan-600 hover:text-cyan-800 font-semibold text-sm">Ingresar <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-rose-500 flex flex-col justify-between">
                <div><h3 class="font-bold text-lg text-slate-800 mb-1">7. Generar Reportes</h3></div>
                <a href="{{ route('reportes.index') ?? '#' }}" class="text-rose-600 hover:text-rose-800 font-semibold text-sm">Ingresar <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition border-l-4 border-l-teal-500 flex flex-col justify-between">
                <div><h3 class="font-bold text-lg text-slate-800 mb-1">8. Gestión Datos</h3></div>
                <a href="{{ route('datos.index') ?? '#' }}" class="text-teal-600 hover:text-teal-800 font-semibold text-sm">Ingresar <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @endif
    </div>
@endsection