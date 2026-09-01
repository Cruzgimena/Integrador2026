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
    Schema::create('consumos', function (Blueprint $table) {
        $table->id('id_consumo');
        $table->dateTime('fecha_hora');
        $table->decimal('kilos_consumidos', 10, 2);
        
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
        Schema::dropIfExists('consumos');
    }
};
