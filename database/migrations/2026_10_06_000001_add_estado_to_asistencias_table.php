<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * La asistencia pasa a gestionarla únicamente el profesor (antes la
 * cargaba el preceptor). Esta migración incorpora al modelo existente
 * (tabla "asistencias", ligada a usuarios/materias) las ideas del módulo
 * de asistencia que venía desarrollándose por separado: un estado con más
 * matices que presente/ausente (agrega "tarde" y "justificado") y el
 * motivo de la justificación. Reemplaza la columna booleana "presente".
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('asistencias', 'estado')) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->string('estado', 20)->default('presente')->after('fecha');
                $table->string('motivo_justificacion', 100)->nullable()->after('estado');
            });
        }

        if (Schema::hasColumn('asistencias', 'presente')) {
            DB::table('asistencias')->where('presente', true)->update(['estado' => 'presente']);
            DB::table('asistencias')->where('presente', false)->update(['estado' => 'ausente']);

            Schema::table('asistencias', function (Blueprint $table) {
                $table->dropColumn('presente');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('asistencias', 'presente')) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->boolean('presente')->default(true)->after('fecha');
            });

            DB::table('asistencias')->where('estado', 'presente')->update(['presente' => true]);
            DB::table('asistencias')->where('estado', '!=', 'presente')->update(['presente' => false]);
        }

        if (Schema::hasColumn('asistencias', 'motivo_justificacion')) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->dropColumn('motivo_justificacion');
            });
        }

        if (Schema::hasColumn('asistencias', 'estado')) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->dropColumn('estado');
            });
        }
    }
};
