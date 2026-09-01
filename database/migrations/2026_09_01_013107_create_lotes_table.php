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
    Schema::create('lotes', function (Blueprint $table) {
        $table->id('id_lote');
        $table->dateTime('fecha_hora_entrada');
        $table->dateTime('fecha_hora_salida')->nullable(); 
        $table->decimal('peso_bruto', 10, 2);
        $table->decimal('tara', 10, 2);
        $table->decimal('peso_neto', 10, 2);
        $table->string('calidad', 10);
        
        // Clave foránea a Proveedor
        $table->unsignedBigInteger('id_proveedor');
        $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedores');
        
        // Clave foránea a Camión 
        $table->string('patente', 15);
        $table->foreign('patente')->references('patente')->on('camiones');
        
        // Clave foránea a Usuario 
        $table->unsignedBigInteger('id_usuario');
        $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
