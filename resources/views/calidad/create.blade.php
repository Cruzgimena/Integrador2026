@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-2">

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-2.5 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Formulario de Calidad -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100 flex items-center gap-3.5">
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg border border-emerald-100">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800">Registro de calidad por lote</h2>
                <p class="text-xs text-slate-400">Complete los campos para registrar el control de calidad de la materia prima.</p>
            </div>
        </div>

        <form action="{{ route('calidad.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <!-- Fila 1: Selección de Lote y Fecha -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="id_lote" class="block text-xs font-bold text-slate-600 mb-1.5">Lote *</label>
                    <select id="id_lote" name="id_lote" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 bg-white focus:outline-none focus:ring-1 focus:ring-blue-600 font-mono">
                        <option value="">Seleccionar lote...</option>
                        @foreach($lotes as $lote)
                            @php
                                $id = $lote->$colIdLote ?? $lote->id;
                                $patente = $colPatente ? ($lote->$colPatente ?? '') : '';
                            @endphp
                            <option value="{{ $id }}" {{ (old('id_lote', $loteSeleccionado->$colIdLote ?? '') == $id) ? 'selected' : '' }}>
                                Lote #{{ $id }} {{ $patente ? '— Camión: ' . $patente : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_lote')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha" class="block text-xs font-bold text-slate-600 mb-1.5">Fecha</label>
                    <input type="date" id="fecha" name="fecha" value="{{ date('Y-m-d') }}"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 bg-slate-50 focus:outline-none focus:ring-1 focus:ring-blue-600" readonly>
                </div>
            </div>

            <!-- Fila 2: Humedad, Color e Impurezas -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="humedad" class="block text-xs font-bold text-slate-600 mb-1.5">Humedad (%)</label>
                    <input type="number" step="0.1" min="0" max="100" id="humedad" name="humedad" value="{{ old('humedad') }}" placeholder="Ej: 12.5"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600 font-mono">
                </div>

                <div>
                    <label for="color" class="block text-xs font-bold text-slate-600 mb-1.5">Color</label>
                    <select id="color" name="color"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 bg-white focus:outline-none focus:ring-1 focus:ring-blue-600">
                        <option value="">Seleccionar color...</option>
                        <option value="Verde Intenso">Verde Intenso (Óptimo)</option>
                        <option value="Verde Claro">Verde Claro</option>
                        <option value="Amarronado">Amarronado / Seco</option>
                    </select>
                </div>

                <div>
                    <label for="impurezas" class="block text-xs font-bold text-slate-600 mb-1.5">Impurezas (%)</label>
                    <input type="number" step="0.1" min="0" max="100" id="impurezas" name="impurezas" value="{{ old('impurezas') }}" placeholder="Ej: 1.2"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600 font-mono">
                </div>
            </div>

            <!-- Fila 3: Dictamen de Calidad General -->
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Dictamen de Calidad *</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition border-slate-200">
                        <input type="radio" name="calidad" value="Buena" required class="text-emerald-600 focus:ring-emerald-500" {{ old('calidad', 'Buena') == 'Buena' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-emerald-700">Buena</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition border-slate-200">
                        <input type="radio" name="calidad" value="Regular" class="text-amber-600 focus:ring-amber-500" {{ old('calidad') == 'Regular' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-amber-700">Regular</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition border-slate-200">
                        <input type="radio" name="calidad" value="Mala" class="text-rose-600 focus:ring-rose-500" {{ old('calidad') == 'Mala' ? 'checked' : '' }}>
                        <span class="text-xs font-bold text-rose-700">Mala</span>
                    </label>
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-xs font-bold text-slate-600 mb-1.5">Observaciones</label>
                <textarea id="observaciones" name="observaciones" rows="3"
                    placeholder="Ingrese observaciones adicionales sobre el estado de la hoja verde..."
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600">{{ old('observaciones') }}</textarea>
            </div>

            <!-- Botones Guardar / Cancelar -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-semibold text-white bg-[#172b4d] hover:bg-[#101e36] rounded-xl shadow-sm transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <!-- Historial de Lotes Inspeccionados -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-wider">
                <i class="fa-solid fa-clipboard-check text-purple-600"></i>
                <span>Historial de Calidad por Lote</span>
            </div>
            <span class="text-xs text-slate-400">Últimos registros</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5">Lote #</th>
                        <th class="px-5 py-3.5">Fecha</th>
                        <th class="px-5 py-3.5">Patente</th>
                        <th class="px-5 py-3.5 text-center">Calidad</th>
                        <th class="px-5 py-3.5 text-center">Humedad</th>
                        <th class="px-5 py-3.5 text-center">Color</th>
                        <th class="px-5 py-3.5 text-center">Impurezas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($lotes as $item)
                        @php
                            $idL = $item->$colIdLote ?? $item->id;
                            $pat = $colPatente ? ($item->$colPatente ?? '—') : '—';
                            $cal = $item->calidad ?? $item->Calidad ?? null;
                            $hum = $item->humedad ?? '—';
                            $col = $item->color ?? '—';
                            $imp = $item->impurezas ?? '—';
                            $fec = $item->FechaHoraEntrada ?? $item->fecha_hora_entrada ?? null;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition text-xs">
                            <td class="px-5 py-4 font-mono font-bold text-slate-800">#{{ $idL }}</td>
                            <td class="px-5 py-4">
                                {{ $fec ? \Carbon\Carbon::parse($fec)->format('d/m/Y H:i') : '—' }}
                            </td>
                            <td class="px-5 py-4 font-mono font-semibold uppercase text-slate-700">{{ $pat }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($cal)
                                    <span class="text-[11px] px-2.5 py-1 rounded-full font-bold
                                        {{ $cal === 'Buena' ? 'bg-emerald-100 text-emerald-800' : ($cal === 'Regular' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ $cal }}
                                    </span>
                                @else
                                    <span class="text-[11px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-400 font-medium">Pendiente</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center font-mono">{{ $hum !== '—' ? $hum . '%' : '—' }}</td>
                            <td class="px-5 py-4 text-center text-slate-600">{{ $col }}</td>
                            <td class="px-5 py-4 text-center font-mono">{{ $imp !== '—' ? $imp . '%' : '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                                No hay lotes registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection