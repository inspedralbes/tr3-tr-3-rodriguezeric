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
        Schema::create('sessios', function (Blueprint $table) {
            $table->id();
            $table->date('dia');
            $table->time('hora');
            $table->unsignedBigInteger('pelicula_id'); // Cambiar a unsignedBigInteger para el ID de la película
            $table->foreign('pelicula_id')->references('id')->on('peliculas'); // Agregar clave foránea para referenciar la tabla 'peliculas'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessios');
    }
};

