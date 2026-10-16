<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SalidaCamionController extends Controller
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
        $tablaLote = $this->getTableName(['lotes', 'LOTE', 'lote']);
        $tablaProv = $this->getTableName(['proveedores', 'PROVEEDOR', 'proveedor']);
        $colSalida = Schema::hasColumn($tablaLote, 'FechaHoraSalida') ? 'FechaHoraSalida' : 'fecha_hora_salida';
        $colPatente = Schema::hasColumn($tablaLote, 'Patente') ? 'Patente' : 'patente';
        $colIdLote = Schema::hasColumn($tablaLote, 'IDLote') ? 'IDLote' : (Schema::hasColumn($tablaLote, 'id_lote') ? 'id_lote' : 'id');
        $colIdProvLote = Schema::hasColumn($tablaLote, 'IDProveedor') ? 'IDProveedor' : 'id_proveedor';
        $colIdProv = Schema::hasColumn($tablaProv, 'IDProveedor') ? 'IDProveedor' : (Schema::hasColumn($tablaProv, 'id_proveedor') ? 'id_proveedor' : 'id');
        $colNombreProv = Schema::hasColumn($tablaProv, 'Nombre') ? 'Nombre' : 'nombre';

        $lote = null;
        $termino = trim($request->get('buscar', ''));

        if (!empty($termino)) {
            // Busca lotes que aún no tengan fecha de salida registrada
            $query = DB::table($tablaLote)
                ->leftJoin($tablaProv, "{$tablaLote}.{$colIdProvLote}", '=', "{$tablaProv}.{$colIdProv}")
                ->whereNull("{$tablaLote}.{$colSalida}")
                ->select(
                    "{$tablaLote}.*",
                    "{$tablaProv}.{$colNombreProv} as proveedor_nombre"
                );

            if (is_numeric($termino)) {
                $query->where("{$tablaLote}.{$colIdLote}", $termino);
            } else {
                $query->where("{$tablaLote}.{$colPatente}", strtoupper($termino));
            }

            $lote = $query->first();

            if (!$lote) {
                return redirect()->route('salidas.create')->with('error', "No se encontró ningún camión en planta con la patente o nro. de entrada: {$termino}");
            }
        }

        return view('salidas.create', compact('lote', 'termino'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_lote' => 'required',
            'peso_tara' => 'required|numeric|min:1',
            'peso_neto' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);

        $tablaLote = $this->getTableName(['lotes', 'LOTE', 'lote']);
        $colIdLote = Schema::hasColumn($tablaLote, 'IDLote') ? 'IDLote' : (Schema::hasColumn($tablaLote, 'id_lote') ? 'id_lote' : 'id');

        $datosActualizar = [];

        // Tara
        if (Schema::hasColumn($tablaLote, 'Tara')) {
            $datosActualizar['Tara'] = $request->peso_tara;
        } else {
            $datosActualizar['tara'] = $request->peso_tara;
        }

        // Peso Neto
        if (Schema::hasColumn($tablaLote, 'PesoNeto')) {
            $datosActualizar['PesoNeto'] = $request->peso_neto;
        } else {
            $datosActualizar['peso_neto'] = $request->peso_neto;
        }

        // Fecha y Hora de Salida
        if (Schema::hasColumn($tablaLote, 'FechaHoraSalida')) {
            $datosActualizar['FechaHoraSalida'] = now();
        } else {
            $datosActualizar['fecha_hora_salida'] = now();
        }

        if (Schema::hasColumn($tablaLote, 'updated_at')) {
            $datosActualizar['updated_at'] = now();
        }

        DB::table($tablaLote)->where($colIdLote, $request->id_lote)->update($datosActualizar);

        return redirect()->route('lotes.index')->with('success', '¡Salida registrada y egreso completado correctamente!');
    }
}
