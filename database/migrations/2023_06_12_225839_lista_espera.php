<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ListaEspera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_espera', function (Blueprint $table) {
            $table->id();
            $table->biginteger('carrera_id')->unsigned()->nullable();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->integer('dni');
            $table->string('telefono', 15);
            $table->string('tel_alternativo', 15);
            $table->string('email', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_espera');
    }
}
