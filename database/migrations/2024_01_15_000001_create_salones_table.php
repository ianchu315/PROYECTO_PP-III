<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salones', function (Blueprint $table) {
            $table->id();
            $table->string('numero_salon', 100);
            $table->integer('capacidad')->default(0);
            $table->bigInteger('carrera_id')->unsigned()->nullable();
            $table->bigInteger('anio_id')->unsigned()->nullable();
            $table->bigInteger('comision_id')->unsigned()->nullable();
            $table->boolean('laboratorio')->default(false);
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('anio_id')->references('id')->on('anios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('comision_id')->references('id')->on('comisions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salones');
    }
};
