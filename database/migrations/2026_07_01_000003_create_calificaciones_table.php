<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('calificaciones')) {
            return;
        }

        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('materia_id')->unsigned();
            $table->bigInteger('mesa_id')->unsigned()->nullable();
            $table->decimal('nota', 5, 2)->nullable();
            $table->boolean('aprobado')->default(false);
            $table->date('fecha')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mesa_id')->references('id')->on('mesas')->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};