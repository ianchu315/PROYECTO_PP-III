<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Auth;
use App\Services\MesaInscripcionService;
use Illuminate\Http\Request;

class MesaPublicaController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        // Datos del panel del superadmin (dos listas: pendientes y activos).
        // Se calculan una sola vez y sirven para los dos returns.
        $mostrarPopupSuperUsuario = false;
        $usuariosPendientes = collect();
        $usuariosActivos = collect();
        if ($usuario && $usuario->rol === 'superadministrador') {
            $mostrarPopupSuperUsuario = true;
            $usuariosPendientes = \App\Models\Usuario::where('estado', 'pendiente')
                ->orderBy('created_at', 'desc')
                ->get();
            $usuariosActivos = \App\Models\Usuario::where('estado', 'aprobado')
                ->whereIn('rol', ['usuario', 'profesor'])
                ->orderBy('apellido')
                ->get();
        }

        $config = Configuracion::where('clave', 'mostrar_mesas')->first();

        if (!$config || !$config->valor) {
            return view('frontend.mesas.index', [
                'mesas' => collect(),
                'mostrar' => false,
                'modo' => 'fecha',
                'mostrarPopupSuperUsuario' => $mostrarPopupSuperUsuario,
                'usuariosPendientes' => $usuariosPendientes,
                'usuariosActivos' => $usuariosActivos,
            ]);
        }

        $modo = $request->get('orden', 'fecha'); // por defecto se ordena por fecha

        $mesasQuery = Mesa::with(['materia', 'profesor', 'carrera', 'vocal', 'resolucion'])
            ->orderBy('fecha');

        // Si hay un usuario logueado con carrera asignada (alumno), mostramos
        // SOLO las mesas de su carrera.
        if ($usuario && !empty($usuario->carrera_id)) {
            $mesasQuery->where('carrera_id', $usuario->carrera_id);
        }

        $mesas = $mesasQuery->get();

        // Si hay usuario autenticado, calcular para cada mesa si puede inscribirse
        $canRegisterMap = [];
        if ($usuario) {
            $service = new MesaInscripcionService();
            $inscripciones = \App\Models\MesaInscripcion::where('usuario_id', $usuario->id)->get();
            foreach ($mesas as $mesa) {
                $canRegisterMap[$mesa->id] = $service->canRegister($usuario, $mesa, $inscripciones);
            }
        }

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
            'canRegisterMap' => $canRegisterMap,
            'usuario' => $usuario,
            'mostrarPopupSuperUsuario' => $mostrarPopupSuperUsuario,
            'usuariosPendientes' => $usuariosPendientes,
            'usuariosActivos' => $usuariosActivos,
        ]);
    }

}