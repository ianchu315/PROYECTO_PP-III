<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

// Vista de solo lectura para el alumno: sus materias cursadas, las notas que
// el profesor le cargó por cuatrimestre + nota extra, y la condición
// (libre/regular) resultante -la misma que usa el módulo de mesas finales-.
class AlumnoMateriasController extends Controller
{
    public function index()
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(!$usuario, 403, 'Acceso denegado.');

        $materias = $usuario->materiasInscripto()
            ->with('deCarrera')
            ->orderBy('descripcion')
            ->get()
            ->map(function ($materia) use ($usuario) {
                return [
                    'materia'   => $materia,
                    'notas'     => $usuario->calificaciones()
                        ->where('materia_id', $materia->id)
                        ->where('tipo', 'cuatrimestre')
                        ->orderBy('cuatrimestre')
                        ->orderBy('numero_nota')
                        ->get(),
                    'notaExtra' => $usuario->calificaciones()
                        ->where('materia_id', $materia->id)
                        ->where('tipo', 'extra')
                        ->first(),
                    'condicion' => $usuario->condicionEnMateria($materia->id),
                ];
            });

        return view('alumno.materias.index', compact('materias'));
    }
}
