<?php

namespace Tests\Unit;

use App\Services\MesaInscripcionService;
use PHPUnit\Framework\TestCase;

class MesaInscripcionServiceTest extends TestCase
{
    public function test_permite_la_inscripcion_para_la_carrera_del_alumno(): void
    {
        $service = new MesaInscripcionService();
        $usuario = new \stdClass();
        $usuario->carrera_id = 1;

        $mesa = new \stdClass();
        $mesa->carrera_id = 1;
        $mesa->fecha = '2026-07-01';

        $this->assertTrue($service->canRegister($usuario, $mesa, collect()));
    }

    public function test_no_permite_la_inscripcion_para_otra_carrera(): void
    {
        $service = new MesaInscripcionService();
        $usuario = new \stdClass();
        $usuario->carrera_id = 1;

        $mesa = new \stdClass();
        $mesa->carrera_id = 2;
        $mesa->fecha = '2026-07-01';

        $this->assertFalse($service->canRegister($usuario, $mesa, collect()));
    }

    public function test_no_permite_inscribirse_a_mas_de_una_materia_por_dia(): void
    {
        $service = new MesaInscripcionService();
        $usuario = new \stdClass();
        $usuario->id = 10;
        $usuario->carrera_id = 1;

        $mesa = new \stdClass();
        $mesa->id = 99;
        $mesa->carrera_id = 1;
        $mesa->fecha = '2026-07-01';

        $inscripciones = collect([
            (object) ['usuario_id' => 10, 'mesa_id' => 50, 'fecha_inscripcion' => '2026-07-01']
        ]);

        $this->assertFalse($service->canRegister($usuario, $mesa, $inscripciones));
    }
}
