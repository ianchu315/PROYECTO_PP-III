<?php

namespace App\Http\Controllers\Preceptor;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\Carrera;
use App\Models\InscripcionMateria;
use App\Models\Materia;
use App\Models\Usuario;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PreceptorController extends Controller
{
    private function preceptorActual(): Usuario
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(
            !$usuario || !in_array($usuario->rol, ['preceptor', 'administrador', 'superadministrador'], true),
            403,
            'Acceso denegado.'
        );

        return $usuario;
    }

    private function carrerasVisibles(Usuario $usuario)
    {
        if ($usuario->rol === 'preceptor') {
            return $usuario->carrerasAsignadas()->orderBy('descripcion')->get();
        }

        return Carrera::orderBy('descripcion')->get();
    }

    private function alumnoGestionable(int $usuarioId): Usuario
    {
        $preceptor = $this->preceptorActual();
        $query = Usuario::where('rol', 'usuario')
            ->where('estado', 'aprobado')
            ->with('carrera');

        if ($preceptor->rol === 'preceptor') {
            $carreraIds = $preceptor->carrerasAsignadas()->pluck('carreras.id');
            $query->where(function ($scope) use ($carreraIds) {
                $scope->whereNull('carrera_id');
                if ($carreraIds->isNotEmpty()) {
                    $scope->orWhereIn('carrera_id', $carreraIds)
                        ->orWhereHas('carrerasHabilitadas', function ($careers) use ($carreraIds) {
                            $careers->whereIn('carreras.id', $carreraIds);
                        });
                }
            });
        }

        return $query->findOrFail($usuarioId);
    }

    public function carreras()
    {
        $preceptor = $this->preceptorActual();
        $conteoAlumnos = [
            'usuarios' => function ($query) {
                $query->where('rol', 'usuario')->where('estado', 'aprobado');
            },
        ];

        $carreras = $preceptor->rol === 'preceptor'
            ? $preceptor->carrerasAsignadas()->withCount($conteoAlumnos)->orderBy('descripcion')->get()
            : Carrera::withCount($conteoAlumnos)->orderBy('descripcion')->get();

        return view('preceptor.carreras', compact('carreras'));
    }

    public function alumnos(Request $request)
    {
        $preceptor = $this->preceptorActual();
        $query = Usuario::where('rol', 'usuario')
            ->where('estado', 'aprobado')
            ->with('carrera');

        if ($preceptor->rol === 'preceptor') {
            $carreraIds = $preceptor->carrerasAsignadas()->pluck('carreras.id');
            $query->where(function ($scope) use ($carreraIds) {
                $scope->whereNull('carrera_id');
                if ($carreraIds->isNotEmpty()) {
                    $scope->orWhereIn('carrera_id', $carreraIds);
                }
            });
        }

        if ($request->filled('carrera_id')) {
            if ($request->input('carrera_id') === 'sin_carrera') {
                $query->whereNull('carrera_id');
            } else {
                $carreraId = $request->input('carrera_id');
                $query->where(function ($scope) use ($carreraId) {
                    $scope->where('carrera_id', $carreraId)
                        ->orWhereHas('carrerasHabilitadas', function ($careers) use ($carreraId) {
                            $careers->where('carreras.id', $carreraId);
                        });
                });
            }
        }

        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function ($scope) use ($busqueda) {
                $scope->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%")
                    ->orWhere('email', 'like', "%{$busqueda}%");
            });
        }

        $alumnos = $query->orderBy('apellido')->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('preceptor.alumnos', [
            'alumnos'   => $alumnos,
            'carreras'  => $this->carrerasVisibles($preceptor),
            'carreraId' => $request->input('carrera_id'),
            'busqueda'  => $request->input('busqueda', ''),
        ]);
    }

    public function show(int $usuarioId)
    {
        $preceptor = $this->preceptorActual();
        $alumno = $this->alumnoGestionable($usuarioId);
        $materiasAsignadas = $alumno->materiasInscripto()->with('deCarrera')->orderBy('descripcion')->get();

        $materiasDisponibles = collect();
        $carreraIdsAlumno = $alumno->carrerasHabilitadas()->pluck('carreras.id');
        if ($alumno->carrera_id) {
            $carreraIdsAlumno->push($alumno->carrera_id);
        }
        $carreraIdsAlumno = $carreraIdsAlumno->unique()->values();

        if ($carreraIdsAlumno->isNotEmpty()) {
            $materiasDisponibles = Materia::whereIn('carrera_id', $carreraIdsAlumno)
                ->whereDoesntHave('alumnosInscriptos', function ($query) use ($alumno) {
                    $query->where('usuarios.id', $alumno->id);
                })
                ->orderBy('descripcion')
                ->get();
        }

        $calificaciones = Calificacion::where('usuario_id', $alumno->id)->get();
        $materiasData = $materiasAsignadas->map(function ($materia) use ($alumno, $calificaciones) {
            $notasMateria = $calificaciones->where('materia_id', $materia->id);

            return [
                'materia'        => $materia,
                'notas'          => $notasMateria->where('tipo', 'cuatrimestre')->sortBy('cuatrimestre')->values(),
                'notaPromediada' => $notasMateria->firstWhere('tipo', 'promediada'),
                'notaExtra'      => $notasMateria->firstWhere('tipo', 'extra'),
                'condicion'      => $alumno->condicionEnMateria($materia->id),
                'asistencia'     => $alumno->porcentajeAsistencia($materia->id),
                'ultimasClases'  => Asistencia::where('usuario_id', $alumno->id)
                    ->where('materia_id', $materia->id)
                    ->orderByDesc('fecha')
                    ->limit(10)
                    ->get(),
            ];
        });

        return view('preceptor.alumnos_show', [
            'alumno'              => $alumno,
            'carreras'            => $this->carrerasVisibles($preceptor),
            'materiasDisponibles' => $materiasDisponibles,
            'materiasData'        => $materiasData,
            'asistenciaGeneral'   => $alumno->porcentajeAsistencia(),
        ]);
    }

    public function asignarCarrera(Request $request, int $usuarioId)
    {
        $preceptor = $this->preceptorActual();
        $alumno = $this->alumnoGestionable($usuarioId);
        $data = $request->validate([
            'carrera_id' => ['required', 'integer', 'exists:carreras,id'],
        ]);

        if ($preceptor->rol === 'preceptor') {
            $asignada = $preceptor->carrerasAsignadas()
                ->where('carreras.id', $data['carrera_id'])
                ->exists();
            abort_unless($asignada, 403, 'No tienes asignada esa carrera.');
        }

        $alumno->carrerasHabilitadas()->syncWithoutDetaching([$data['carrera_id']]);
        $alumno->carrera_id = $data['carrera_id'];
        $alumno->save();

        Flasher::addSuccess('Carrera asignada al alumno.');
        return redirect()->route('bolsadetrabajo.preceptor.alumnos.show', $alumno);
    }

    public function asignarMateria(Request $request, int $usuarioId)
    {
        $alumno = $this->alumnoGestionable($usuarioId);
        $validator = Validator::make($request->all(), [
            'materia_id' => ['required', 'exists:materias,id'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $materia = Materia::findOrFail($request->input('materia_id'));
        $carreraIdsAlumno = $alumno->carrerasHabilitadas()->pluck('carreras.id');
        if ($alumno->carrera_id) {
            $carreraIdsAlumno->push($alumno->carrera_id);
        }
        if (!$carreraIdsAlumno->contains((int) $materia->carrera_id)) {
            Flasher::addError('Esa materia no pertenece a la carrera del alumno.');
            return back();
        }

        InscripcionMateria::firstOrCreate([
            'usuario_id' => $alumno->id,
            'materia_id' => $materia->id,
        ], [
            'fecha_inscripcion' => now(),
        ]);

        Flasher::addSuccess('Materia asignada al alumno.');
        return back();
    }

    public function quitarMateria(int $usuarioId, int $materiaId)
    {
        $alumno = $this->alumnoGestionable($usuarioId);
        $this->materiaDeLaCarreraDelAlumno($alumno, $materiaId);

        InscripcionMateria::where('usuario_id', $alumno->id)->where('materia_id', $materiaId)->delete();
        Calificacion::where('usuario_id', $alumno->id)->where('materia_id', $materiaId)->delete();
        Asistencia::where('usuario_id', $alumno->id)->where('materia_id', $materiaId)->delete();

        Flasher::addSuccess('Materia quitada del alumno.');
        return back();
    }

    // La asistencia ya no la carga el preceptor, solo el profesor a cargo
    // de la materia (ver App\Http\Controllers\Profesor\
    // AsistenciaProfesorController). Acá el preceptor solo la consulta: el
    // % y las últimas clases que arma show() siguen leyendo de la tabla
    // asistencias, así que se ven igual, de solo lectura.

    private function materiaDeLaCarreraDelAlumno(Usuario $alumno, int $materiaId): Materia
    {
        $carreraIdsAlumno = $alumno->carrerasHabilitadas()->pluck('carreras.id');
        if ($alumno->carrera_id) {
            $carreraIdsAlumno->push($alumno->carrera_id);
        }

        return Materia::where('id', $materiaId)
            ->whereIn('carrera_id', $carreraIdsAlumno->unique())
            ->whereHas('alumnosInscriptos', function ($query) use ($alumno) {
                $query->where('usuarios.id', $alumno->id);
            })
            ->firstOrFail();
    }
}
