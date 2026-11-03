<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('usuarios', 'ultima_conexion')) {
            return;
        }

        Schema::table('usuarios', function (Blueprint $table) {
            // Se actualiza en cada inicio de sesión (InicioSesionController).
            $table->timestamp('ultima_conexion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('ultima_conexion');
        });
    }
};
