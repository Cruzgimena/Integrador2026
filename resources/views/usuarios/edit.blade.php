@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-2">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Modificar Usuario #{{ $usuario->id }}</h2>
                    <p class="text-xs text-slate-400">Actualizá los datos de acceso o el perfil del usuario.</p>
                </div>
            </div>
            <a href="{{ route('usuarios.index') }}" class="text-xs text-slate-500 hover:text-slate-800 flex items-center gap-1.5 transition">
                <i class="fa-solid fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <form action="{{ route('usuarios.update', $usuario->getKey()) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            @php
                $userRol = $usuario->role ?? $usuario->rol ?? 'administrador';
            @endphp

            <div>
                <label for="name" class="block text-xs font-bold text-slate-600 mb-1.5">NOMBRE Y APELLIDO *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $usuario->name) }}" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                @error('name')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-600 mb-1.5">CORREO ELECTRÓNICO *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-xs font-bold text-slate-600 mb-1.5">ROL ASIGNADO *</label>
                    <select id="role" name="role" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 bg-white focus:outline-none focus:ring-1 focus:ring-blue-600">
                        <option value="operador_bascula" {{ old('role', $userRol) == 'operador_bascula' ? 'selected' : '' }}>Operador de Báscula</option>
                        <option value="encargado_stock" {{ old('role', $userRol) == 'encargado_stock' ? 'selected' : '' }}>Encargado de Stock</option>
                        <option value="administrador" {{ old('role', $userRol) == 'administrador' ? 'selected' : '' }}>Administrador General</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-600 mb-1.5">NUEVA CONTRASEÑA (OPCIONAL)</label>
                    <input type="password" id="password" name="password" placeholder="Dejar en blanco para mantener la actual"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-600 mb-1.5">CONFIRMAR NUEVA CONTRASEÑA</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repetir contraseña"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('usuarios.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2.5 text-xs font-semibold text-white bg-[#172b4d] hover:bg-[#101e36] rounded-xl shadow-sm transition">
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>

</div>
@endsection