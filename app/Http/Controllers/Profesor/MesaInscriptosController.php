<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use App\Models\MesaInscripcion;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

// Panel exclusivo para profesores y superadministradores: permite ver, para
// cada mesa de examen final, qué alumnos se inscribieron y en qué condición
// (libre o regular). No modifica nada del módulo de "Mis materias" (notas).
class MesaInscriptosController extends Controller
{
    private function profesorActual(): Usuario
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(
            !$usuario || !in_array($usuario->rol, ['profesor', 'administrador', 'superadministrador']),
            403,
            'Acceso denegado.'
        );
        return $usuario;
    }

    public function index()
    {
        $profesor = $this->profesorActual();

        $mesasQuery = Mesa::with(['materia', 'carrera'])
            ->withCount('inscripciones')
            ->orderBy('carrera_id')
            ->orderBy('materia_id')
            ->orderBy('fecha');

        // El superadministrador ve todas las mesas. Profesor y administrador
        // ven solo las de su carrera (si tienen una carrera cargada).
        if ($profesor->rol !== 'superadministrador' && !empty($profesor->carrera_id)) {
            $mesasQuery->where('carrera_id', $profesor->carrera_id);
        }

        $mesas = $mesasQuery->get();

        return view('profesor.mesas.index', compact('mesas'));
    }

    public function show(Mesa $mesa)
    {
        $profesor = $this->profesorActual();

        if (
            $profesor->rol !== 'superadministrador'
            && !empty($profesor->carrera_id)
            && $mesa->carrera_id !== $profesor->carrera_id
        ) {
            abort(403, 'Acceso denegado.');
        }

        $mesa->load(['materia', 'carrera']);

        // unique('usuario_id') por si quedó algún registro duplicado histórico.
        $inscriptos = MesaInscripcion::with('usuario')
            ->where('mesa_id', $mesa->id)
            ->get()
            ->unique('usuario_id')
            ->sortBy(fn ($i) => ($i->usuario->apellido ?? '') . ($i->usuario->nombre ?? ''));

        return view('profesor.mesas.show', compact('mesa', 'inscriptos'));
    }
}