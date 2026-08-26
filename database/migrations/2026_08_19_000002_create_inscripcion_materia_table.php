<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripcion_materia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // alumno
            $table->unsignedBigInteger('materia_id');
            $table->date('fecha_inscripcion')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('materia_id')->references('id')->on('materias')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['usuario_id', 'materia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripcion_materia');
    }
};
