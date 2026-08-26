<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla "usuarios": es la tabla de cuentas del campus (alumnos,
 * profesores y administrativos). El login de alumnos, la verificacion por
 * superadmin y las inscripciones a mesas dependen de ella.
 *
 * Esta migracion FALTABA: el modelo Usuario, el seeder y varias foreign keys
 * la usaban, pero nada la creaba, por lo que "php artisan migrate" fallaba.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('usuarios')) {
            return;
        }

        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();

            // --- Datos de cuenta / login ---
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // --- Rol y verificacion (alta la aprueba/rechaza un superadmin) ---
            // usuario | profesor | administrador | superadministrador
            $table->string('rol', 30)->default('usuario');
            $table->boolean('aprobado')->default(false);
            $table->string('estado', 20)->default('pendiente'); // pendiente | aprobado | rechazado
            $table->boolean('perfil_completado')->default(false);

            // --- Vinculo academico ---
            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->unsignedBigInteger('anio_id')->nullable();

            // --- Datos de perfil (se completan luego, todos opcionales) ---
            $table->date('fecha_nacimiento')->nullable();
            $table->string('dni')->nullable();
            $table->string('genero')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('ciudad_residencia')->nullable();
            $table->string('pais_residencia')->nullable();
            $table->string('telefono')->nullable();
            $table->string('foto_perfil')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('sitio_web')->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('carrera_id')->references('id')->on('carreras')
                  ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('anio_id')->references('id')->on('anios')
                  ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
