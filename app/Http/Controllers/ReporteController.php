<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReporteController extends Controller
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

    public function index(Request $request)
    {
        $tablaLote = $this->getTableName(['LOTE', 'lotes', 'lote']);
        $tablaProv = $this->getTableName(['PROVEEDOR', 'proveedores', 'proveedor']);

        $colIdLote = Schema::hasColumn($tablaLote, 'IDLote') ? 'IDLote' : (Schema::hasColumn($tablaLote, 'id_lote') ? 'id_lote' : 'id');
        $colIdProvLote = Schema::hasColumn($tablaLote, 'IDProveedor') ? 'IDProveedor' : 'id_proveedor';
        $colIdProv = Schema::hasColumn($tablaProv, 'IDProveedor') ? 'IDProveedor' : (Schema::hasColumn($tablaProv, 'id_proveedor') ? 'id_proveedor' : 'id');
        $colNombreProv = Schema::hasColumn($tablaProv, 'Nombre') ? 'Nombre' : 'nombre';
        $colFechaEntrada = Schema::hasColumn($tablaLote, 'FechaHoraEntrada') ? 'FechaHoraEntrada' : 'fecha_hora_entrada';
        $colPesoNeto = Schema::hasColumn($tablaLote, 'PesoNeto') ? 'PesoNeto' : 'peso_neto';

        // Proveedores para el desplegable de filtro
        $proveedores = DB::table($tablaProv)->orderBy($colNombreProv)->get();

        // Parámetros de búsqueda
        $tipoReporte = $request->get('tipo_reporte', 'diario'); // diario o proveedor
        $proveedorSeleccionado = $request->get('id_proveedor');
        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');

        $query = DB::table($tablaLote)
            ->leftJoin($tablaProv, "{$tablaLote}.{$colIdProvLote}", '=', "{$tablaProv}.{$colIdProv}")
            ->select(
                "{$tablaLote}.*",
                "{$tablaProv}.{$colNombreProv} as proveedor_nombre"
            );

        // Si se presionó filtrar / generar reporte
        $reporteGenerado = $request->has('generar');

        if ($reporteGenerado) {
            if ($tipoReporte === 'diario' && $fechaDesde) {
                $query->whereDate("{$tablaLote}.{$colFechaEntrada}", $fechaDesde);
            } else {
                if ($fechaDesde) {
                    $query->whereDate("{$tablaLote}.{$colFechaEntrada}", '>=', $fechaDesde);
                }
                if ($fechaHasta) {
                    $query->whereDate("{$tablaLote}.{$colFechaEntrada}", '<=', $fechaHasta);
                }
            }

            if ($proveedorSeleccionado) {
                $query->where("{$tablaLote}.{$colIdProvLote}", $proveedorSeleccionado);
            }

            $movimientos = $query->orderBy("{$tablaLote}.{$colIdLote}", 'desc')->get();
            $totalKilosNetos = $movimientos->sum($colPesoNeto);
        } else {
            // Por defecto muestra los últimos movimientos cargados en planta
            $movimientos = $query->orderBy("{$tablaLote}.{$colIdLote}", 'desc')->limit(20)->get();
            $totalKilosNetos = $movimientos->sum($colPesoNeto);
            $reporteGenerado = true;
        }

        return view('reportes.index', compact(
            'proveedores', 
            'movimientos', 
            'tipoReporte', 
            'proveedorSeleccionado', 
            'fechaDesde', 
            'fechaHasta', 
            'totalKilosNetos',
            'reporteGenerado'
        ));
    }
}