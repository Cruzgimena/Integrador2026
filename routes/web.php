<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\SalidaCamionController;
use App\Http\Controllers\CalidadController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Web Routes - GestionandoTé
|--------------------------------------------------------------------------
*/

// 1. Redirigir la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Rutas de autenticación
Auth::routes();

// 3. Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Panel Principal (Acceso para todos los usuarios autenticados)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ----------------------------------------------------------------------
    // GRUPO 1: Operador de Báscula y Administrador
    // ----------------------------------------------------------------------
    Route::middleware(['role:administrador,operador_bascula'])->group(function () {
        // Módulo 1: Entrada de Camiones (Lotes)
        Route::get('/lotes', [LoteController::class, 'index'])->name('lotes.index');
        Route::get('/lotes/crear', [LoteController::class, 'create'])->name('lotes.create');
        Route::post('/lotes', [LoteController::class, 'store'])->name('lotes.store');

        // Módulo 2: Salida de Camiones
        Route::get('/salidas/crear', [SalidaCamionController::class, 'create'])->name('salidas.create');
        Route::post('/salidas', [SalidaCamionController::class, 'store'])->name('salidas.store');

        // Módulo 3: Control de Calidad
        Route::get('/calidad/crear', [CalidadController::class, 'create'])->name('calidad.create');
        Route::post('/calidad', [CalidadController::class, 'store'])->name('calidad.store');
    });

    // ----------------------------------------------------------------------
    // GRUPO 2: Encargado de Stock y Administrador
    // ----------------------------------------------------------------------
    Route::middleware(['role:administrador,encargado_stock'])->group(function () {
        // Módulo 4: Consulta de Stock
        Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
        Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');

        // Módulo 5: Consumo de Planta
        Route::get('/consumos', [ConsumoController::class, 'index'])->name('consumos.index');
        Route::get('/consumos/crear', [ConsumoController::class, 'create'])->name('consumos.create');
        Route::post('/consumos', [ConsumoController::class, 'store'])->name('consumos.store');
    });

    // ----------------------------------------------------------------------
    // GRUPO 3: Exclusivo Administrador General
    // ----------------------------------------------------------------------
    Route::middleware(['role:administrador'])->group(function () {
        // Módulo 6: Gestión de Usuarios y Cambio de Estados
        Route::resource('usuarios', UsuarioController::class);
        Route::patch('/usuarios/{usuario}/estado', [UsuarioController::class, 'toggleEstado'])->name('usuarios.toggleEstado');

        // Módulo 7: Generar Reportes
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    });

});