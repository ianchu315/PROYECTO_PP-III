<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mesa_inscripciones', function (Blueprint $table) {
            if (!Schema::hasColumn('mesa_inscripciones', 'condicion')) {
                $table->string('condicion', 10)->default('libre')->after('fecha_inscripcion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mesa_inscripciones', function (Blueprint $table) {
            if (Schema::hasColumn('mesa_inscripciones', 'condicion')) {
                $table->dropColumn('condicion');
            }
        });
    }
};