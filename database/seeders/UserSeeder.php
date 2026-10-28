<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Asegurar la columna 'role' en la tabla users si aún no existe
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role')) {
            Schema::table('users', function ($table) {
                $table->string('role')->default('operador_bascula')->after('email');
            });
        }

        // 2. Definir los 3 usuarios según el documento de GestionandoTé
        $usuarios = [
            [
                'name' => 'Administrador General',
                'email' => 'admin@yerbatera.com',
                'password' => Hash::make('admin123'),
                'role' => 'administrador',
            ],
            [
                'name' => 'Operador Báscula (Pesador)',
                'email' => 'bascula@yerbatera.com',
                'password' => Hash::make('bascula123'),
                'role' => 'operador_bascula',
            ],
            [
                'name' => 'Encargado de Stock (Planta)',
                'email' => 'planta@yerbatera.com',
                'password' => Hash::make('planta123'),
                'role' => 'encargado_stock',
            ],
        ];

        foreach ($usuarios as $u) {
            DB::table('users')->updateOrInsert(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => $u['password'],
                    'role' => $u['role'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}