@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Encabezado con título y botón de acción -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Entrada de Camiones</h1>
            <p class="text-slate-600 text-sm mt-1">Listado de lotes e ingresos registrados en báscula.</p>
        </div>
        <a href="{{ route('lotes.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>+ Ingresar Nuevo Lote / Camión</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tarjeta con la Tabla de Lotes -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">ID / Lote</th>
                        <th class="px-6 py-3.5">Fecha y Hora</th>
                        <th class="px-6 py-3.5">Patente</th>
                        <th class="px-6 py-3.5">Chofer</th>
                        <th class="px-6 py-3.5">Peso Bruto (Kg)</th>
                        <th class="px-6 py-3.5">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($lotes as $lote)
                        @php
                            $idLote = $lote->IDLote ?? $lote->id_lote ?? $lote->id;
                            $fechaEntrada = $lote->FechaHoraEntrada ?? $lote->fecha_hora_entrada;
                            $patente = $lote->Patente ?? $lote->patente;
                            $chofer = $lote->NombreChofer ?? $lote->chofer ?? '-';
                            $pesoBruto = $lote->PesoBruto ?? $lote->peso_bruto ?? 0;
                            $fechaSalida = $lote->FechaHoraSalida ?? $lote->fecha_hora_salida ?? null;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-bold text-slate-800">#{{ $idLote }}</td>
                            <td class="px-6 py-4">
                                {{ $fechaEntrada ? \Carbon\Carbon::parse($fechaEntrada)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 font-semibold uppercase text-slate-700">{{ $patente }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $chofer }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ number_format($pesoBruto, 2, ',', '.') }} kg</td>
                            <td class="px-6 py-4">
                                <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $fechaSalida ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $fechaSalida ? 'Completado' : 'En Planta' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                <i class="fa-solid fa-truck-ramp-box text-3xl mb-2 text-slate-300 block"></i>
                                Todavía no hay lotes registrados. Presioná en <strong>+ Ingresar Nuevo Lote / Camión</strong> para registrar el primero.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection