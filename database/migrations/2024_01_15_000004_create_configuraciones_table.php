<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla "configuraciones": guarda pares clave/valor de configuracion
 * del sistema. La usa, entre otras cosas, la clave 'mostrar_mesas', que decide
 * si las mesas se muestran o no a los alumnos (el "Mostrar Mesas" del manual).
 *
 * Esta migracion FALTABA: el modelo Configuracion y el listado publico de mesas
 * la consultaban, pero nada la creaba.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('configuraciones')) {
            return;
        }

        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->index();
            $table->string('valor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
    }
};