<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // El administrador siempre tiene acceso total
        if ($user->role === 'administrador') {
            return $next($request);
        }

        // Si el rol del usuario está dentro de los permitidos
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Si no tiene permisos, lo devolvemos al menú con alerta
        return redirect()->route('home')->with('error', 'No tenés permisos habilitados para acceder a este módulo.');
    }
}
