<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            // 1 o 2. Null cuando tipo = 'extra'.
            $table->unsignedTinyInteger('cuatrimestre')->nullable()->after('materia_id');
            // Posición de la nota dentro del cuatrimestre (1..N, según cantidad_notas_cuatrimestre). Null si es 'extra'.
            $table->unsignedTinyInteger('numero_nota')->nullable()->after('cuatrimestre');
            // 'cuatrimestre' (nota de cursada normal) | 'extra' (recuperatorio del promedio final)
            $table->string('tipo', 20)->default('cuatrimestre')->after('numero_nota');
        });
    }

    public function down(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->dropColumn(['cuatrimestre', 'numero_nota', 'tipo']);
        });
    }
};
