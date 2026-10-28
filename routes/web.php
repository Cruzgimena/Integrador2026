<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\SalidaCamionController;
use App\Http\Controllers\CalidadController;
use App\Http\Controllers\StockController;

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

// 3. Rutas protegidas por login
Route::middleware(['auth'])->group(function () {
    
    // Panel Principal
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Módulo 1: Entrada de Camiones (Lotes)
    Route::get('/lotes', [LoteController::class, 'index'])->name('lotes.index');
    Route::get('/lotes/crear', [LoteController::class, 'create'])->name('lotes.create');
    Route::post('/lotes', [LoteController::class, 'store'])->name('lotes.store');

    // Módulo 2: Salida de Camiones
    Route::get('/salidas/crear', [SalidaCamionController::class, 'create'])->name('salidas.create');
    Route::post('/salidas', [SalidaCamionController::class, 'store'])->name('salidas.store');

    // Módulo 3: Control de Calidad
    Route::get('/calidad/crear', function () {
        return "Módulo de Control de Calidad en desarrollo";
    })->name('calidad.create');

    // Módulo 4: Consulta de Stock (ambos nombres para evitar problemas)
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');

    // Módulo 5: Consumo de Planta
    Route::get('/consumo', function () {
        return "Módulo de Consumo de Planta en desarrollo";
    })->name('consumo.index');

    // Módulo 6: Gestión de Usuarios
    Route::get('/usuarios', function () {
        return "Módulo de Usuarios en desarrollo";
    })->name('usuarios.index');

    // Módulo 7: Generar Reportes
    Route::get('/reportes', function () {
        return "Módulo de Reportes en desarrollo";
    })->name('reportes.index');

    // Módulo 8: Gestión de Datos
    Route::get('/datos', function () {
        return "Módulo de Gestión de Datos en desarrollo";
    })->name('datos.index');
});