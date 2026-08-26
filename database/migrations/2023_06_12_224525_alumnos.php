<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->integer('dni');
            $table->biginteger('carrera_id')->unsigned()->nullable();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('nacionalidad', 100);
            $table->string('sexo', 100);
            $table->string('cuil', 11);
            $table->string('domicilio', 100);
            $table->string('barrio', 100);
            $table->string('ciudad', 100);
            $table->string('partido', 100);
            $table->string('provincia', 100);
            $table->integer('cod_postal');
            $table->date('fec_nac');
            $table->string('lug_nac', 100);
            $table->string('prov_nac', 100);
            $table->string('email', 255);
            $table->string('est_civil', 50);
            $table->boolean('hijos');
            $table->boolean('fam_a_cargo');
            $table->string('tel_fijo', 15);
            $table->string('celular', 15);
            $table->string('tel_alternativo', 15);
            $table->string('tel_alt_pertenece', 100);
            $table->string('titulo_intermedio', 100);
            $table->date('anio_egreso');
            $table->string('escuela_egreso', 100);
            $table->string('distrito_egreso', 100);
            $table->string('otro_estudio', 100);
            $table->string('otro_estudio_inst', 100);
            $table->date('otro_estudio_egreso');
            $table->string('otro_estudio2', 100);
            $table->string('otro_estudio_inst2', 100);
            $table->date('otro_estudio_egreso2');
            $table->boolean('trabaja');
            $table->string('actividad_trabajo', 100);
            $table->string('horario_trabajo', 100);
            $table->boolean('obra_social');
            $table->string('foto', 255)->nullable();
            $table->string('visado_por', 100);
            $table->boolean('fotoc_dni_ok');
            $table->boolean('fotoc_titulo_ok');
            $table->boolean('certificado_sec_ok');
            $table->boolean('foto_ok');
            $table->boolean('partida_nac_ok');
            $table->timestamps();
            $table->foreign('carrera_id')
                ->references('id')
                ->on('carreras')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
}