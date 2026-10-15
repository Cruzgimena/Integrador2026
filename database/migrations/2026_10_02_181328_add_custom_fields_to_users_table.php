<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nombre_usuario', 50)->unique()->after('id');
            $table->string('nombres', 150)->after('nombre_usuario');
            $table->string('apellido', 45)->after('nombres');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->after('apellido');
            $table->unsignedBigInteger('id_perfil')->default(1)->after('estado'); // 1: Administrador, 2: Operador de báscula, 3: Encargado de stock
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nombre_usuario', 'nombres', 'apellido', 'estado', 'id_perfil']);
        });
    }
};