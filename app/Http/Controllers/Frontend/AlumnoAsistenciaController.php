<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\CodigoQrAsistencia;
use Illuminate\Support\Facades\Auth;

// Vista de solo lectura para el alumno: el % de asistencia de cada una de
// sus materias y el historial de clases. La carga el profesor a cargo de
// la materia (ver App\Http\Controllers\Profesor\AsistenciaProfesorController);
// acá no hay nada que el alumno pueda editar, el resultado se arma solo a
// partir de lo que el profesor fue cargando.
class AlumnoAsistenciaController extends Controller
{
    public function index()
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(!$usuario || $usuario->rol !== 'usuario', 403, 'Acceso denegado.');

        $materias = $usuario->materiasInscripto()
            ->with(['deCarrera', 'deAnio'])
            ->orderBy('carrera_id')
            ->orderBy('descripcion')
            ->get()
            ->map(function ($materia) use ($usuario) {
                return [
                    'materia'     => $materia,
                    'porcentaje'  => $usuario->porcentajeAsistencia($materia->id),
                    'ultimas'     => Asistencia::where('usuario_id', $usuario->id)
                        ->where('materia_id', $materia->id)
                        ->orderByDesc('fecha')
                        ->limit(10)
                        ->get(),
                ];
            });

        return view('alumno.asistencia.index', [
            'materias'   => $materias,
            'porcentaje' => $usuario->porcentajeAsistencia(),
        ]);
    }

    // Pantalla con la cámara para escanear el QR que proyecta el profesor
    // (solo alumnos). Al leer el código, redirige a escanear($token).
    public function escaner()
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(!$usuario || $usuario->rol !== 'usuario', 403, 'Acceso denegado.');

        return view('alumno.asistencia.escaner');
    }

    // El alumno llega acá al escanear el QR que proyectó el profesor (con la
    // cámara de la app o con la del celular). Validaciones, en orden:
    //  1. Sesión de alumno.   2. El código existe.   3. Sigue vigente y es de
    //  hoy.   4. El alumno está inscripto en la materia.   5. Si ya se
    //  registró con este mismo QR, no se repite.   6. Si el profesor corrigió
    //  su asistencia a mano DESPUÉS de generar el QR, el QR no la pisa.
    // Superadas, se graba el valor del QR (presente = 2 / tardanza = 1) y
    // pisa lo anterior: la última carga es la que vale.
    public function escanear(string $token)
    {
        $usuario = Auth::guard('usuarios')->user();

        if (!$usuario || $usuario->rol !== 'usuario') {
            // Si no está logueado, lo mandamos a loguearse.
            return redirect()->route('bolsadetrabajo.iniciar-sesion')
                ->with('pf_error', 'Iniciá sesión con tu usuario de alumno para registrar tu asistencia.');
        }

        $codigo = CodigoQrAsistencia::where('token', $token)->first();

        if (!$codigo) {
            return $this->resultado(false, 'Ese código no existe o ya no es válido.');
        }

        if (!$codigo->vigente) {
            return $this->resultado(false, 'Este código ya venció. Pedile al profesor uno nuevo.');
        }

        if (!$codigo->fecha->isToday()) {
            return $this->resultado(false, 'Este código no corresponde a la clase de hoy.');
        }

        $inscripto = $usuario->materiasInscripto()->where('materias.id', $codigo->materia_id)->exists();
        if (!$inscripto) {
            return $this->resultado(false, 'No estás inscripto en esta materia.');
        }

        $materia = $codigo->materia;
        $etiqueta = $codigo->tipo === Asistencia::TARDANZA ? 'con tardanza' : 'presente';

        $actual = Asistencia::where('usuario_id', $usuario->id)
            ->where('materia_id', $codigo->materia_id)
            ->whereDate('fecha', $codigo->fecha)
            ->first();

        if ($actual && (int) $actual->codigo_qr_id === (int) $codigo->id) {
            return $this->resultado(true, "Ya habías registrado tu asistencia en {$materia->descripcion} con este código ({$actual->etiqueta_estado}).");
        }

        if ($actual && $actual->codigo_qr_id === null && $actual->updated_at && $actual->updated_at->gt($codigo->created_at)) {
            return $this->resultado(false, 'El profesor modificó tu asistencia después de generar este código, por eso no se cambió. Hablá con él si hay un error.');
        }

        Asistencia::registrar(
            $usuario->id,
            $codigo->materia_id,
            $codigo->fecha->toDateString(),
            (int) $codigo->tipo,
            (int) $codigo->creado_por,
            null,
            $codigo->id
        );

        return $this->resultado(true, "¡Listo, {$usuario->nombre}! Quedaste {$etiqueta} en {$materia->descripcion}.");
    }

    private function resultado(bool $ok, string $mensaje)
    {
        return view('alumno.asistencia.escaneado', ['ok' => $ok, 'mensaje' => $mensaje]);
    }
}
