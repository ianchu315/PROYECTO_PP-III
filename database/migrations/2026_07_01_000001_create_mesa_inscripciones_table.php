<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla "mesa_inscripciones": registra que un usuario (alumno) se
 * inscribio a una mesa de examen en una fecha determinada.
 *
 * El archivo original estaba vacio y con un error de sintaxis (la tabla no
 * definia ninguna columna). Aca queda reconstruido.
 *
 * La regla "un alumno se inscribe a una sola materia por dia" se garantiza a
 * nivel de base con el indice unico (usuario_id, fecha_inscripcion): la base
 * rechaza una segunda inscripcion del mismo alumno para la misma fecha.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mesa_inscripciones')) {
            return;
        }

        Schema::create('mesa_inscripciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('mesa_id');
            $table->date('fecha_inscripcion');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mesa_id')->references('id')->on('mesas')
                  ->onDelete('cascade')->onUpdate('cascade');

            // Una sola inscripcion por alumno y por dia.
            $table->unique(['usuario_id', 'fecha_inscripcion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesa_inscripciones');
    }
};
