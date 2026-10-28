@extends('layouts.app') 

@section('content')
<div class="max-w-6xl mx-auto py-2">

    <!-- Encabezado con ícono temático verde -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center text-white text-xl shadow-sm">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-[#172b4d] tracking-tight">Inventario de Stock</h1>
                <p class="text-xs text-slate-500 font-normal">Control de existencias y niveles en silo de yerba mate</p>
            </div>
        </div>

        @if(Route::has('stocks.create'))
        <a href="{{ route('stocks.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Cargar Stock Inicial</span>
        </a>
        @endif
    </div>

    @php
        $actual = $stockPrincipal->$colStockActual ?? $stockPrincipal->StockActual ?? 0;
        $minimo = $stockPrincipal->$colUmbralMin ?? $stockPrincipal->UmbralMinimo ?? 0;
        $bajoMinimo = $actual < $minimo;
    @endphp

    <!-- Tarjetas de Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Stock Actual (Yerba Canchada)</span>
                <span class="text-2xl font-bold text-slate-800 font-mono">{{ number_format($actual, 2, ',', '.') }}</span>
                <span class="text-xs font-semibold text-slate-500 ml-1">kg</span>
            </div>
            <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 text-lg">
                <i class="fa-solid fa-warehouse"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Umbral Mínimo Requerido</span>
                <span class="text-2xl font-bold text-slate-800 font-mono">{{ number_format($minimo, 2, ',', '.') }}</span>
                <span class="text-xs font-semibold text-slate-500 ml-1">kg</span>
            </div>
            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 text-lg">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Condición Operativa</span>
                @if($bajoMinimo)
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-200">
                        <i class="fa-solid fa-triangle-exclamation"></i> Bajo Umbral Mínimo
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                        <i class="fa-solid fa-circle-check"></i> Stock Óptimo
                    </span>
                @endif
            </div>
            <div class="w-11 h-11 {{ $bajoMinimo ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} rounded-xl flex items-center justify-center text-lg">
                <i class="fa-solid {{ $bajoMinimo ? 'fa-battery-quarter' : 'fa-battery-full' }}"></i>
            </div>
        </div>
    </div>

    <!-- Tabla de Existencias en Silos / Depósitos -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5 text-xs font-bold text-slate-500 tracking-wider">
                <i class="fa-solid fa-cubes-stacked text-sm text-slate-400"></i>
                <span>DETALLE DE INVENTARIO DISPONIBLE</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">ID Silo / Depósito</th>
                        <th class="px-6 py-3.5">Materia Prima</th>
                        <th class="px-6 py-3.5">Stock Disponible</th>
                        <th class="px-6 py-3.5">Umbral Mínimo</th>
                        <th class="px-6 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stocks as $item)
                        @php
                            $id = $item->$colIdStock ?? $item->IDStock ?? $item->id;
                            $cant = $item->$colStockActual ?? $item->StockActual ?? 0;
                            $min = $item->$colUmbralMin ?? $item->UmbralMinimo ?? 0;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-mono font-bold text-slate-800">#{{ $id }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                <span class="inline-flex items-center gap-2">
                                    <i class="fa-solid fa-leaf text-emerald-600 text-xs"></i>
                                    Yerba Mate Canchada
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold font-mono text-slate-800">
                                {{ number_format($cant, 2, ',', '.') }} kg
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-500">
                                {{ number_format($min, 2, ',', '.') }} kg
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if(Route::has('stocks.edit'))
                                <a href="{{ route('stocks.edit', $id) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                                    <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                    <span>Editar</span>
                                </a>
                                @else
                                <span class="text-xs text-slate-400">Activo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                No se encontraron registros de stock cargados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection