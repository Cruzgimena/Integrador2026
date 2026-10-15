<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - GestionandoTé
|--------------------------------------------------------------------------
*/

// 1. Redirigir la raíz del sitio directamente al login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Cargar todas las rutas automáticas de autenticación (login, logout, register)
Auth::routes();

// 3. Ruta del panel principal tras iniciar sesión
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');