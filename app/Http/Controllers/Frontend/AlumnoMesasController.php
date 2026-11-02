<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use App\Models\Mesa;
use App\Models\MesaInscripcion;
use App\Services\MesaInscripcionService;
use Illuminate\Support\Facades\Auth;

// Bloque de mesas finales EXCLUSIVO del panel del alumno, para inscribirse.
// No tiene relación con /mesasfront (que ahora es solo informativa, sin
// botones de inscripción ni de inicio de sesión). Reutiliza la misma lógica
// de "puede inscribirse" (MesaInscripcionService) que ya existía.
class AlumnoMesasController extends Controller
{
    public function index()
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(!$usuario, 403, 'Acceso denegado.');

        $config = Configuracion::where('clave', 'mostrar_mesas')->first();
        $mostrar = $config && $config->valor;

        $mesas = collect();
        $canRegisterMap = [];

        if ($mostrar) {
            $mesasQuery = Mesa::with(['materia', 'profesor', 'carrera', 'vocal', 'resolucion'])
                ->orderBy('fecha');

            // El alumno solo ve las mesas de su propia carrera.
            if (!empty($usuario->carrera_id)) {
                $mesasQuery->where('carrera_id', $usuario->carrera_id);
            }

            $mesasPlanas = $mesasQuery->get();

            $service = new MesaInscripcionService();
            $inscripciones = MesaInscripcion::where('usuario_id', $usuario->id)->get();
            foreach ($mesasPlanas as $mesa) {
                $canRegisterMap[$mesa->id] = $service->canRegister($usuario, $mesa, $inscripciones);
            }

            // Ya inscripto en esta mesa puntual (para mostrar el estado, no
            // solo "no disponible" genérico).
            $inscriptoEnMap = $inscripciones->pluck('mesa_id')->flip();

            $mesas = $mesasPlanas
                ->groupBy(fn($mesa) => \Carbon\Carbon::parse($mesa->fecha)->format('Y-m-d'))
                ->map(fn($grupo) => $grupo->sortBy(fn($m) => $m->materia->descripcion ?? ''));
        }

        return view('alumno.mesas.index', [
            'mesas' => $mesas,
            'mostrar' => $mostrar,
            'canRegisterMap' => $canRegisterMap,
            'inscriptoEnMap' => $inscriptoEnMap ?? collect(),
        ]);
    }
}
