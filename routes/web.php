<?php

use Illuminate\Support\Facades\Route;

// Importar todos los controladores
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CamionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\MovimientoStockController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas Resource crean todas las rutas del CRUD automáticamente
Route::resource('perfiles', PerfilController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('camiones', CamionController::class);
Route::resource('stock', StockController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('consumos', ConsumoController::class);
Route::resource('lotes', LoteController::class);
Route::resource('movimientos-stock', MovimientoStockController::class);