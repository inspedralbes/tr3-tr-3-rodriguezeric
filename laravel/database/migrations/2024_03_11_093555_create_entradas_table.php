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
        Schema::create('entradas', function (Blueprint $table) {
            $table->id('id_entrada');
            $table->unsignedBigInteger('id_sesion');
            $table->unsignedBigInteger('id_butaca');
            $table->decimal('precio', 8, 2);

            // Agregar la clave foránea
            $table->foreign('id_sesion')->references('id')->on('sessios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};

