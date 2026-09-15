@extends('layouts.app') 

@section('content')
    <h2>Agregar Nuevo Camión</h2>
    <form action="{{ route('camiones.store') }}" method="POST">
        @csrf 
        <label>Patente:</label><br>
        <input type="text" name="patente" required><br><br>

        <label>Marca:</label><br>
        <input type="text" name="marca"><br><br>

        <label>Capacidad (Kg):</label><br>
        <input type="number" name="capacidad"><br><br>

        <button type="submit">Guardar Camión</button>
    </form>
    <br>
    <a href="{{ route('camiones.index') }}">Volver al listado</a>
@endsection