@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-2">

    <!-- Encabezado con ícono rosa/rojo temático de Reportes -->
    <div class="flex items-center gap-3.5 mb-6">
        <div class="w-12 h-12 bg-rose-500 rounded-xl flex items-center justify-center text-white text-xl shadow-sm">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-[#172b4d] tracking-tight">Reportes de Báscula y Producción</h1>
            <p class="text-xs text-slate-500 font-normal">Generá y consultá reportes detallados de entradas, salidas y pesajes</p>
        </div>
    </div>

    <!-- Caja de Filtros según Prototipo -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
        <div class="px-6 py-3.5 bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 tracking-wider uppercase">
            Filtros del Reporte
        </div>
        
        <form action="{{ route('reportes.index') }}" method="GET" class="p-6">
            <input type="hidden" name="generar" value="1">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Columna Izquierda: Tipo de Reporte (Radio Buttons estilizados) -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Tipo de Reporte</label>
                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-3.5 border rounded-xl cursor-pointer transition {{ ($tipoReporte ?? 'diario') === 'diario' ? 'border-emerald-500 bg-emerald-50/40' : 'border-slate-200 hover:bg-slate-50' }}">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="tipo_reporte" value="diario" {{ ($tipoReporte ?? 'diario') === 'diario' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <span class="block text-sm font-semibold text-slate-800">Reporte Diario</span>
                                    <span class="block text-xs text-slate-400">Resumen y pesadas de una jornada</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-leaf text-emerald-500 text-sm"></i>
                        </label>

                        <label class="flex items-center justify-between p-3.5 border rounded-xl cursor-pointer transition {{ ($tipoReporte ?? '') === 'proveedor' ? 'border-emerald-500 bg-emerald-50/40' : 'border-slate-200 hover:bg-slate-50' }}">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="tipo_reporte" value="proveedor" {{ ($tipoReporte ?? '') === 'proveedor' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <span class="block text-sm font-semibold text-slate-800">Reporte por Proveedor / Rango</span>
                                    <span class="block text-xs text-slate-400">Detalle agrupado entre fechas</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-truck-ramp-box text-slate-400 text-sm"></i>
                        </label>
                    </div>
                </div>

                <!-- Columna Derecha: Filtros Específicos -->
                <div class="space-y-4">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Filtros Específicos</label>

                    <div>
                        <label class="block text-xs text-slate-600 font-medium mb-1">Proveedor</label>
                        <select name="id_proveedor" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-700 bg-white focus:outline-none focus:ring-1 focus:ring-blue-600">
                            <option value="">Todos los proveedores</option>
                            @foreach($proveedores as $prov)
                                @php
                                    $idProv = $prov->IDProveedor ?? $prov->id_proveedor ?? $prov->id;
                                    $nombreProv = $prov->Nombre ?? $prov->nombre;
                                @endphp
                                <option value="{{ $idProv }}" {{ ($proveedorSeleccionado ?? '') == $idProv ? 'selected' : '' }}>
                                    {{ $nombreProv }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-slate-600 font-medium mb-1">Fecha Desde / Día</label>
                            <input type="date" name="fecha_desde" value="{{ $fechaDesde ?? '' }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 font-medium mb-1">Fecha Hasta</label>
                            <input type="date" name="fecha_hasta" value="{{ $fechaHasta ?? '' }}" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#172b4d] hover:bg-[#101e36] text-white text-xs font-semibold rounded-lg shadow-sm transition">
                    <i class="fa-solid fa-chart-simple text-xs"></i>
                    <span>Generar Reporte</span>
                </button>

                <a href="{{ route('reportes.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg shadow-sm transition">
                    <i class="fa-solid fa-arrows-rotate text-xs"></i>
                    <span>Restablecer Filtros</span>

            
                </a>
            </div>
        </form>
    </div>

    <!-- Resultados y Vista Previa del Reporte -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-wider">
                <i class="fa-regular fa-file-lines text-slate-400"></i>
                <span>Vista Previa del Reporte</span>
            </div>
            <div class="text-right">
                <span class="text-xs text-slate-400 font-medium">Total Kilos Netos:</span>
                <span class="text-base font-bold font-mono text-emerald-700 ml-1">
                    {{ number_format($totalKilosNetos ?? 0, 2, ',', '.') }} kg
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5">Lote #</th>
                        <th class="px-5 py-3.5">Fecha y Hora</th>
                        <th class="px-5 py-3.5">Patente / Chofer</th>
                        <th class="px-5 py-3.5">Proveedor</th>
                        <th class="px-5 py-3.5 text-right">Peso Bruto</th>
                        <th class="px-5 py-3.5 text-right">Tara</th>
                        <th class="px-5 py-3.5 text-right">Peso Neto</th>
                        <th class="px-5 py-3.5 text-center">Calidad</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($movimientos as $mov)
                        @php
                            $idLote = $mov->IDLote ?? $mov->id_lote ?? $mov->id;
                            $fecha = $mov->FechaHoraEntrada ?? $mov->fecha_hora_entrada;
                            $patente = $mov->Patente ?? $mov->patente;
                            $chofer = $mov->NombreChofer ?? $mov->chofer ?? '-';
                            $proveedor = $mov->proveedor_nombre ?? 'Proveedor asignado';
                            $bruto = $mov->PesoBruto ?? $mov->peso_bruto ?? 0;
                            $tara = $mov->Tara ?? $mov->tara ?? 0;
                            $neto = $mov->PesoNeto ?? $mov->peso_neto ?? 0;
                            $calidad = $mov->Calidad ?? $mov->calidad ?? 'Pendiente';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition text-xs">
                            <td class="px-5 py-4 font-mono font-bold text-slate-800">#{{ $idLote }}</td>
                            <td class="px-5 py-4">
                                {{ $fecha ? \Carbon\Carbon::parse($fecha)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-mono font-bold uppercase text-slate-800 block">{{ $patente }}</span>
                                <span class="text-slate-400 text-[11px]">{{ $chofer }}</span>
                            </td>
                            <td class="px-5 py-4 font-medium text-slate-700">{{ $proveedor }}</td>
                            <td class="px-5 py-4 text-right font-mono font-semibold text-slate-700">{{ number_format($bruto, 2, ',', '.') }} kg</td>
                            <td class="px-5 py-4 text-right font-mono text-slate-500">{{ $tara > 0 ? number_format($tara, 2, ',', '.') . ' kg' : '—' }}</td>
                            <td class="px-5 py-4 text-right font-mono font-bold text-emerald-700">
                                {{ $neto > 0 ? number_format($neto, 2, ',', '.') . ' kg' : 'Pendiente' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-[11px] px-2.5 py-0.5 rounded-full font-bold {{ $calidad === 'Aprobado' ? 'bg-emerald-100 text-emerald-800' : ($calidad === 'Rechazado' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700') }}">
                                    {{ $calidad }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-regular fa-folder-open text-4xl mb-3 text-slate-300 block"></i>
                                No se encontraron pesajes ni movimientos que coincidan con los filtros seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection