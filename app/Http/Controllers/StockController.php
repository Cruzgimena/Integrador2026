<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StockController extends Controller
{
    private function getTableName($posibles)
    {
        foreach ($posibles as $nombre) {
            if (Schema::hasTable($nombre)) {
                return $nombre;
            }
        }
        return $posibles[0];
    }

    public function index()
    {
        $tablaStock = $this->getTableName(['stock', 'STOCK', 'stocks']);
        $colIdStock = Schema::hasColumn($tablaStock, 'IDStock') ? 'IDStock' : (Schema::hasColumn($tablaStock, 'id_stock') ? 'id_stock' : 'id');
        $colStockActual = Schema::hasColumn($tablaStock, 'StockActual') ? 'StockActual' : (Schema::hasColumn($tablaStock, 'stock_actual') ? 'stock_actual' : 'cantidad');
        $colUmbralMin = Schema::hasColumn($tablaStock, 'UmbralMinimo') ? 'UmbralMinimo' : (Schema::hasColumn($tablaStock, 'umbral_minimo') ? 'umbral_minimo' : 'stock_minimo');

        // Si la tabla está vacía, creamos el silo inicial
        if (DB::table($tablaStock)->count() === 0) {
            DB::table($tablaStock)->insert([
                $colStockActual => 0.00,
                $colUmbralMin   => 5000.00,
            ]);
        }

        $stocks = DB::table($tablaStock)->get();
        $stockPrincipal = $stocks->first();

        // Detectar tabla de movimientos si existe
        $tablaMov = $this->getTableName(['MOVIMIENTO_STOCK', 'movimiento_stock', 'movimientos_stock']);
        $movimientos = collect([]);

        if (Schema::hasTable($tablaMov)) {
            $colIdMov = Schema::hasColumn($tablaMov, 'IDMovimiento') ? 'IDMovimiento' : 'id';
            $movimientos = DB::table($tablaMov)->orderBy($colIdMov, 'desc')->limit(15)->get();
        }

        // Busca si la vista se llama stocks.blade.php o stocks/index.blade.php
        $vista = view()->exists('stocks.index') ? 'stocks.index' : 'stocks';

        return view($vista, compact('stocks', 'stockPrincipal', 'movimientos', 'colIdStock', 'colStockActual', 'colUmbralMin'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function edit($id)
    {
        $tablaStock = $this->getTableName(['stock', 'STOCK', 'stocks']);
        $colIdStock = Schema::hasColumn($tablaStock, 'IDStock') ? 'IDStock' : 'id';
        $stock = DB::table($tablaStock)->where($colIdStock, $id)->first();

        return view('stocks.edit', compact('stock'));
    }
}