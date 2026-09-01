<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('movimientos_stock', function (Blueprint $table) {
        $table->id('id_movimiento');
        $table->dateTime('fecha_hora');
        $table->string('tipo_movimiento', 10); // Acá va a ir 'INGRESO' o 'CONSUMO'
        $table->decimal('kilos', 10, 2);
        
        // Clave foránea a Usuario
        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        
        // Clave foránea a Lote
        $table->unsignedBigInteger('id_lote');
        $table->foreign('id_lote')->references('id_lote')->on('lotes');
        
        // Clave foránea a Stock
        $table->unsignedBigInteger('id_stock');
        $table->foreign('id_stock')->references('id_stock')->on('stocks');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_stocks');
    }
};
