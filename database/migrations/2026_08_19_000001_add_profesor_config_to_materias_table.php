<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            // Profesor (usuarios, guard "usuarios", rol=profesor) a cargo de la materia.
            // Se deja separado del "profesor_id" viejo (tabla profesors) para no tocar
            // lo que ya usa el módulo de mesas.
            $table->unsignedBigInteger('profesor_usuario_id')->nullable()->after('profesor_id');

            // Cantidad de notas por cuatrimestre que carga el profesor. Se define una
            // sola vez y despues queda bloqueada (ver notas_configuradas).
            $table->unsignedTinyInteger('cantidad_notas_cuatrimestre')->nullable()->after('profesor_usuario_id');
            $table->boolean('notas_configuradas')->default(false)->after('cantidad_notas_cuatrimestre');

            $table->foreign('profesor_usuario_id')
                ->references('id')->on('usuarios')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropForeign(['profesor_usuario_id']);
            $table->dropColumn(['profesor_usuario_id', 'cantidad_notas_cuatrimestre', 'notas_configuradas']);
        });
    }
};
