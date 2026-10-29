<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UsuarioController extends Controller
{
    public function index()
    {
        $colId = (new User)->getKeyName(); 

        $usuarios = User::orderBy($colId, 'desc')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:administrador,operador_bascula,encargado_stock',
        ], [
            'name.required'     => 'El nombre completo es obligatorio.',
            'email.unique'      => 'El correo electrónico ya se encuentra registrado.',
            'password.confirmed'=> 'Las contraseñas no coinciden.',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
            'role.required'     => 'Debe asignar un rol al usuario.',
        ]);

        // Separar nombre y apellido si viene nombre completo
        $partes = explode(' ', trim($request->name), 2);
        $nombres = $partes[0];
        $apellido = $partes[1] ?? '';

        $userData = [
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];

        // Compatibilidad con columna 'name' estándar si existe
        if (Schema::hasColumn('users', 'name')) {
            $userData['name'] = $request->name;
        }

        // Columnas reales de tu base de datos
        if (Schema::hasColumn('users', 'nombre_usuario')) {
            $userData['nombre_usuario'] = $request->name;
        } elseif (Schema::hasColumn('users', 'NombreUsuario')) {
            $userData['NombreUsuario'] = $request->name;
        }

        if (Schema::hasColumn('users', 'Nombres')) {
            $userData['Nombres'] = $nombres;
        } elseif (Schema::hasColumn('users', 'nombres')) {
            $userData['nombres'] = $nombres;
        }

        if (Schema::hasColumn('users', 'Apellido')) {
            $userData['Apellido'] = $apellido;
        } elseif (Schema::hasColumn('users', 'apellido')) {
            $userData['apellido'] = $apellido;
        }

        // Roles
        if (Schema::hasColumn('users', 'role')) {
            $userData['role'] = $request->role;
        }
        if (Schema::hasColumn('users', 'rol')) {
            $userData['rol'] = $request->role;
        }

        // Estado inicial
        if (Schema::hasColumn('users', 'Estado')) {
            $userData['Estado'] = 'Activo';
        } elseif (Schema::hasColumn('users', 'estado')) {
            $userData['estado'] = 'Activo';
        }

        User::create($userData);

        return redirect()->route('usuarios.index')->with('success', 'Usuario registrado correctamente en el sistema.');
    }

    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $idKey = $usuario->getKey();

        $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|max:150|unique:users,email,' . $idKey . ',' . $usuario->getKeyName(),
            'role'     => 'required|in:administrador,operador_bascula,encargado_stock',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $partes = explode(' ', trim($request->name), 2);
        $nombres = $partes[0];
        $apellido = $partes[1] ?? '';

        // Si existe columna 'name'
        if (Schema::hasColumn('users', 'name')) {
            $usuario->name = $request->name;
        }

        // Columnas reales de tu BD
        if (Schema::hasColumn('users', 'nombre_usuario')) {
            $usuario->nombre_usuario = $request->name;
        } elseif (Schema::hasColumn('users', 'NombreUsuario')) {
            $usuario->NombreUsuario = $request->name;
        }

        if (Schema::hasColumn('users', 'Nombres')) {
            $usuario->Nombres = $nombres;
        } elseif (Schema::hasColumn('users', 'nombres')) {
            $usuario->nombres = $nombres;
        }

        if (Schema::hasColumn('users', 'Apellido')) {
            $usuario->Apellido = $apellido;
        } elseif (Schema::hasColumn('users', 'apellido')) {
            $usuario->apellido = $apellido;
        }

        $usuario->email = $request->email;

        if (Schema::hasColumn('users', 'role')) {
            $usuario->role = $request->role;
        }
        if (Schema::hasColumn('users', 'rol')) {
            $usuario->rol = $request->role;
        }

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        if ($request->has('estado')) {
            if (Schema::hasColumn('users', 'Estado')) {
                $usuario->Estado = $request->estado;
            } elseif (Schema::hasColumn('users', 'estado')) {
                $usuario->estado = $request->estado;
            }
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Datos del usuario actualizados con éxito.');
    }

    public function destroy(User $usuario)
    {
        if (auth()->id() === $usuario->getKey()) {
            return back()->with('error', 'No podés eliminar tu propia cuenta mientras estés en sesión.');
        }

        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado de la base de datos.');
    }

    public function toggleEstado(User $usuario)
    {
        if (auth()->id() === $usuario->getKey()) {
            return back()->with('error', 'No podés modificar el estado de tu propia sesión.');
        }

        $colEstado = Schema::hasColumn('users', 'Estado') ? 'Estado' : 'estado';
        $actual = strtolower($usuario->$colEstado ?? 'activo');
        $nuevo = ($actual === 'activo') ? 'Inactivo' : 'Activo';

        $usuario->$colEstado = $nuevo;
        $usuario->save();

        return back()->with('success', "Estado actualizado: {$usuario->name} ahora está {$nuevo}.");
    }
}
