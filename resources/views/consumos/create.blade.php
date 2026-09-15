@extends('layouts.app') 
@section('content')
    <h2>Registrar Consumo</h2>
    <form action="{{ route('consumos.store') }}" method="POST">
        @csrf 
        <label>ID del Lote:</label><br><input type="number" name="lote_id" required><br><br>
        <label>Cantidad a usar (Kg):</label><br><input type="number" name="cantidad" required><br><br>
        <label>Fecha:</label><br><input type="date" name="fecha"><br><br>
        <button type="submit">Guardar</button>
    </form>
    <br><a href="{{ route('consumos.index') }}">Volver al listado</a>
@endsection