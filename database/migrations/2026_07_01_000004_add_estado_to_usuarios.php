<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('usuarios', 'estado')) {
            return;
        }

        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('estado', 20)->default('pendiente')->after('aprobado');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};