<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrera;
use App\Models\Anio;
use App\Models\Profesor;
use App\Models\Salon;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\Configuracion;
use Carbon\Carbon;

/**
 * Datos de PRUEBA para testear las inscripciones a mesas.
 *
 * Crea, para la carrera "Análisis de Sistemas":
 *   - un año, dos profesores (presidente y vocal), un salón,
 *   - tres materias,
 *   - cuatro mesas (dos de ellas en la MISMA fecha, para probar la regla
 *     de "una materia por día"),
 *   - y activa la config 'mostrar_mesas' para que las mesas se vean.
 *
 * Correr aparte:
 *   php artisan db:seed --class=DatosPruebaMesasSeeder
 *
 * Es idempotente (firstOrCreate / updateOrCreate): se puede correr varias veces.
 * Solo para desarrollo.
 */
class DatosPruebaMesasSeeder extends Seeder
{
    public function run()
    {
        $carrera = Carrera::where('descripcion', 'Tecnicatura Superior en Análisis de Sistemas')->first()
                 ?? Carrera::first();

        if (!$carrera) {
            $this->command->warn('No hay carreras. Corré primero CarreraSeeder.');
            return;
        }

        // Año (las mesas y materias lo referencian)
        $anio = Anio::firstOrCreate(['anio' => 1], ['descripcion' => '1° Año']);

        // Profesores: presidente y vocal
        $presidente = Profesor::firstOrCreate(['apellido' => 'Pérez', 'nombre' => 'Juan']);
        $vocal      = Profesor::firstOrCreate(['apellido' => 'Gómez', 'nombre' => 'Ana']);

        // Salón
        $salon = Salon::firstOrCreate(
            ['numero_salon' => 'Aula 5'],
            [
                'capacidad'    => 40,
                'carrera_id'   => $carrera->id,
                'anio_id'      => $anio->id,
                'comision_id'  => null,
                'laboratorio'  => false,
            ]
        );

        // Materias de la carrera
        $materias = [];
        foreach (['Programación I', 'Base de Datos', 'Análisis de Sistemas'] as $i => $desc) {
            $materias[] = Materia::firstOrCreate(
                ['descripcion' => $desc, 'carrera_id' => $carrera->id],
                [
                    'anio_id'     => $anio->id,
                    'profesor_id' => $presidente->id,
                    'orden'       => $i + 1,
                ]
            );
        }

        // Mesas: dos en la misma fecha (para probar "una por día") y dos en otras fechas
        $hoy = Carbon::today();
        $mesas = [
            ['materia' => $materias[0], 'fecha' => $hoy->copy()->addDays(10), 'comision' => 'A'],
            ['materia' => $materias[1], 'fecha' => $hoy->copy()->addDays(10), 'comision' => 'A'], // MISMA fecha que la anterior
            ['materia' => $materias[2], 'fecha' => $hoy->copy()->addDays(12), 'comision' => 'A'],
            ['materia' => $materias[0], 'fecha' => $hoy->copy()->addDays(15), 'comision' => 'B'],
        ];

        foreach ($mesas as $m) {
            Mesa::updateOrCreate(
                [
                    'materia_id' => $m['materia']->id,
                    'fecha'      => $m['fecha']->toDateString(),
                    'comision'   => $m['comision'],
                ],
                [
                    'carrera_id'    => $carrera->id,
                    'anio_id'       => $anio->id,
                    'profesor_id'   => $presidente->id,
                    'vocal_id'      => $vocal->id,
                    'horario'       => '18:00:00',
                    'salon_id'      => $salon->id,
                    'inscriptos'    => 0,
                    'resolucion_id' => null,
                ]
            );
        }

        // Activar la visualización de mesas para los alumnos
        Configuracion::updateOrCreate(['clave' => 'mostrar_mesas'], ['valor' => '1']);

        $this->command->info("Datos de prueba listos: 4 mesas para {$carrera->descripcion}, y 'mostrar_mesas' activado.");
    }
}