@extends('layouts.app') 
@section('content')
    <h2>Crear Perfil</h2>
    <form action="{{ route('perfiles.store') }}" method="POST">
        @csrf 
        <label>Nombre del Perfil:</label><br><input type="text" name="nombre" required><br><br>
        <label>Descripción:</label><br><input type="text" name="descripcion"><br><br>
        <button type="submit">Guardar</button>
    </form>
    <br><a href="{{ route('perfiles.index') }}">Volver</a>
@endsection