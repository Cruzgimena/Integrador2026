@extends('layouts.app') 
@section('content')
    <h2>Inventario (Stock)</h2>
    <p><a href="{{ route('stocks.create') }}">Cargar Stock Inicial</a></p>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr><th>ID</th><th>Producto</th><th>Cantidad Disponible</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->id }}</td><td>{{ $stock->producto_nombre }}</td><td>{{ $stock->cantidad }}</td>
                <td><a href="{{ route('stocks.edit', $stock->id) }}">Editar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection