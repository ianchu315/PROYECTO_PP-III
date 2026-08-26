<?php

namespace App\Services;

use App\Models\Calificacion;
use App\Models\Correlativa;

class RegularidadService
{
    // Devuelve true si el usuario aprobó la materia
    public function materiaAprobada($usuarioId, $materiaId): bool
    {
        return Calificacion::where('usuario_id', $usuarioId)
            ->where('materia_id', $materiaId)
            ->where('aprobado', true)
            ->exists();
    }

    // Verifica si el usuario cumple todas las correlativas de una materia
    public function cumpleCorrelativas($usuarioId, $materiaId): bool
    {
        $correlativas = Correlativa::where('materia_id', $materiaId)->get();

        foreach ($correlativas as $corr) {
            if (! $this->materiaAprobada($usuarioId, $corr->correlativa_id)) {
                return false;
            }
        }

        return true;
    }

    // Calcula el promedio de notas del usuario con notas registradas
    public function calcularPromedioNotas($usuarioId): float
    {
        $promedio = Calificacion::where('usuario_id', $usuarioId)
            ->whereNotNull('nota')
            ->avg('nota');

        return $promedio !== null ? round($promedio, 2) : 0.0;
    }

    // Devuelve la regularidad según el promedio calculado
    public function calcularRegularidad($usuarioId): string
    {
        return $this->calcularPromedioNotas($usuarioId) >= 4 ? 'REGULAR' : 'NO REGULAR';
    }
}
