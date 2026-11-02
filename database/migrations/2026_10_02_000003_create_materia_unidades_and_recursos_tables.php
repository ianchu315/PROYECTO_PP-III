<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materia_unidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materia_id');
            $table->string('titulo', 160);
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->timestamps();

            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
            $table->index(['materia_id', 'orden']);
        });

        Schema::create('materia_recursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidad_id');
            $table->string('nombre_original', 255);
            $table->string('ruta', 500);
            $table->string('tipo_mime', 150)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->timestamps();

            $table->foreign('unidad_id')->references('id')->on('materia_unidades')->onDelete('cascade');
            $table->index('unidad_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materia_recursos');
        Schema::dropIfExists('materia_unidades');
    }
};
