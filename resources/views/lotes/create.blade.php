@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-2">

    <!-- Encabezado con ícono azul oscuro -->
    <div class="flex items-center gap-3.5 mb-6">
        <div class="w-12 h-12 bg-[#172b4d] rounded-xl flex items-center justify-center text-white text-xl shadow-sm">
            <i class="fa-solid fa-right-to-bracket"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-[#172b4d] tracking-tight">Registro de Entrada de Camiones</h1>
            <p class="text-xs text-slate-500 font-normal">Completá los datos del vehículo y la carga que ingresa a planta</p>
        </div>
    </div>

    <!-- Tarjeta del Formulario -->
    <form action="{{ route('lotes.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        @csrf

        <!-- Barra de sección interna -->
        <div class="px-8 py-4 border-b border-slate-100 flex items-center gap-2.5 text-xs font-bold text-slate-400 tracking-wider">
            <i class="fa-regular fa-file-lines text-sm"></i>
            <span>DATOS DEL INGRESO</span>
        </div>

        <!-- Cuerpo del Formulario en 2 Columnas -->
        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
            
            <!-- Columna Izquierda -->
            <div class="space-y-4">
                <!-- Fecha -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">Fecha</label>
                    <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-700 font-medium">
                </div>

                <!-- Hora -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">Hora</label>
                    <input type="time" name="hora" value="{{ old('hora', date('H:i')) }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-700 font-medium">
                </div>

                <!-- Proveedor -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">Proveedor</label>
                    <select name="id_proveedor" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-600 bg-white">
                        <option value="" disabled selected>Seleccionar proveedor...</option>
                        @foreach($proveedores as $prov)
                            @php
                                $idProv = $prov->IDProveedor ?? $prov->id_proveedor ?? $prov->id;
                                $nomProv = $prov->Nombre ?? $prov->nombre;
                            @endphp
                            <option value="{{ $idProv }}" {{ old('id_proveedor') == $idProv ? 'selected' : '' }}>
                                {{ $nomProv }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Patente -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">Patente del Vehículo</label>
                    <input type="text" name="patente" value="{{ old('patente') }}" placeholder="Ej:  AC523BD" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-700 uppercase font-mono placeholder:text-slate-400">
                </div>

                <!-- Chofer -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">Nombre del Chofer</label>
                    <input type="text" name="chofer" value="{{ old('chofer') }}" placeholder="Nombre y apellido"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-700 placeholder:text-slate-400">
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="space-y-4 flex flex-col justify-between">
                <div>
                    <!-- Peso Bruto -->
                    <div class="mb-4">
                        <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">Peso Bruto (KG)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fa-solid fa-scale-balanced"></i>
                            </span>
                            <input type="number" step="0.01" name="peso_bruto" value="{{ old('peso_bruto') }}" placeholder="0" required
                                class="w-full pl-9 pr-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-700 placeholder:text-slate-400 font-mono">
                        </div>
                    </div>

                    <!-- Tipo de Yerba -->
                    <div class="mb-4">
                        <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">Tipo de Yerba</label>
                        <select name="tipo_yerba" required
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-600 bg-white">
                            <option value="" disabled selected>Seleccionar tipo...</option>
                            <option value="Hoja Verde" {{ old('tipo_yerba') == 'Hoja Verde' ? 'selected' : '' }}>Hoja Verde</option>
                            <option value="Canchada" {{ old('tipo_yerba') == 'Canchada' ? 'selected' : '' }}>Canchada</option>
                        </select>
                    </div>

                    <!-- Observaciones -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 tracking-wider uppercase mb-1.5">Observaciones</label>
                        <textarea name="observaciones" rows="5" placeholder="Notas adicionales sobre el ingreso, estado de la carga, etc."
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-600 text-slate-700 placeholder:text-slate-400 resize-none">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer con fondo grisáceo tenue -->
        <div class="px-8 py-5 bg-[#F4F7FC] border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-xs text-slate-400">
                <i class="fa-regular fa-circle-question text-slate-400"></i>
                <span>Los campos marcados son obligatorios para registrar el ingreso</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('lotes.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition shadow-sm">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-semibold text-white bg-[#1A365D] hover:bg-[#12253f] rounded-lg transition shadow-sm">
                    Guardar registro
                </button>
            </div>
        </div>

    </form>
</div>
@endsection