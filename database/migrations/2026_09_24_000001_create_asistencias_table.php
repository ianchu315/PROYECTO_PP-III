<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla "asistencias": registro de presente/ausente de un alumno en una
 * materia, clase por clase (por fecha). Es la base mínima para que el
 * preceptor pueda calcular el % de asistencia de cada alumno.
 *
 * Nota: la asistencia todavía no estaba modelada en el proyecto (ver
 * AsistenciaPendienteController). El otro grupo viene desarrollando su
 * propio módulo de asistencias por separado; cuando se unan los dos
 * trabajos, esta tabla se puede reconciliar/migrar a la de ellos sin tocar
 * el resto del panel de preceptor (todo pasa por el modelo Asistencia).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('asistencias')) {
            return;
        }

        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('materia_id')->unsigned();
            $table->date('fecha');
            $table->boolean('presente')->default(true);
            // Preceptor (usuario, guard "usuarios") que cargó el registro.
            $table->bigInteger('registrado_por')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('registrado_por')->references('id')->on('usuarios')->onDelete('set null')->onUpdate('cascade');

            // Un solo registro de asistencia por alumno/materia/día.
            $table->unique(['usuario_id', 'materia_id', 'fecha'], 'asistencias_unica_por_dia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
