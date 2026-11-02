<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use App\Models\Configuracion;
use Illuminate\Http\Request;

// Mesasfront es puramente informativa: muestra fecha, materia, presidente,
// vocal y salón de cada mesa. No filtra por usuario ni ofrece inscripción
// (eso ahora vive en el panel del alumno, ver AlumnoMesasController).
class MesaPublicaController extends Controller
{
    public function index(Request $request)
    {
        $config = Configuracion::where('clave', 'mostrar_mesas')->first();

        if (!$config || !$config->valor) {
            return view('frontend.mesas.index', [
                'mesas' => collect(),
                'mostrar' => false,
                'modo' => 'fecha',
            ]);
        }

        $modo = $request->get('orden', 'fecha'); // por defecto se ordena por fecha

        $mesas = Mesa::with(['materia', 'profesor', 'carrera', 'vocal', 'resolucion'])
            ->orderBy('fecha')
            ->get();

        // inicializo la variable que la vista espera
        $mesasOrdenadas = collect();

        if ($modo === 'carrera') {
            // Nivel 1: Carrera -> Nivel 2: Comision -> Nivel 3: Año -> Lista de mesas ordenadas por fecha
            $mesasOrdenadas = $mesas
                ->groupBy(fn($mesa) => $mesa->carrera->descripcion)  // Nivel 1: Carrera
                ->map(function ($mesasPorCarrera) {
                    return $mesasPorCarrera
                        ->groupBy(fn($mesa) => $mesa->comision ?? 'Sin Comisión') // Nivel 2: Comisión
                        ->map(function ($mesasPorComision) {
                            return $mesasPorComision
                                ->groupBy(fn($mesa) => $mesa->materia->anio_id ?? 'Sin Año') // Nivel 3: Año
                                ->map(function ($mesasPorAnio) {
                                    return $mesasPorAnio->sortBy('fecha');
                                })
                                ->sortKeysUsing(function ($keyA, $keyB) {
                                    if ($keyA === 'Sin Año' && $keyB !== 'Sin Año') return 1;
                                    if ($keyB === 'Sin Año' && $keyA !== 'Sin Año') return -1;
                                    return (int) $keyA <=> (int) $keyB;
                                });
                        });
                });
        } else {
            // Modo por fecha: agrupa primero por fecha y dentro ordena por carrera y año
            $mesasAgrupadas = $mesas->groupBy(fn($mesa) => \Carbon\Carbon::parse($mesa->fecha)->format('Y-m-d'));
            $mesasOrdenadas = $mesasAgrupadas->map(function ($mesasPorFecha) {
                return $mesasPorFecha->sortBy([
                    fn($a, $b) => $a->carrera->id <=> $b->carrera->id,
                    fn($a, $b) => ($a->materia->anio_id ?? 0) <=> ($b->materia->anio_id ?? 0),
                ]);
            });
        }

        return view('frontend.mesas.index', [
            'mesas' => $mesasOrdenadas,
            'mostrar' => true,
            'modo' => $modo,
        ]);
    }

}