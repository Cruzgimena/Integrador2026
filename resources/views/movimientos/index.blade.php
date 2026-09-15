@extends('layouts.app') 
@section('content')
    <h2>Movimientos de Stock</h2>
    <p><a href="{{ route('movimientos.create') }}">Nuevo Movimiento</a></p>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr><th>ID</th><th>Tipo (Entrada/Salida)</th><th>Cantidad</th><th>Fecha</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($movimientos as $mov)
            <tr>
                <td>{{ $mov->id }}</td><td>{{ $mov->tipo }}</td><td>{{ $mov->cantidad }}</td><td>{{ $mov->fecha }}</td>
                <td><a href="{{ route('movimientos.edit', $mov->id) }}">Editar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection