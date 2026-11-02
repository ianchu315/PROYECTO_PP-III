<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Agrega, en paralelo a profesor_usuario_id (el profesor "titular" de la
// materia para cargar notas), un vocal_usuario_id: qué cuenta de profesor
// oficia de vocal de mesa para esa materia. Son independientes: alguien
// puede ser vocal de una materia sin ser su titular.
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('materias', 'vocal_usuario_id')) {
            return;
        }

        Schema::table('materias', function (Blueprint $table) {
            $table->unsignedBigInteger('vocal_usuario_id')->nullable()->after('profesor_usuario_id');
            $table->index('vocal_usuario_id');
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropIndex(['vocal_usuario_id']);
            $table->dropColumn('vocal_usuario_id');
        });
    }
};
