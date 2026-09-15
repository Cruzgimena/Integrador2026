@extends('layouts.app') 
@section('content')
    <h2>Cargar Stock</h2>
    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf 
        <label>Nombre/ID del Producto:</label><br><input type="text" name="producto_nombre" required><br><br>
        <label>Cantidad Inicial:</label><br><input type="number" name="cantidad" required><br><br>
        <button type="submit">Guardar</button>
    </form>
    <br><a href="{{ route('stocks.index') }}">Volver</a>
@endsection