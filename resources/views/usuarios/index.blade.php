@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-2">

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

    <!-- Cabecera -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 bg-cyan-600 rounded-xl flex items-center justify-center text-white text-xl shadow-sm">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-[#172b4d] tracking-tight">Gestión de Usuarios</h1>
                <p class="text-xs text-slate-500 font-normal">Control de acceso, asignación de roles y estados para el personal de planta</p>
            </div>
        </div>

        <a href="{{ route('usuarios.create') }}" class="inline-flex items-center gap-2 bg-[#172b4d] hover:bg-[#101e36] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Nuevo Usuario</span>
        </a>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5">ID</th>
                        <th class="px-5 py-3.5">Nombre y Apellido</th>
                        <th class="px-5 py-3.5">Email / Usuario</th>
                        <th class="px-5 py-3.5 text-center">Rol Asignado</th>
                        <th class="px-5 py-3.5 text-center">Estado</th>
                        <th class="px-5 py-3.5 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($usuarios as $user)
                        @php
                            $idUsuario = $user->getKey();
                            $rol = $user->role ?? $user->rol ?? 'administrador';
                            $estado = $user->Estado ?? $user->estado ?? 'Activo';
                            $esActivo = (strtolower($estado) === 'activo');
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition text-xs">
                            <td class="px-5 py-4 font-mono font-bold text-slate-800">#{{ $idUsuario }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-800">{{ $user->name }}</td>
                            <td class="px-5 py-4 font-mono text-slate-600">{{ $user->email }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($rol === 'administrador')
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-cyan-100 text-cyan-800">
                                        Administrador
                                    </span>
                                @elseif($rol === 'operador_bascula')
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-blue-100 text-blue-800">
                                        Operador Báscula
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-800">
                                        Encargado Stock
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Columna interactiva de Estado -->
                            <td class="px-5 py-4 text-center">
                                @if(auth()->id() != $idUsuario)
                                    <form action="{{ route('usuarios.toggleEstado', $idUsuario) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
    onclick="return confirm('¿Deseas cambiar el estado de este usuario?');"
    class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-full transition shadow-sm {{ $esActivo ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-rose-100 text-rose-800 hover:bg-rose-200' }}">
    <i class="fa-solid {{ $esActivo ? 'fa-circle-check text-emerald-600' : 'fa-circle-xmark text-rose-600' }}"></i>
    <span>{{ $estado }}</span>
</button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-full bg-slate-100 text-slate-600">
                                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                        <span>{{ $estado }}</span>
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('usuarios.edit', $idUsuario) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i> Editar
                                    </a>

                                    @if(auth()->id() != $idUsuario)
                                        <form action="{{ route('usuarios.destroy', $idUsuario) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar a este usuario?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium flex items-center gap-1">
                                                <i class="fa-solid fa-trash-can text-[11px]"></i> Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                No hay usuarios dados de alta en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($usuarios->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>

</div>
@endsection