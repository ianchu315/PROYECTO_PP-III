<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Un código QR por clase (materia + fecha): el profesor lo genera desde la
 * planilla, con un tiempo de vigencia corto, y los alumnos lo escanean con
 * el celular para marcarse presentes solos, sin que el profesor tenga que
 * tildarlos uno por uno. El registro real de asistencia sigue yendo a la
 * tabla "asistencias" de siempre; esta tabla solo guarda el token y su
 * vigencia para poder validarlo.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('codigos_qr_asistencia')) {
            return;
        }

        Schema::create('codigos_qr_asistencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materia_id');
            $table->date('fecha');
            $table->string('token', 64)->unique();
            $table->unsignedBigInteger('creado_por'); // profesor (usuarios.id)
            $table->timestamp('expira_en');
            $table->timestamps();

            $table->foreign('materia_id')->references('id')->on('materias')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('creado_por')->references('id')->on('usuarios')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index(['materia_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('codigos_qr_asistencia');
    }
};
