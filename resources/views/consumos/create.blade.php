@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-2">

    @if(session('success'))
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-2.5 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold rounded-xl flex items-center gap-2.5 shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 bg-[#172b4d] text-white rounded-xl flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-industry"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Registro de consumo de planta</h2>
                    <p class="text-xs text-slate-400">Completá los campos requeridos para registrar el consumo.</p>
                </div>
            </div>

            <div class="text-right">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Stock Disponible</span>
                <span class="text-base font-bold font-mono text-emerald-700">
                    {{ number_format($stockActual, 2, ',', '.') }} kg
                </span>
            </div>
        </div>

        <form action="{{ route('consumos.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Fila 1: Fecha y Materia Prima -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="fecha" class="block text-xs font-bold text-slate-600 mb-1.5">FECHA *</label>
                    <input type="date" id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                    @error('fecha')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="materia_prima" class="block text-xs font-bold text-slate-600 mb-1.5">MATERIA PRIMA *</label>
                    <select id="materia_prima" name="materia_prima" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 bg-white focus:outline-none focus:ring-1 focus:ring-blue-600">
                        <option value="Hoja Verde" {{ old('materia_prima') == 'Hoja Verde' ? 'selected' : '' }}>Hoja Verde (Materia Prima)</option>
                    </select>
                    @error('materia_prima')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Fila 2: Cantidad (kg) y Destino/Proceso -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="cantidad" class="block text-xs font-bold text-slate-600 mb-1.5">CANTIDAD (KG) *</label>
                    <div class="relative">
                        <input type="number" step="0.01" min="0.01" id="cantidad" name="cantidad" value="{{ old('cantidad') }}" placeholder="0.00" required
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 font-mono focus:outline-none focus:ring-1 focus:ring-blue-600">
                        <span class="absolute right-3.5 top-2.5 text-xs text-slate-400 font-bold">kg</span>
                    </div>
                    @error('cantidad')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="destino" class="block text-xs font-bold text-slate-600 mb-1.5">DESTINO / PROCESO *</label>
                    <select id="destino" name="destino" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 bg-white focus:outline-none focus:ring-1 focus:ring-blue-600">
                        <option value="">Seleccionar...</option>
                        <option value="Secado - Sapecador 1" {{ old('destino') == 'Secado - Sapecador 1' ? 'selected' : '' }}>Secado - Sapecador 1</option>
                        <option value="Secado - Sapecador 2" {{ old('destino') == 'Secado - Sapecador 2' ? 'selected' : '' }}>Secado - Sapecador 2</option>
                        <option value="Canchado / Molienda" {{ old('destino') == 'Canchado / Molienda' ? 'selected' : '' }}>Canchado / Molienda</option>
                        <option value="Merma o Descarte" {{ old('destino') == 'Merma o Descarte' ? 'selected' : '' }}>Merma o Descarte</option>
                    </select>
                    @error('destino')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-xs font-bold text-slate-600 mb-1.5">OBSERVACIONES</label>
                <textarea id="observaciones" name="observaciones" rows="3" maxlength="500"
                    placeholder="Notas adicionales sobre el consumo registrado..."
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 resize-none focus:outline-none focus:ring-1 focus:ring-blue-600">{{ old('observaciones') }}</textarea>
                <span class="text-[11px] text-slate-400 mt-1 block">Opcional. Máx. 500 caracteres.</span>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-semibold text-white bg-[#172b4d] hover:bg-[#101e36] rounded-xl shadow-sm transition">
                    Registrar Consumo
                </button>
            </div>
        </form>

    </div>
</div>
@endsection