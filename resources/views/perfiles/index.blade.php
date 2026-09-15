@extends('layouts.app') 
@section('content')
    <h2>Perfiles de Usuario</h2>
    <p><a href="{{ route('perfiles.create') }}">Nuevo Perfil</a></p>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr><th>ID</th><th>Nombre del Perfil</th><th>Descripción</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($perfiles as $perfil)
            <tr>
                <td>{{ $perfil->id }}</td><td>{{ $perfil->nombre }}</td><td>{{ $perfil->descripcion }}</td>
                <td><a href="{{ route('perfiles.edit', $perfil->id) }}">Editar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection