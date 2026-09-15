@extends('layouts.app') 

@section('content')
    <h2>Listado de Lotes de Yerba</h2>
    <p><a href="{{ route('lotes.create') }}">Ingresar Nuevo Lote</a></p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código de Lote</th>
                <th>Cantidad (Kg)</th>
                <th>Fecha Ingreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lotes as $lote)
            <tr>
                <td>{{ $lote->id }}</td>
                <td>{{ $lote->codigo }}</td> 
                <td>{{ $lote->cantidad_kg }}</td> 
                <td>{{ $lote->fecha_ingreso }}</td>
                <td>
                    <a href="{{ route('lotes.edit', $lote->id) }}">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection