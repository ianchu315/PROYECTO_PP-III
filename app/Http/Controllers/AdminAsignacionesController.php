<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Exclusivo para superadministrador: asigna una carrera a cada profesor y,
// dentro de esa carrera, qué materias puntuales le corresponden (como
// titular) y de cuáles es vocal de mesa. Esto es lo que despues usa
// NotasProfesorController para que el profesor vea SOLO sus materias
// asignadas (no todas las de la carrera).
class AdminAsignacionesController extends Controller
{
    private function verificarSuperadmin(): void
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(!$usuario || $usuario->rol !== 'superadministrador', 403, 'Acceso denegado.');
    }

    public function asignarCarrera(Request $request, Usuario $profesor)
    {
        $this->verificarSuperadmin();

        $data = $request->validate([
            'carrera_id' => 'nullable|exists:carreras,id',
        ]);

        $profesor->carrera_id = $data['carrera_id'] ?? null;
        $profesor->save();
        $profesor->carrerasHabilitadas()->sync($profesor->carrera_id ? [$profesor->carrera_id] : []);

        return back()->with('success', "Carrera actualizada para {$profesor->nombre} {$profesor->apellido}.");
    }

    public function asignarCarrerasUsuario(Request $request, Usuario $usuario)
    {
        $this->verificarSuperadmin();
        abort_if(!in_array($usuario->rol, ['profesor', 'usuario'], true), 404);

        $data = $request->validate([
            'carreras' => ['nullable', 'array'],
            'carreras.*' => ['integer', 'distinct', 'exists:carreras,id'],
        ]);

        $carreraIds = array_map('intval', $data['carreras'] ?? []);
        $carreraPrincipal = in_array((int) $usuario->carrera_id, $carreraIds, true)
            ? $usuario->carrera_id
            : ($carreraIds[0] ?? null);

        $carrerasAnteriores = $usuario->carrerasHabilitadas()->pluck('carreras.id');
        $carrerasQuitadas = $carrerasAnteriores->diff($carreraIds);

        if ($usuario->rol === 'profesor' && $carrerasQuitadas->isNotEmpty()) {
            Materia::whereIn('carrera_id', $carrerasQuitadas)
                ->where('profesor_usuario_id', $usuario->id)
                ->update(['profesor_usuario_id' => null]);
            Materia::whereIn('carrera_id', $carrerasQuitadas)
                ->where('vocal_usuario_id', $usuario->id)
                ->update(['vocal_usuario_id' => null]);
        }

        $usuario->carrerasHabilitadas()->sync($carreraIds);
        $usuario->carrera_id = $carreraPrincipal;
        $usuario->save();

        return back()->with('success', "Carreras actualizadas para {$usuario->nombre} {$usuario->apellido}.");
    }

    public function asignarCarrerasPreceptor(Request $request, Usuario $preceptor)
    {
        $this->verificarSuperadmin();
        abort_if($preceptor->rol !== 'preceptor', 404);

        $data = $request->validate([
            'carreras' => ['nullable', 'array'],
            'carreras.*' => ['integer', 'distinct', 'exists:carreras,id'],
        ]);

        $preceptor->carrerasAsignadas()->sync($data['carreras'] ?? []);

        return back()->with('success', "Carreras actualizadas para {$preceptor->nombre} {$preceptor->apellido}.");
    }

    // Guarda, de una sola vez, qué materias (de la carrera del profesor)
    // tiene como titular y de cuáles es vocal. Son dos marcas
    // independientes: puede ser vocal de una materia sin ser su titular.
    public function asignarMaterias(Request $request, Usuario $profesor)
    {
        $this->verificarSuperadmin();

        $data = $request->validate([
            'materias' => 'array',
            'materias.*' => 'integer|exists:materias,id',
            'vocal_materias' => 'array',
            'vocal_materias.*' => 'integer|exists:materias,id',
        ]);

        $titular = $data['materias'] ?? [];
        $vocal = $data['vocal_materias'] ?? [];
        $carreraIds = $profesor->carrerasHabilitadas()->pluck('carreras.id');

        foreach (array_merge($titular, $vocal) as $materiaId) {
            abort_unless(
                Materia::whereIn('carrera_id', $carreraIds)->whereKey($materiaId)->exists(),
                422,
                'Solo puedes asignar materias de las carreras habilitadas al profesor.'
            );
        }

        // Titular: reemplaza las asignaciones dentro de las carreras habilitadas.
        Materia::where('profesor_usuario_id', $profesor->id)
            ->whereIn('carrera_id', $carreraIds)
            ->whereNotIn('id', $titular)
            ->update(['profesor_usuario_id' => null]);

        if (!empty($titular)) {
            Materia::whereIn('id', $titular)
                ->whereIn('carrera_id', $carreraIds)
                ->update(['profesor_usuario_id' => $profesor->id]);
        }

        // Vocal: mismo criterio, columna independiente.
        Materia::where('vocal_usuario_id', $profesor->id)
            ->whereIn('carrera_id', $carreraIds)
            ->whereNotIn('id', $vocal)
            ->update(['vocal_usuario_id' => null]);

        if (!empty($vocal)) {
            Materia::whereIn('id', $vocal)
                ->whereIn('carrera_id', $carreraIds)
                ->update(['vocal_usuario_id' => $profesor->id]);
        }

        return back()->with('success', "Materias actualizadas para {$profesor->nombre} {$profesor->apellido}.");
    }

    // Dar de baja: el usuario deja de poder loguearse, pero no se borra
    // ningún dato (notas, inscripciones, materias asignadas quedan igual).
    public function darDeBaja(Usuario $usuario)
    {
        $this->verificarSuperadmin();

        $usuario->estado = 'inactivo';
        $usuario->save();

        return back()->with('success', "{$usuario->nombre} {$usuario->apellido} fue dado de baja. Ya no puede iniciar sesión, pero sus datos siguen guardados.");
    }

    public function reactivar(Usuario $usuario)
    {
        $this->verificarSuperadmin();

        $usuario->estado = 'aprobado';
        $usuario->save();

        return back()->with('success', "{$usuario->nombre} {$usuario->apellido} fue reactivado.");
    }
}
