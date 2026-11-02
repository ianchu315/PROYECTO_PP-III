<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use App\Models\MesaInscripcion;
use App\Services\MesaInscripcionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesaInscripcionController extends Controller
{
    public function confirmar(Request $request, Mesa $mesa)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::guard('usuarios')->user();

        if (!$usuario) {
            return redirect()->route('bolsadetrabajo.iniciar-sesion', ['redirect' => url()->current()])
                ->with('error', 'Debes iniciar sesión para inscribirte.');
        }

        $inscripciones = MesaInscripcion::where('usuario_id', $usuario->id)
            ->where('fecha_inscripcion', $mesa->fecha)
            ->get();

        $service = new MesaInscripcionService();
        if (!$service->canRegister($usuario, $mesa, $inscripciones)) {
            return redirect()->route('bolsadetrabajo.alumno.mesas.index')
                ->with('error', 'No puedes inscribirte a esta mesa: no pertenece a tu carrera o ya tienes una inscripción para esa fecha.');
        }

        // Condición con la que rendiría: regular (promedio >= 4) o libre.
        $condicion = $usuario->condicionEnMateria($mesa->materia_id);

        return view('frontend.mesas.confirmar', compact('mesa', 'condicion'));
    }

    public function store(Request $request, Mesa $mesa)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::guard('usuarios')->user();

        if (!$usuario) {
            return redirect()->route('bolsadetrabajo.iniciar-sesion', ['redirect' => url()->current()])
                ->with('error', 'Debes iniciar sesión para inscribirte.');
        }

        $inscripciones = MesaInscripcion::where('usuario_id', $usuario->id)
            ->where('fecha_inscripcion', $mesa->fecha)
            ->get();

        $service = new MesaInscripcionService();
        if (!$service->canRegister($usuario, $mesa, $inscripciones)) {
            return redirect()->route('bolsadetrabajo.alumno.mesas.index')
                ->with('error', 'No puedes inscribirte a esta mesa: no pertenece a tu carrera o ya tienes una inscripción para esa fecha.');
        }

        $condicionReal = $usuario->condicionEnMateria($mesa->materia_id); // lo que realmente le corresponde
        $condicionElegida = $request->input('condicion', 'libre');

        // Si eligió "regular" pero no le corresponde, se fuerza a libre
        $condicion = ($condicionElegida === 'regular' && $condicionReal === 'regular')
        ? 'regular'
         : 'libre';

        MesaInscripcion::create([
            'usuario_id'        => $usuario->id,
            'mesa_id'           => $mesa->id,
            'fecha_inscripcion' => $mesa->fecha,
            'condicion'         => $condicion,
        ]);

        return redirect()->route('bolsadetrabajo.alumno.mesas.index')
            ->with('success', "Inscripción confirmada correctamente (condición: {$condicion}).");
    }
}