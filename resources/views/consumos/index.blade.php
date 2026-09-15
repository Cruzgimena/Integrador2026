@extends('layouts.app') 
@section('content')
    <h2>Listado de Consumos</h2>
    <p><a href="{{ route('consumos.create') }}">Registrar Nuevo Consumo</a></p>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr><th>ID</th><th>Lote (ID)</th><th>Cantidad Usada (Kg)</th><th>Fecha</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($consumos as $consumo)
            <tr>
                <td>{{ $consumo->id }}</td><td>{{ $consumo->lote_id }}</td><td>{{ $consumo->cantidad }}</td><td>{{ $consumo->fecha }}</td>
                <td><a href="{{ route('consumos.edit', $consumo->id) }}">Editar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection