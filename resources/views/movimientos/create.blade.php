@extends('layouts.app') 
@section('content')
    <h2>Registrar Movimiento</h2>
    <form action="{{ route('movimientos.store') }}" method="POST">
        @csrf 
        <label>Tipo (Entrada/Salida):</label><br><input type="text" name="tipo" required><br><br>
        <label>Cantidad:</label><br><input type="number" name="cantidad" required><br><br>
        <label>Fecha:</label><br><input type="date" name="fecha"><br><br>
        <button type="submit">Guardar</button>
    </form>
    <br><a href="{{ route('movimientos.index') }}">Volver</a>
@endsection