@extends('layouts.app') 

@section('content')
    <h2>Listado de Camiones</h2>
    <p><a href="{{ route('camiones.create') }}">Agregar Nuevo Camión</a></p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patente</th>
                <th>Marca</th>
                <th>Capacidad (Kg)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($camiones as $camion)
            <tr>
                <td>{{ $camion->id }}</td>
                <td>{{ $camion->patente }}</td> 
                <td>{{ $camion->marca }}</td> 
                <td>{{ $camion->capacidad }}</td>
                <td>
                    <a href="{{ route('camiones.edit', $camion->id) }}">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection