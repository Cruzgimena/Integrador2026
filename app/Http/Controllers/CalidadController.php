<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CalidadController extends Controller
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

    public function create(Request $request)
    {
        $tablaLote = $this->getTableName(['LOTE', 'lotes', 'lote']);
        $colIdLote = Schema::hasColumn($tablaLote, 'IDLote') ? 'IDLote' : (Schema::hasColumn($tablaLote, 'id_lote') ? 'id_lote' : 'id');
        $colCalidad = Schema::hasColumn($tablaLote, 'calidad') ? 'calidad' : (Schema::hasColumn($tablaLote, 'Calidad') ? 'Calidad' : null);
        $colPatente = Schema::hasColumn($tablaLote, 'Patente') ? 'Patente' : (Schema::hasColumn($tablaLote, 'patente') ? 'patente' : null);

        // Traer los lotes que estén pendientes de calidad o los más recientes
        $query = DB::table($tablaLote)->orderBy($colIdLote, 'desc');
        if ($colCalidad) {
            // Opcional: ordenar o filtrar
        }
        $lotes = $query->limit(30)->get();

        $loteSeleccionado = null;
        if ($request->filled('id_lote')) {
            $loteSeleccionado = DB::table($tablaLote)->where($colIdLote, $request->id_lote)->first();
        }

        return view('calidad.create', compact('lotes', 'loteSeleccionado', 'colIdLote', 'colPatente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_lote' => 'required',
            'calidad' => 'required|in:Buena,Regular,Mala',
            'humedad' => 'nullable|numeric|min:0|max:100',
            'impurezas' => 'nullable|numeric|min:0|max:100',
            'color' => 'nullable|string',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $tablaLote = $this->getTableName(['LOTE', 'lotes', 'lote']);
        $colIdLote = Schema::hasColumn($tablaLote, 'IDLote') ? 'IDLote' : (Schema::hasColumn($tablaLote, 'id_lote') ? 'id_lote' : 'id');

        $datosActualizar = [];

        // Columna de calidad (ENUM o VARCHAR)
        if (Schema::hasColumn($tablaLote, 'calidad')) {
            $datosActualizar['calidad'] = $request->calidad;
        } elseif (Schema::hasColumn($tablaLote, 'Calidad')) {
            $datosActualizar['Calidad'] = $request->calidad;
        }

        // Si tu tabla LOTE tiene los campos específicos de inspección
        if (Schema::hasColumn($tablaLote, 'humedad')) $datosActualizar['humedad'] = $request->humedad;
        if (Schema::hasColumn($tablaLote, 'impurezas')) $datosActualizar['impurezas'] = $request->impurezas;
        if (Schema::hasColumn($tablaLote, 'color')) $datosActualizar['color'] = $request->color;
        if (Schema::hasColumn($tablaLote, 'observaciones')) $datosActualizar['observaciones'] = $request->observaciones;

        DB::table($tablaLote)->where($colIdLote, $request->id_lote)->update($datosActualizar);

        return redirect()->route('calidad.create')->with('success', 'Control de calidad registrado correctamente para el lote #' . $request->id_lote);
    }
}
