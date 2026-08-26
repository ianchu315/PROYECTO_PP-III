<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Calificacion;
use App\Models\InscripcionMateria;
use App\Models\Materia;
use App\Models\Usuario;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// Panel exclusivo para profesores: administra qué alumnos cursan cada una de
// sus materias y las notas de cursada (por cuatrimestre + nota extra),
// todo guardado en base de datos (nada en localStorage).
class NotasProfesorController extends Controller
{
    private function profesorActual(): Usuario
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(!$usuario || $usuario->rol !== 'profesor', 403, 'Acceso denegado.');
        return $usuario;
    }

    // Un profesor puede operar sobre una materia si el admin se la asignó
    // puntualmente (profesor_usuario_id) O si la materia pertenece a la
    // carrera con la que el profesor se registró (carrera_id).
    private function materiaDelProfesor(int $materiaId): Materia
    {
        $profesor = $this->profesorActual();

        return Materia::where('id', $materiaId)
            ->where(function ($q) use ($profesor) {
                $q->where('profesor_usuario_id', $profesor->id)
                  ->orWhere('carrera_id', $profesor->carrera_id);
            })
            ->firstOrFail();
    }

    public function index()
    {
        $profesor = $this->profesorActual();

        $materias = Materia::with('deCarrera')
            ->where(function ($q) use ($profesor) {
                $q->where('profesor_usuario_id', $profesor->id)
                  ->orWhere('carrera_id', $profesor->carrera_id);
            })
            ->orderBy('descripcion')
            ->get()
            ->map(function ($materia) use ($profesor) {
                $materia->origen = $materia->profesor_usuario_id == $profesor->id
                    ? 'Asignada por el admin'
                    : 'Por tu carrera';
                return $materia;
            });

        return view('profesor.materias.index', compact('materias'));
    }

    public function show(int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        // Alumnos registrados en el login que todavía no están agregados a esta materia.
        $alumnosDisponibles = Usuario::where('rol', 'usuario')
            ->where('estado', 'aprobado')
            ->whereDoesntHave('materiasInscripto', function ($q) use ($materia) {
                $q->where('materias.id', $materia->id);
            })
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'apellido', 'email']);

        $alumnosInscriptos = $materia->alumnosInscriptos()
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        // Notas ya cargadas para esta materia, indexadas por alumno.
        $calificaciones = Calificacion::where('materia_id', $materia->id)->get();

        $alumnosData = $alumnosInscriptos->map(function ($alumno) use ($materia, $calificaciones) {
            $notasAlumno = $calificaciones->where('usuario_id', $alumno->id);

            return [
                'usuario'    => $alumno,
                'notas'      => $notasAlumno->where('tipo', 'cuatrimestre')->values(),
                'notaExtra'  => $notasAlumno->firstWhere('tipo', 'extra'),
                'condicion'  => $alumno->condicionEnMateria($materia->id),
            ];
        });

        return view('profesor.materias.show', [
            'materia'            => $materia,
            'alumnosDisponibles' => $alumnosDisponibles,
            'alumnosData'        => $alumnosData,
        ]);
    }

    // Define (una única vez) cuántas notas por cuatrimestre va a cargar el profesor.
    public function configurarCantidadNotas(Request $request, int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        if ($materia->notas_configuradas) {
            Flasher::addError('La cantidad de notas por cuatrimestre ya fue definida y no se puede modificar.');
            return back();
        }

        $validator = Validator::make($request->all(), [
            'cantidad_notas_cuatrimestre' => ['required', 'integer', 'min:1', 'max:10'],
        ], [
            'cantidad_notas_cuatrimestre.required' => 'Indicá cuántas notas por cuatrimestre vas a cargar.',
            'cantidad_notas_cuatrimestre.integer'  => 'Tiene que ser un número entero.',
            'cantidad_notas_cuatrimestre.min'      => 'Como mínimo 1 nota por cuatrimestre.',
            'cantidad_notas_cuatrimestre.max'      => 'Como máximo 10 notas por cuatrimestre.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $materia->update([
            'cantidad_notas_cuatrimestre' => $request->integer('cantidad_notas_cuatrimestre'),
            'notas_configuradas'          => true,
        ]);

        Flasher::addSuccess('Cantidad de notas por cuatrimestre configurada.');
        return back();
    }

    public function agregarAlumno(Request $request, int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        $validator = Validator::make($request->all(), [
            'usuario_id' => ['required', 'exists:usuarios,id'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $alumno = Usuario::where('id', $request->input('usuario_id'))
            ->where('rol', 'usuario')
            ->first();

        if (!$alumno) {
            Flasher::addError('El alumno seleccionado no es válido.');
            return back();
        }

        InscripcionMateria::firstOrCreate([
            'usuario_id' => $alumno->id,
            'materia_id' => $materia->id,
        ], [
            'fecha_inscripcion' => now(),
        ]);

        Flasher::addSuccess('Alumno agregado a la materia.');
        return back();
    }

    public function quitarAlumno(int $materiaId, int $usuarioId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        InscripcionMateria::where('materia_id', $materia->id)
            ->where('usuario_id', $usuarioId)
            ->delete();

        // Se eliminan también sus notas cargadas para esta materia.
        Calificacion::where('materia_id', $materia->id)
            ->where('usuario_id', $usuarioId)
            ->delete();

        Flasher::addSuccess('Alumno quitado de la materia.');
        return back();
    }

    // Guarda/actualiza UNA nota de cuatrimestre (AJAX). Devuelve JSON con la
    // condición recalculada para refrescar la fila sin recargar la página.
    public function guardarNota(Request $request, int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        $validator = Validator::make($request->all(), [
            'usuario_id'   => ['required', 'exists:usuarios,id'],
            'cuatrimestre' => ['required', 'integer', 'in:1,2'],
            'numero_nota'  => ['required', 'integer', 'min:1'],
            'nota'         => ['nullable', 'numeric', 'min:0', 'max:10'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        if ($materia->cantidad_notas_cuatrimestre && $request->integer('numero_nota') > $materia->cantidad_notas_cuatrimestre) {
            return response()->json(['error' => 'Ese número de nota excede la cantidad configurada.'], 422);
        }

        $calificacion = Calificacion::updateOrCreate(
            [
                'usuario_id'   => $request->input('usuario_id'),
                'materia_id'   => $materia->id,
                'cuatrimestre' => $request->input('cuatrimestre'),
                'numero_nota'  => $request->input('numero_nota'),
                'tipo'         => 'cuatrimestre',
            ],
            [
                'nota'     => $request->input('nota'),
                'aprobado' => $request->input('nota') !== null && $request->input('nota') >= 4,
                'fecha'    => now(),
            ]
        );

        $alumno = Usuario::findOrFail($request->input('usuario_id'));

        return response()->json([
            'ok'        => true,
            'nota_id'   => $calificacion->id,
            'condicion' => $alumno->condicionEnMateria($materia->id),
        ]);
    }

    // Guarda/actualiza la nota extra (recuperatorio) de un alumno en la materia.
    public function guardarNotaExtra(Request $request, int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        $validator = Validator::make($request->all(), [
            'usuario_id' => ['required', 'exists:usuarios,id'],
            'nota'       => ['nullable', 'numeric', 'min:0', 'max:10'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        Calificacion::updateOrCreate(
            [
                'usuario_id' => $request->input('usuario_id'),
                'materia_id' => $materia->id,
                'tipo'       => 'extra',
            ],
            [
                'nota'         => $request->input('nota'),
                'aprobado'     => $request->input('nota') !== null && $request->input('nota') >= 4,
                'cuatrimestre' => null,
                'numero_nota'  => null,
                'fecha'        => now(),
            ]
        );

        $alumno = Usuario::findOrFail($request->input('usuario_id'));

        return response()->json([
            'ok'        => true,
            'condicion' => $alumno->condicionEnMateria($materia->id),
        ]);
    }
}
