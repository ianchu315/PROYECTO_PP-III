<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            if (!Schema::hasColumn('usuarios', 'anio_id')) {
                $table->bigInteger('anio_id')->unsigned()->nullable()->after('carrera_id');
            }
            if (!Schema::hasColumn('usuarios', 'aprobado')) {
                $table->boolean('aprobado')->default(false)->after('anio_id');
            }
        });

        try {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->foreign('anio_id')->references('id')->on('anios')->onDelete('set null')->onUpdate('cascade');
            });
        } catch (\Throwable $e) {
            // La relación (foreign key) ya existía: no hacemos nada más.
        }
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign(['anio_id']);
            $table->dropColumn(['anio_id', 'aprobado']);
        });
    }
};