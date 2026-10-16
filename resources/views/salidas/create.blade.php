@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-2">

    <!-- Encabezado con ícono verde esmeralda idéntico a la maqueta -->
    <div class="flex items-center gap-3.5 mb-6">
        <div class="w-11 h-11 bg-emerald-600 rounded-xl flex items-center justify-center text-white text-xl shadow-sm">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-[#172b4d] tracking-tight">Registro de Salida de Camiones</h1>
            <p class="text-xs text-slate-500 font-normal">Buscá el ingreso por patente o número de entrada para registrar la salida</p>
        </div>
    </div>

    <!-- Barra de búsqueda superior -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
        <form action="{{ route('salidas.create') }}" method="GET" class="flex gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input type="text" name="buscar" value="{{ $termino ?? '' }}" placeholder="Ingrese patente o nro. de entrada... (ej: AC523BD)" required
                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-700 uppercase font-mono placeholder:normal-case placeholder:font-sans placeholder:text-slate-400">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-[#172b4d] hover:bg-[#101e36] text-white text-xs font-semibold rounded-lg transition shadow-sm">
                Buscar
            </button>
        </form>
    </div>

    <!-- Alertas -->
    @if(session('error'))
        <div class="mb-5 p-3.5 bg-amber-50 border border-amber-200 text-amber-800 text-xs rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation text-amber-600"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @php
        $idLote = $lote ? ($lote->IDLote ?? $lote->id_lote ?? $lote->id ?? '') : '';
        $patente = $lote ? ($lote->Patente ?? $lote->patente ?? '') : '';
        $proveedor = $lote ? ($lote->proveedor_nombre ?? 'Proveedor asignado') : '';
        $fechaEntrada = $lote ? ($lote->FechaHoraEntrada ?? $lote->fecha_hora_entrada ?? '') : '';
        $pesoBruto = $lote ? ($lote->PesoBruto ?? $lote->peso_bruto ?? 0) : 0;
    @endphp

    <!-- Formulario de Egreso -->
    <form action="{{ route('salidas.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        @csrf
        <input type="hidden" name="id_lote" value="{{ $idLote }}">

        <!-- Barra interna -->
        <div class="px-8 py-4 border-b border-slate-100 flex items-center gap-2.5 text-xs font-bold text-slate-400 tracking-wider">
            <i class="fa-regular fa-file-lines text-sm"></i>
            <span>DATOS DEL INGRESO</span>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Fila 1: Patente, Proveedor, Fecha y Hora de Entrada (Bloqueados) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1.5">PATENTE DEL VEHÍCULO</label>
                    <input type="text" readonly value="{{ $patente ? $patente : '-' }}"
                        class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-600 font-mono focus:outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1.5">PROVEEDOR</label>
                    <input type="text" readonly value="{{ $proveedor ? $proveedor : '-' }}"
                        class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-600 focus:outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1.5">FECHA Y HORA DE ENTRADA</label>
                    <input type="text" readonly value="{{ $fechaEntrada ? \Carbon\Carbon::parse($fechaEntrada)->format('d/m/Y H:i') : '-' }}"
                        class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-600 focus:outline-none cursor-not-allowed">
                </div>
            </div>

            <!-- Fila 2: Tara, Peso Bruto, Peso Neto -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">PESO TARA (KG)</label>
                    <input type="number" step="0.01" name="peso_tara" id="peso_tara" placeholder="0" {{ $lote ? '' : 'disabled' }} required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg text-slate-700 font-mono focus:outline-none focus:ring-1 focus:ring-blue-600 {{ $lote ? 'bg-white' : 'bg-slate-50 cursor-not-allowed' }}">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1.5">PESO BRUTO (KG)</label>
                    <input type="number" step="0.01" id="peso_bruto" value="{{ $pesoBruto }}" readonly
                        class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-600 font-mono focus:outline-none cursor-not-allowed">
                </div>

                <div>
                    <div class="flex items-center gap-1.5 mb-1.5">
                        <label class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">PESO NETO (KG)</label>
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 font-semibold px-1.5 py-0.5 rounded border border-emerald-100">calculado</span>
                    </div>
                    <input type="hidden" name="peso_neto" id="peso_neto_input" value="0">
                    <input type="text" id="peso_neto_display" readonly value="-"
                        class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-700 font-bold font-mono focus:outline-none cursor-not-allowed">
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <label class="block text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1.5">OBSERVACIONES</label>
                <textarea name="observaciones" rows="4" placeholder="Notas sobre la salida, estado del vehículo, incidencias..." {{ $lote ? '' : 'disabled' }}
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg text-slate-700 placeholder:text-slate-400 resize-none focus:outline-none focus:ring-1 focus:ring-blue-600 {{ $lote ? 'bg-white' : 'bg-slate-50 cursor-not-allowed' }}"></textarea>
            </div>

        </div>

        <!-- Footer con botones -->
        <div class="px-8 py-5 bg-[#F4F7FC] border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('lotes.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition shadow-sm">
                Cancelar
            </a>
            <button type="submit" id="btn_guardar" {{ $lote ? '' : 'disabled' }}
                class="px-6 py-2.5 text-xs font-semibold rounded-lg transition shadow-sm {{ $lote ? 'bg-[#172b4d] hover:bg-[#101e36] text-white cursor-pointer' : 'bg-slate-200 text-slate-400 cursor-not-allowed' }}">
                Registrar salida
            </button>
        </div>

    </form>
</div>

<!-- Script para calcular el Peso Neto en tiempo real -->
<script>
    const inputTara = document.getElementById('peso_tara');
    const inputBruto = document.getElementById('peso_bruto');
    const displayNeto = document.getElementById('peso_neto_display');
    const inputNeto = document.getElementById('peso_neto_input');

    if (inputTara) {
        inputTara.addEventListener('input', function() {
            const bruto = parseFloat(inputBruto.value) || 0;
            const tara = parseFloat(this.value) || 0;

            if (tara > 0 && bruto > 0) {
                const neto = (bruto - tara).toFixed(2);
                displayNeto.value = neto > 0 ? neto + ' kg' : '0.00 kg';
                inputNeto.value = neto > 0 ? neto : 0;
            } else {
                displayNeto.value = '-';
                inputNeto.value = 0;
            }
        });
    }
</script>
@endsection