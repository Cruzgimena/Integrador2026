<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proveedores')->insert([
            [
                'nombre'     => 'Establecimiento Las Marías',
                'cuit'       => '30123456789',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre'     => 'Yerba Mate Misionera S.A.',
                'cuit'       => '30987654321',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre'     => 'Cooperativa Agrícola Alem',
                'cuit'       => '30555666779',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}