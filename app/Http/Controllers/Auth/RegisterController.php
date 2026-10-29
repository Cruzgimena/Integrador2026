<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre_usuario' => ['required', 'string', 'max:50', 'unique:users'],
            'nombres'        => ['required', 'string', 'max:150'],
            'apellido'       => ['required', 'string', 'max:45'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
            
        ], [
            // Mensajes personalizados en español
            'nombre_usuario.unique'   => 'El nombre de usuario ya se encuentra registrado.',
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'email.unique'            => 'El correo electrónico ya se encuentra registrado.',
            'email.required'          => 'El correo electrónico es obligatorio.',
            'email.email'             => 'Ingresá un correo electrónico válido.',
            'password.required'       => 'La contraseña es obligatoria.',
            'password.min'            => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'      => 'Las contraseñas ingresadas no coinciden.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Mapear el id_perfil numérico al nombre del rol que usa home.blade.php
        $mapRoles = [
            1 => 'administrador',
            2 => 'operador_bascula',
            3 => 'encargado_stock',
        ];

        $perfilId = (int) $data['id_perfil'];
        $rolTexto = $mapRoles[$perfilId] ?? 'operador_bascula';

        return User::create([
            'name'           => $data['nombres'] . ' ' . $data['apellido'],
            'nombre_usuario' => $data['nombre_usuario'],
            'nombres'        => $data['nombres'],
            'apellido'       => $data['apellido'],
            'email'          => $data['email'],
            'role'           => $rolTexto, // <-- Este campo faltaba
            'estado'         => 'activo',
            'password'       => Hash::make($data['password']),
        ]);
    }
}