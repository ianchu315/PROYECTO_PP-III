<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla "mesas": tabla central de las mesas de examen final.
 *
 * ATENCION: el archivo original con este mismo nombre NO creaba "mesas",
 * sino "mesa_inscripciones" (estaba mal nombrado). Aca queda corregido para
 * que cree realmente la tabla "mesas". La creacion de "mesa_inscripciones"
 * ahora vive en su propio archivo 2026_07_01_000001_create_mesa_inscripciones_table.php.
 *
 * Columnas tomadas del modelo App\Models\Mesa (fillable) y del MER del manual.
 * El modelo tiene $timestamps = false, por eso esta tabla NO lleva timestamps.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mesas')) {
            return;
        }

        Schema::create('mesas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('carrera_id');
            $table->unsignedBigInteger('anio_id')->nullable();
            $table->unsignedBigInteger('profesor_id');            // presidente de mesa
            $table->unsignedBigInteger('vocal_id')->nullable();   // vocal (tambien es un profesor)
            $table->date('fecha');
            $table->time('horario')->nullable();
            $table->string('comision', 30)->nullable();
            $table->unsignedBigInteger('salon_id')->nullable();
            $table->integer('inscriptos')->unsigned()->default(0);
            $table->unsignedBigInteger('resolucion_id')->nullable();

            // El modelo Mesa usa $timestamps = false, no agregamos created_at/updated_at.

            $table->foreign('materia_id')->references('id')->on('materias')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('carrera_id')->references('id')->on('carreras')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('anio_id')->references('id')->on('anios')
                  ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('profesor_id')->references('id')->on('profesors')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vocal_id')->references('id')->on('profesors')
                  ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('salon_id')->references('id')->on('salones')
                  ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('resolucion_id')->references('id')->on('resoluciones')
                  ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
