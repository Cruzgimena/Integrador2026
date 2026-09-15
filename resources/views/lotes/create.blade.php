@extends('layouts.app') 

@section('content')
    <h2>Ingresar Nuevo Lote</h2>
    <form action="{{ route('lotes.store') }}" method="POST">
        @csrf 
        <label>Código de Lote:</label><br>
        <input type="text" name="codigo" required><br><br>

        <label>Cantidad (Kg):</label><br>
        <input type="number" name="cantidad_kg"><br><br>

        <label>Fecha Ingreso:</label><br>
        <input type="date" name="fecha_ingreso"><br><br>

        <button type="submit">Guardar Lote</button>
    </form>
    <br>
    <a href="{{ route('lotes.index') }}">Volver al listado</a>
@endsection