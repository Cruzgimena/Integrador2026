<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class LoteController extends Controller
{
    public function index()
    {
        // Detectar si en MySQL está en mayúsculas 'LOTE' o 'lotes'
        $tablaLote = Schema::hasTable('LOTE') ? 'LOTE' : 'lotes';
        $colId = Schema::hasColumn($tablaLote, 'IDLote') ? 'IDLote' : 'id_lote';

        $lotes = DB::table($tablaLote)->orderBy($colId, 'desc')->get();
        return view('lotes.index', compact('lotes'));
    }

    public function create()
    {
        $tablaProv = Schema::hasTable('PROVEEDOR') ? 'PROVEEDOR' : 'proveedores';
        $proveedores = DB::table($tablaProv)->get();
        return view('lotes.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required',
            'hora' => 'required',
            'id_proveedor' => 'required',
            'patente' => 'required|string|max:10',
            'peso_bruto' => 'required|numeric|min:0',
        ]);

        $patente = strtoupper(trim($request->patente));

        // 1. Tablas reales
        $tablaCamion = Schema::hasTable('CAMION') ? 'CAMION' : 'camiones';
        $tablaLote = Schema::hasTable('LOTE') ? 'LOTE' : 'lotes';
        $tablaUsuario = Schema::hasTable('USUARIO') ? 'USUARIO' : (Schema::hasTable('usuarios') ? 'usuarios' : 'users');

        // 2. Asegurar registro en tabla CAMION
        $colPatente = Schema::hasColumn($tablaCamion, 'Patente') ? 'Patente' : 'patente';
        if (!DB::table($tablaCamion)->where($colPatente, $patente)->exists()) {
            DB::table($tablaCamion)->insert([
                $colPatente => $patente,
                'TaraFija' => 0.00,
                'TieneTaraFija' => 0,
            ]);
        }

        // 3. Obtener el IDUsuario válido
        $colIdUser = Schema::hasColumn($tablaUsuario, 'IDUsuario') ? 'IDUsuario' : (Schema::hasColumn($tablaUsuario, 'id_usuario') ? 'id_usuario' : 'id');
        $idUsuario = DB::table($tablaUsuario)->value($colIdUser) ?? 1;

        // 4. Armar el registro exacto a tu diagrama EER
        $fechaHoraEntrada = $request->fecha . ' ' . $request->hora . ':00';

        $registro = [
            'IDProveedor'      => $request->id_proveedor,
            'Patente'          => $patente,
            'IDUsuario'        => $idUsuario,
            'FechaHoraEntrada' => $fechaHoraEntrada,
            'FechaHoraSalida'  => null,
            'PesoBruto'        => $request->peso_bruto,
            'Tara'             => 0.00,
            'PesoNeto'         => 0.00,
            'Calidad'          => 'Pendiente',
            'NombreChofer'     => $request->chofer ?? 'Sin chofer',
        ];

        // 5. Insertar directamente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($tablaLote)->insert($registro);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('lotes.index')->with('success', '¡Entrada de camión guardada con éxito!');
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}