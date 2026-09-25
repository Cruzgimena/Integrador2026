@extends('layouts.app')

@section('content')
    <section>
        <h2 class="destacado">Iniciar Sesión</h2>
        
        <div class="contenedor-articulo">
            <div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div style="margin-bottom: 15px;">
                        <label for="email" style="display: block; font-weight: bold;">Correo Electrónico:</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="width: 100%; padding: 8px;">

                        @error('email')
                            <span style="color: red; font-size: 14px;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="password" style="display: block; font-weight: bold;">Contraseña:</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 8px;">

                        @error('password')
                            <span style="color: red; font-size: 14px;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 15px;">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Recordarme</label>
                    </div>

                    <div>
                        <button type="submit" style="background-color: #2c3e50; color: white; padding: 10px 20px; border: none; font-weight: bold; cursor: pointer;">
                            Ingresar
                        </button>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="color: #2c3e50; margin-left: 15px; font-weight: normal;">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection