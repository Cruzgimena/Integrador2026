<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class ConsumoController extends Controller
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
    $tablaMov = $this->getTableName(['MOVIMIENTO_STOCK', 'movimiento_stock', 'movimientos_stock', 'consumos']);

    // Detecta automáticamente si la columna es IDMovimiento, id_movimiento o id
    $colId = Schema::hasColumn($tablaMov, 'IDMovimiento') 
        ? 'IDMovimiento' 
        : (Schema::hasColumn($tablaMov, 'id_movimiento') 
            ? 'id_movimiento' 
            : (Schema::hasColumn($tablaMov, 'id') ? 'id' : null));

    $query = DB::table($tablaMov);

    if ($colId) {
        $query->orderBy($colId, 'desc');
    }

    $consumos = $query->get();

    return view('consumos.index', compact('consumos'));
}

    public function create()
    {
        $tablaStock = $this->getTableName(['STOCK', 'stocks', 'stock']);
        $colStockActual = Schema::hasColumn($tablaStock, 'StockActual') ? 'StockActual' : 'stock_actual';
        $colUmbral = Schema::hasColumn($tablaStock, 'UmbralMinimo') ? 'UmbralMinimo' : 'umbral_minimo';

        $stock = DB::table($tablaStock)->first();
        $stockActual = $stock ? ($stock->$colStockActual ?? 0) : 0;
        $umbralMinimo = $stock ? ($stock->$colUmbral ?? 500) : 500;

        return view('consumos.create', compact('stockActual', 'umbralMinimo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'materia_prima' => 'required|string',
            'cantidad' => 'required|numeric|min:0.01',
            'destino' => 'required|string',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $tablaStock = $this->getTableName(['STOCK', 'stocks', 'stock']);
        $colIdStock = Schema::hasColumn($tablaStock, 'IDStock') ? 'IDStock' : 'id';
        $colStockActual = Schema::hasColumn($tablaStock, 'StockActual') ? 'StockActual' : 'stock_actual';
        $colUmbral = Schema::hasColumn($tablaStock, 'UmbralMinimo') ? 'UmbralMinimo' : 'umbral_minimo';

        $stock = DB::table($tablaStock)->first();
        $stockDisponible = $stock ? ($stock->$colStockActual ?? 0) : 0;
        $kilosConsumir = (float) $request->cantidad;

        if ($kilosConsumir > $stockDisponible) {
            return back()->withInput()->with('error', 'No hay stock suficiente disponible (' . number_format($stockDisponible, 2, ',', '.') . ' kg) para registrar este consumo.');
        }

        DB::beginTransaction();
        try {
            // 1. Descontar del stock disponible
            $nuevoStock = $stockDisponible - $kilosConsumir;
            DB::table($tablaStock)->where($colIdStock, $stock->$colIdStock)->update([
                $colStockActual => $nuevoStock,
                'updated_at' => now(),
            ]);

            // 2. Registrar el movimiento en MOVIMIENTO_STOCK
            $tablaMov = $this->getTableName(['MOVIMIENTO_STOCK', 'movimiento_stock', 'movimientos_stock']);
            if (Schema::hasTable($tablaMov)) {
                $colFechaMov = Schema::hasColumn($tablaMov, 'FechaHora') ? 'FechaHora' : 'fecha_hora';
                $colTipoMov = Schema::hasColumn($tablaMov, 'TipoMovimiento') ? 'TipoMovimiento' : 'tipo_movimiento';
                $colKilos = Schema::hasColumn($tablaMov, 'Kilos') ? 'Kilos' : 'kilos';
                $colUserMov = Schema::hasColumn($tablaMov, 'IDUsuario') ? 'IDUsuario' : (Schema::hasColumn($tablaMov, 'USUARIO_ID_Usuario') ? 'USUARIO_ID_Usuario' : 'id_usuario');
                $colStockMov = Schema::hasColumn($tablaMov, 'IDStock') ? 'IDStock' : 'id_stock';

                DB::table($tablaMov)->insert([
                    $colFechaMov => now(),
                    $colTipoMov => 'Salida',
                    $colKilos => $kilosConsumir,
                    $colUserMov => Auth::id() ?? 1,
                    $colStockMov => $stock->$colIdStock,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            $umbral = $stock->$colUmbral ?? 500;
            $alerta = $nuevoStock <= $umbral ? ' ¡Atención: el stock restante (' . number_format($nuevoStock, 2, ',', '.') . ' kg) ha quedado por debajo del umbral mínimo!' : '';

            return redirect()->route('consumos.create')->with('success', 'Consumo registrado exitosamente. Se descontaron ' . number_format($kilosConsumir, 2, ',', '.') . ' kg.' . $alerta);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al procesar el consumo: ' . $e->getMessage());
        }
    }
}