<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\SalidaCamionController;

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

// 3. Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Panel principal tras iniciar sesión
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Módulo Báscula - Entrada de Camiones (Lotes)
    Route::get('/lotes/crear', [LoteController::class, 'create'])->name('lotes.create');
    Route::post('/lotes', [LoteController::class, 'store'])->name('lotes.store');
    Route::get('/lotes', [LoteController::class, 'index'])->name('lotes.index');

    // Módulo Báscula - Salida de Camiones
    Route::get('/salidas/crear', [SalidaCamionController::class, 'create'])->name('salidas.create');
    Route::post('/salidas', [SalidaCamionController::class, 'store'])->name('salidas.store');
    Route::get('/salidas', [SalidaCamionController::class, 'index'])->name('salidas.index');
});