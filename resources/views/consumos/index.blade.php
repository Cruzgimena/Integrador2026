@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-2">

    @if(session('success'))
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-2.5 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 bg-amber-500 rounded-xl flex items-center justify-center text-white text-xl shadow-sm">
                <i class="fa-solid fa-industry"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-[#172b4d] tracking-tight">Historial de Consumos de Planta</h1>
                <p class="text-xs text-slate-500 font-normal">Registro de salidas de stock hacia secado y molienda</p>
            </div>
        </div>

        <a href="{{ route('consumos.create') }}" class="inline-flex items-center gap-2 bg-[#172b4d] hover:bg-[#101e36] text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Registrar Nuevo Consumo</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5">ID Mov.</th>
                        <th class="px-5 py-3.5">Fecha y Hora</th>
                        <th class="px-5 py-3.5 text-center">Tipo</th>
                        <th class="px-5 py-3.5 text-right">Kilos Descontados</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($consumos as $mov)
                        @php
                            $id = $mov->IDMovimiento ?? $mov->id_movimiento ?? $mov->id ?? '-';
                            $fecha = $mov->FechaHora ?? $mov->fecha_hora ?? $mov->created_at ?? null;
                            $tipo = $mov->TipoMovimiento ?? $mov->tipo_movimiento ?? 'Salida';
                            $kilos = $mov->Kilos ?? $mov->kilos ?? $mov->cantidad ?? 0;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition text-xs">
                            <td class="px-5 py-4 font-mono font-bold text-slate-800">#{{ $id }}</td>
                            <td class="px-5 py-4">
                                {{ $fecha ? \Carbon\Carbon::parse($fecha)->format('d/m/Y H:i') : '—' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-amber-100 text-amber-800">
                                    {{ $tipo }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right font-mono font-bold text-rose-600">
                                -{{ number_format($kilos, 2, ',', '.') }} kg
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                <i class="fa-solid fa-clipboard-list text-3xl mb-2 text-slate-300 block"></i>
                                No hay consumos registrados en planta todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection