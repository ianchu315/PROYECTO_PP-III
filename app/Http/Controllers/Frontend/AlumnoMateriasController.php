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
        abort_if(!$usuario || $usuario->rol !== 'usuario', 403, 'Acceso denegado.');

        $materias = $usuario->materiasInscripto()
            ->with(['deCarrera', 'deAnio', 'profesorUsuario'])
            ->withCount('unidades')
            ->orderBy('carrera_id')
            ->orderBy('descripcion')
            ->get()
            ->map(function ($materia) use ($usuario) {
                return [
                    'materia'   => $materia,
                    'condicion' => $usuario->condicionEnMateria($materia->id),
                ];
            });

        return view('alumno.materias.index', compact('materias'));
    }

    public function show(int $materiaId)
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(!$usuario || $usuario->rol !== 'usuario', 403, 'Acceso denegado.');

        $materia = $usuario->materiasInscripto()
            ->with(['deCarrera', 'profesorUsuario', 'unidades.recursos'])
            ->where('materias.id', $materiaId)
            ->firstOrFail();

        $calificaciones = $usuario->calificaciones()
            ->where('materia_id', $materia->id)
            ->orderBy('tipo')
            ->orderBy('cuatrimestre')
            ->orderBy('numero_nota')
            ->get();

        return view('alumno.materias.show', [
            'materia' => $materia,
            'unidades' => $materia->unidades,
            'calificaciones' => $calificaciones,
            'condicion' => $usuario->condicionEnMateria($materia->id),
        ]);
    }
}
