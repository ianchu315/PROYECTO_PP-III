<?php

namespace App\Services;

use App\Services\RegularidadService;

class MesaInscripcionService
{
    public function canRegister($usuario, $mesa, $inscripciones): bool
    {
        if (!$usuario || !$mesa) {
            return false;
        }

        // Debe estar aprobado en la plataforma
        if (! ($usuario->aprobado ?? false)) {
            return false;
        }

        // Debe pertenecer a la misma carrera
        if ((int) ($usuario->carrera_id ?? 0) !== (int) ($mesa->carrera_id ?? 0)) {
            return false;
        }

        // Validar fecha
        $fecha = $mesa->fecha ?? null;
        if (!$fecha) {
            return false;
        }

        // ------------------------------------------------------------------
        // NOTA: los siguientes chequeos (regularidad, año y correlativas)
        // quedaron DESACTIVADOS temporalmente para poder testear las
        // inscripciones con las reglas que necesitamos ahora (misma carrera +
        // una por día). Para reactivarlos, descomentar los bloques.
        //
        // Pendiente: la "regularidad" debería rediseñarse como regular/libre
        // POR MATERIA (no como promedio global), y falta crear la tabla
        // 'correlativas'.
        // ------------------------------------------------------------------

        // // Validar regularidad
        // if (($usuario->regularidad ?? '') !== 'REGULAR') {
        //     return false;
        // }

        // Evita duplicados por misma fecha (regla: una materia por día)
        $yaInscripto = $inscripciones->contains(function ($inscripcion) use ($usuario, $fecha) {
            return (int) ($inscripcion->usuario_id ?? 0) === (int) ($usuario->id ?? 0)
                && ($inscripcion->fecha_inscripcion ?? null) === $fecha;
        });
        if ($yaInscripto) return false;

        // // Validar año: usuario.anio_id debe ser >= materia.anio_id
        // $materiaAnio = $mesa->materia->anio_id ?? null;
        // $usuarioAnio = $usuario->anio_id ?? null;
        // if ($materiaAnio !== null && $usuarioAnio !== null) {
        //     if ((int)$materiaAnio > (int)$usuarioAnio) {
        //         return false;
        //     }
        // }

        // // Validar correlativas: todas las correlativas deben estar aprobadas
        // $regularidad = new RegularidadService();
        // if (! $regularidad->cumpleCorrelativas($usuario->id, $mesa->materia_id)) {
        //     return false;
        // }

        return true;
    }
}