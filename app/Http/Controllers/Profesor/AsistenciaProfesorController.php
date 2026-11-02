<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\CodigoQrAsistencia;
use App\Models\Materia;
use App\Models\Usuario;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

// Asistencia: la gestiona únicamente el profesor a cargo de la materia
// (administrador y superadministrador conservan acceso total, igual que en
// NotasProfesorController). El preceptor solo puede consultar el resultado
// desde su propio panel (PreceptorController::show), que lee de la misma
// tabla "asistencias" — por eso el % se actualiza solo en todo el proyecto
// apenas el profesor carga una planilla, sin ningún paso manual extra.
class AsistenciaProfesorController extends Controller
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

    // Mismo criterio que NotasProfesorController::materiaDelProfesor.
    private function materiaDelProfesor(int $materiaId): Materia
    {
        $profesor = $this->profesorActual();

        $query = Materia::where('id', $materiaId);

        if (!in_array($profesor->rol, ['administrador', 'superadministrador'])) {
            $query->where('profesor_usuario_id', $profesor->id);
        }

        return $query->firstOrFail();
    }

    public function index()
    {
        $profesor = $this->profesorActual();

        $materiasQuery = Materia::with(['deCarrera', 'deAnio'])
            ->withCount('alumnosInscriptos');

        if (!in_array($profesor->rol, ['administrador', 'superadministrador'])) {
            $materiasQuery->where('profesor_usuario_id', $profesor->id);
        }

        $materias = $materiasQuery->orderBy('carrera_id')->orderBy('descripcion')->get();

        return view('profesor.asistencia.index', compact('materias'));
    }

    // Planilla diaria: una fecha, todos los alumnos inscriptos en la
    // materia, con el estado que ya tengan cargado para ese día (si lo
    // hay) para poder corregirlo sin perder lo anterior.
    public function planilla(Request $request, int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        try {
            $fecha = Carbon::parse($request->get('fecha', today()))->toDateString();
        } catch (\Throwable $e) {
            $fecha = today()->toDateString();
        }

        $alumnos = $materia->alumnosInscriptos()
            ->where('usuarios.estado', 'aprobado')
            ->orderBy('usuarios.apellido')
            ->orderBy('usuarios.nombre')
            ->get();

        $registros = Asistencia::where('materia_id', $materia->id)
            ->whereDate('fecha', $fecha)
            ->get()
            ->keyBy('usuario_id');

        return view('profesor.asistencia.planilla', [
            'materia'  => $materia,
            'alumnos'  => $alumnos,
            'registros' => $registros,
            'fecha'    => $fecha,
            'etiquetas' => Asistencia::ETIQUETAS,
        ]);
    }

    public function guardarPlanilla(Request $request, int $materiaId)
    {
        $profesor = $this->profesorActual();
        $materia = $this->materiaDelProfesor($materiaId);

        $validator = Validator::make($request->all(), [
            'fecha'                => ['required', 'date', 'before_or_equal:today'],
            'asistencia'           => ['required', 'array'],
            'asistencia.*.estado'  => ['required', 'integer', 'in:' . implode(',', Asistencia::valores())],
            'asistencia.*.previo'  => ['nullable', 'integer', 'in:' . implode(',', Asistencia::valores())],
            'asistencia.*.motivo'  => ['nullable', 'string', 'max:100'],
        ], [
            'fecha.before_or_equal' => 'No se puede cargar asistencia de una fecha futura.',
            'asistencia.*.estado.in' => 'Estado de asistencia inválido.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $inscriptos = $materia->alumnosInscriptos()->pluck('usuarios.id')->map(fn ($i) => (int) $i)->all();

        foreach (array_keys($request->input('asistencia')) as $usuarioId) {
            abort_if(!in_array((int) $usuarioId, $inscriptos, true), 422, 'Uno de los alumnos no está inscripto en esta materia.');
        }

        $fecha = $request->input('fecha');

        // "La última carga pisa a la anterior": lo que el profesor guarda
        // acá reemplaza lo que hubiera (incluido lo que dejó un QR).
        // Excepción para no pisar por accidente con una pantalla vieja: si
        // la fila no fue tocada por el profesor (el estado enviado es igual
        // al que se le mostró al abrir la planilla) y mientras tanto ya hay
        // un registro (por ejemplo, el alumno escaneó un QR), se respeta el
        // registro nuevo en vez de volver a escribirlo.
        $existentes = Asistencia::where('materia_id', $materia->id)
            ->whereDate('fecha', $fecha)
            ->get()
            ->keyBy('usuario_id');

        DB::transaction(function () use ($request, $materia, $profesor, $fecha, $existentes) {
            foreach ($request->input('asistencia') as $usuarioId => $datos) {
                $estado = (int) $datos['estado'];
                $motivo = $estado === Asistencia::AUSENTE ? trim((string) ($datos['motivo'] ?? '')) : '';
                $actual = $existentes->get((int) $usuarioId);

                $sinTocar = isset($datos['previo']) && $datos['previo'] !== '' && (int) $datos['previo'] === $estado;
                if ($actual && $sinTocar && $actual->estado !== $estado) {
                    continue; // cambió por otro lado (QR) y el profesor no lo tocó
                }

                // Sin cambios reales: no se reescribe (así un registro de QR
                // conserva su origen y su hora).
                if ($actual && $actual->estado === $estado && (string) ($actual->motivo_justificacion ?? '') === $motivo) {
                    continue;
                }

                Asistencia::registrar((int) $usuarioId, $materia->id, $fecha, $estado, $profesor->id, $motivo, null);
            }
        });

        Flasher::addSuccess('Asistencia guardada. El porcentaje de cada alumno se actualizó automáticamente.');
        return redirect()->route('bolsadetrabajo.profesor.asistencia.planilla', ['materia' => $materia->id, 'fecha' => $fecha]);
    }

    // % de cada alumno en la materia — se arma solo a partir de la tabla
    // asistencias, no hay ningún cálculo que el profesor tenga que disparar
    // a mano aparte de cargar las planillas diarias.
    public function porcentajes(int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        $alumnos = $materia->alumnosInscriptos()
            ->where('usuarios.estado', 'aprobado')
            ->orderBy('usuarios.apellido')
            ->orderBy('usuarios.nombre')
            ->get()
            ->map(function ($alumno) use ($materia) {
                $alumno->asistencia_materia = $alumno->porcentajeAsistencia($materia->id);
                return $alumno;
            });

        return view('profesor.asistencia.porcentajes', compact('materia', 'alumnos'));
    }

    // Muestra el QR vigente de la materia para hoy (si lo hay) y el
    // formulario para generar uno nuevo.
    public function qr(int $materiaId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        $codigo = CodigoQrAsistencia::where('materia_id', $materia->id)
            ->whereDate('fecha', today())
            ->where('expira_en', '>', now())
            ->latest('id')
            ->first();

        return view('profesor.asistencia.qr', compact('materia', 'codigo'));
    }

    // Genera (o renueva) el QR de la materia para hoy. Los alumnos que ya
    // estaban mirando el QR anterior dejan de poder usarlo apenas vence,
    // así que conviene generarlo recién al empezar la clase.
    public function generarQr(Request $request, int $materiaId)
    {
        $profesor = $this->profesorActual();
        $materia = $this->materiaDelProfesor($materiaId);

        $datos = $request->validate([
            'minutos' => ['nullable', 'integer', 'min:1', 'max:180'],
            'tipo'    => ['required', 'integer', 'in:' . Asistencia::PRESENTE . ',' . Asistencia::TARDANZA],
        ]);
        $minutos = (int) ($datos['minutos'] ?? 15);

        // Un solo QR activo por materia a la vez: al generar uno nuevo se
        // cierran los anteriores (así no queda ningún QR viejo, de otro
        // tipo, que pueda pisar la asistencia por error).
        $codigo = DB::transaction(function () use ($materia, $profesor, $minutos, $datos) {
            CodigoQrAsistencia::where('materia_id', $materia->id)
                ->where('expira_en', '>', now())
                ->update(['expira_en' => now()]);

            return CodigoQrAsistencia::create([
                'materia_id' => $materia->id,
                'fecha'      => today(),
                'token'      => CodigoQrAsistencia::generarToken(),
                'tipo'       => (int) $datos['tipo'],
                'creado_por' => $profesor->id,
                'expira_en'  => now()->addMinutes($minutos),
            ]);
        });

        return redirect()->route('bolsadetrabajo.profesor.asistencia.qr', $materia)
            ->with('pf_success', "QR de {$codigo->etiqueta_tipo} generado, vence a las {$codigo->expira_en->format('H:i')}.");
    }

    // Cerrar el QR antes de que venza solo (por si la clase terminó antes).
    public function cerrarQr(int $materiaId, int $codigoId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        CodigoQrAsistencia::where('id', $codigoId)
            ->where('materia_id', $materia->id)
            ->update(['expira_en' => now()]);

        return redirect()->route('bolsadetrabajo.profesor.asistencia.qr', $materia)
            ->with('pf_success', 'QR cerrado.');
    }

    // A quién marcó presente el QR vigente de hoy, para que el profesor
    // vea en vivo quién se fue escaneando (de solo lectura; cualquier
    // corrección manual se sigue haciendo desde la planilla).
    public function qrEscaneos(int $materiaId, int $codigoId)
    {
        $materia = $this->materiaDelProfesor($materiaId);

        $codigo = CodigoQrAsistencia::where('id', $codigoId)
            ->where('materia_id', $materia->id)
            ->firstOrFail();

        // Solo quienes siguen con el registro que dejó ESTE QR: si el
        // profesor corrigió a alguien después, ya no figura acá.
        $registros = Asistencia::where('codigo_qr_id', $codigo->id)
            ->with('usuario')
            ->get()
            ->sortBy(fn ($r) => ($r->usuario->apellido ?? '') . ($r->usuario->nombre ?? ''));

        return response()->json([
            'vigente'  => $codigo->vigente,
            'tipo'     => $codigo->etiqueta_tipo,
            'cantidad' => $registros->count(),
            'alumnos'  => $registros->map(fn ($r) => ($r->usuario->apellido ?? '') . ', ' . ($r->usuario->nombre ?? ''))->values(),
        ]);
    }
}
