
@section('content')

    <h2>Agregar Nuevo Proveedor</h2>

    <!-- Formulario HTML puro -->
    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf 

        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="cuit">CUIT:</label><br>
        <input type="text" id="cuit" name="cuit"><br><br>

        <label for="telefono">Teléfono:</label><br>
        <input type="text" id="telefono" name="telefono"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>

        <button type="submit">Guardar Proveedor</button>
    </form>
    
    <br>
    <a href="{{ route('proveedores.index') }}">Volver al listado</a>

@endsection