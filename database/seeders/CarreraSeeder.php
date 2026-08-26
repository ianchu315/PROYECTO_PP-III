<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrera;

/**
 * Carga las carreras reales de la ISFT N°38.
 *
 * Usamos updateOrCreate (clave: descripcion) para que se pueda volver a correr
 * el seeder sin duplicar carreras.
 *
 * OJO: revisar y completar antes de la entrega:
 *   - 'anios'      -> puesto en '3' por defecto; ajustar si alguna dura 2 años.
 *   - 'resolucion' -> completar con el número de resolución ministerial real.
 *   - 'texto'      -> completar con la descripción real de cada carrera.
 */
class CarreraSeeder extends Seeder
{
    public function run()
    {
        $carreras = [
            ['Tecnicatura Superior en Logística',                                  'logistica'],
            ['Tecnicatura Superior en Análisis de Sistemas',                       'analisis-de-sistemas'],
            ['Tecnicatura Superior en Administración Contable',                    'administracion-contable'],
            ['Tecnicatura Superior en Administración de Recursos Humanos',         'administracion-recursos-humanos'],
            ['Tecnicatura Superior en Gestión Ambiental y Salud',                  'gestion-ambiental-y-salud'],
            ['Tecnicatura Superior en Higiene y Seguridad en el Trabajo',          'higiene-y-seguridad'],
            ['Tecnicatura Superior en Mantenimiento Industrial',                   'mantenimiento-industrial'],
            ['Tecnicatura Superior en Internet de las Cosas y Sistemas Embebidos', 'iot-sistemas-embebidos'],
            ['Tecnicatura Superior en Mecatrónica',                                'mecatronica'],
        ];

        foreach ($carreras as [$descripcion, $carpeta]) {
            Carrera::updateOrCreate(
                ['descripcion' => $descripcion],
                [
                    'anios'          => '3',          // <-- ajustar si corresponde
                    'resolucion'     => 'COMPLETAR',  // <-- completar con la resolución real
                    'texto'          => 'COMPLETAR',  // <-- completar con la descripción real
                    'imagen'         => 'default.jpg',
                    'nombre_carpeta' => $carpeta,
                ]
            );
        }
    }
}