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
    Schema::create('camiones', function (Blueprint $table) {
        $table->string('patente', 15)->primary();
        $table->decimal('tara_fija', 10, 2);
        $table->boolean('tiene_tara_fija');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camions');
    }
};
