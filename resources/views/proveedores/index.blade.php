@extends('layouts.app') 

@section('content')

    <h2>Listado de Proveedores</h2>
    
    <p>
        <a href="{{ route('proveedores.create') }}">Agregar Nuevo Proveedor</a>
    </p>

    <!-- Tabla con los datos -->
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>CUIT</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->id_proveedor }}</td>
                <td>{{ $proveedor->nombre }}</td> 
                <td>{{ $proveedor->cuit }}</td> 
                <td>{{ $proveedor->telefono }}</td>
                <td>{{ $proveedor->email }}</td>
                <td>
                    <a href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection