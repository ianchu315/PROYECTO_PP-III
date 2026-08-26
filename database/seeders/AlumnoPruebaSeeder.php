<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Carrera;

/**
 * Crea un alumno de PRUEBA ya aprobado, para testear las inscripciones a mesas
 * sin tener que pasar por el registro + aprobacion del superadmin.
 *
 * Credenciales:  alumno@campus.com  /  Alumno123
 *
 * Correr aparte (no hace falta agregarlo al DatabaseSeeder):
 *   php artisan db:seed --class=AlumnoPruebaSeeder
 *
 * Es idempotente (updateOrCreate por email): se puede correr varias veces.
 * Es solo para desarrollo; no lo uses en produccion.
 */
class AlumnoPruebaSeeder extends Seeder
{
    public function run()
    {
        // Buscamos una carrera para asignarle. Preferimos Analisis de Sistemas;
        // si no esta, tomamos la primera que haya.
        $carrera = Carrera::where('descripcion', 'Tecnicatura Superior en Análisis de Sistemas')->first()
                 ?? Carrera::first();

        if (!$carrera) {
            $this->command->warn('No hay carreras cargadas. Corré primero CarreraSeeder y volvé a intentar.');
            return;
        }

        Usuario::updateOrCreate(
            ['email' => 'alumno@campus.com'],
            [
                'nombre'            => 'Alumno',
                'apellido'          => 'De Prueba',
                'password'          => Hash::make('Alumno123'),
                'rol'               => 'usuario',
                'estado'            => 'aprobado',
                'aprobado'          => true,
                'perfil_completado' => true,
                'carrera_id'        => $carrera->id,
            ]
        );

        $this->command->info("Alumno de prueba listo: alumno@campus.com / Alumno123 (carrera: {$carrera->descripcion})");
    }
}
