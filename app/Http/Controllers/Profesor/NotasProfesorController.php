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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

// Panel exclusivo para profesores: administra qué alumnos cursan cada una de
// sus materias y las notas de cursada (por cuatrimestre + nota extra),
// todo guardado en base de datos (nada en localStorage).
class NotasProfesorController extends Controller
{
    private function profesorActual(): Usuario
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(
            !$usuario || !in_array($usuario->rol, ['profesor', 'administrador', 'superadministrador'], true),
            403,
            'Acceso denegado.'
        );
        return $usuario;
    }

    // Un profesor solo puede operar sobre las materias que el superadmin le
    // asignó puntualmente (profesor_usuario_id). Administrador y
    // superadministrador pueden operar sobre cualquier materia.
    private function materiaDelProfesor(int $materiaId): Materia
    {
        $profesor = $this->profesorActual();

        $query = Materia::where('id', $materiaId);

        if (!in_array($profesor->rol, ['administrador', 'superadministrador'])) {
            $query->where('profesor_usuario_id', $profesor->id);
        }

        return $query->firstOrFail();
    }

    // Cargar o modificar notas es EXCLUSIVO del profesor a cargo de la materia
    // (el que el superadmin dejó asignado en profesor_usuario_id). Administrador
    // y superadministrador pueden ver el panel, pero no cargan notas.
    private function materiaParaCargarNotas(int $materiaId): Materia
    {
        $usuario = Auth::guard('usuarios')->user();

        abort_if(
            !$usuario || $usuario->rol !== 'profesor',
            403,
            'Solo el profesor a cargo de la materia puede cargar notas.'
        );

        return Materia::where('id', $materiaId)
            ->where('profesor_usuario_id', $usuario->id)
            ->firstOrFail();
    }

    public function index()
    {
        $profesor = $this->profesorActual();

        $materiasQuery = Materia::with(['deCarrera', 'deAnio', 'profesorUsuario'])
            ->withCount(['unidades', 'alumnosInscriptos']);

        if (!in_array($profesor->rol, ['administrador', 'superadministrador'])) {
            $materiasQuery->where('profesor_usuario_id', $profesor->id);
        }

        $materias = $materiasQuery
            ->orderBy('carrera_id')
            ->orderBy('descripcion')
            ->get()
            ->map(function ($materia) use ($profesor) {
                $materia->origen = $materia->profesor_usuario_id == $profesor->id
                    ? 'Asignada por el admin'
                    : 'Otra materia';
                return $materia;
            });

        return view('profesor.materias.index', compact('materias'));
    }

    public function show(int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);
        $materia->load(['unidades.recursos']);

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
                'notaPromediada' => $notasAlumno->firstWhere('tipo', 'promediada'),
                'notaExtra'  => $notasAlumno->firstWhere('tipo', 'extra'),
                'condicion'  => $alumno->condicionEnMateria($materia->id),
            ];
        });

        return view('profesor.materias.show', [
            'materia'            => $materia,
            'unidades'           => $materia->unidades,
            'alumnosDisponibles' => $alumnosDisponibles,
            'alumnosData'        => $alumnosData,
        ]);
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
        $materia = $this->materiaParaCargarNotas($materiaId);

        $validator = Validator::make($request->all(), [
            'usuario_id'   => ['required', 'exists:usuarios,id'],
            'cuatrimestre' => ['required', 'integer', 'in:1,2'],
            'numero_nota'  => ['required', 'integer', 'in:1'],
            'nota'         => ['nullable', 'numeric', 'min:0', 'max:10'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
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

    public function guardarNotaPromediada(Request $request, int $materiaId)
    {
        $materia = $this->materiaParaCargarNotas($materiaId);

        $validator = Validator::make($request->all(), [
            'usuario_id' => ['required', 'exists:usuarios,id'],
            'nota'       => ['nullable', 'numeric', 'min:0', 'max:10'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $calificacion = Calificacion::updateOrCreate(
            [
                'usuario_id' => $request->input('usuario_id'),
                'materia_id' => $materia->id,
                'tipo'       => 'promediada',
            ],
            [
                'nota'         => $request->input('nota'),
                'aprobado'     => $request->input('nota') !== null && $request->input('nota') >= 4,
                'cuatrimestre' => null,
                'numero_nota'  => null,
                'fecha'        => now(),
            ]
        );

        return response()->json([
            'ok'      => true,
            'nota_id' => $calificacion->id,
        ]);
    }

    public function guardarNotas(Request $request, int $materiaId)
    {
        $materia = $this->materiaParaCargarNotas($materiaId);

        $validator = Validator::make($request->all(), [
            'notas'                              => ['required', 'array'],
            'notas.*.usuario_id'                 => ['required', 'integer', 'exists:usuarios,id'],
            'notas.*.primer_cuatrimestre'        => ['nullable', 'numeric', 'min:0', 'max:10'],
            'notas.*.segundo_cuatrimestre'       => ['nullable', 'numeric', 'min:0', 'max:10'],
            'notas.*.promediada'                 => ['nullable', 'numeric', 'min:0', 'max:10'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $alumnosInscriptos = $materia->alumnosInscriptos()
            ->pluck('usuarios.id')
            ->map(fn ($id) => (int) $id)
            ->all();
        foreach ($request->input('notas') as $fila) {
            if (!in_array((int) $fila['usuario_id'], $alumnosInscriptos, true)) {
                return response()->json(['error' => 'Uno de los alumnos no pertenece a esta materia.'], 422);
            }
        }

        DB::transaction(function () use ($request, $materia) {
            foreach ($request->input('notas') as $fila) {
                foreach ([1 => 'primer_cuatrimestre', 2 => 'segundo_cuatrimestre'] as $cuatrimestre => $campo) {
                    Calificacion::updateOrCreate(
                        [
                            'usuario_id'   => $fila['usuario_id'],
                            'materia_id'   => $materia->id,
                            'cuatrimestre' => $cuatrimestre,
                            'numero_nota'  => 1,
                            'tipo'         => 'cuatrimestre',
                        ],
                        [
                            'nota'     => $fila[$campo] ?? null,
                            'aprobado' => isset($fila[$campo]) && $fila[$campo] !== null && $fila[$campo] >= 4,
                            'fecha'    => now(),
                        ]
                    );
                }

                Calificacion::updateOrCreate(
                    [
                        'usuario_id' => $fila['usuario_id'],
                        'materia_id' => $materia->id,
                        'tipo'       => 'promediada',
                    ],
                    [
                        'nota'         => $fila['promediada'] ?? null,
                        'aprobado'     => isset($fila['promediada']) && $fila['promediada'] !== null && $fila['promediada'] >= 4,
                        'cuatrimestre' => null,
                        'numero_nota'  => null,
                        'fecha'        => now(),
                    ]
                );
            }
        });

        return response()->json([
            'ok'      => true,
            'mensaje' => '¡Listo! Las notas fueron cargadas correctamente.',
        ]);
    }

    // Guarda/actualiza la nota extra (recuperatorio) de un alumno en la materia.
    public function guardarNotaExtra(Request $request, int $materiaId)
    {
        $materia = $this->materiaParaCargarNotas($materiaId);

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
