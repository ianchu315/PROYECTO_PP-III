<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Oferta;
use App\Models\OfertaGuardada;

// Muestra la página de inicio de Bolsa de Trabajo con las ofertas activas,
// indica cuáles están guardadas por el usuario logueado y calcula totales
// por modalidad y horario.
class HomeController extends Controller
{
    public function index()
    {
        $usuario = Auth::guard('usuarios')->user();

        $ofertas = Oferta::with('idiomas')
            ->where('estado_id', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        // Si el usuario está logueado, buscar sus guardadas
        $ofertasGuardadasIds = [];
        if ($usuario) {
            $ofertasGuardadasIds = OfertaGuardada::where('usuario_id', $usuario->id)
                ->pluck('oferta_id')
                ->toArray();
        }

        foreach ($ofertas as $oferta) {
            $oferta->guardada = in_array($oferta->id, $ofertasGuardadasIds);
        }

        $remotas = Oferta::where('estado_id', 1)->where('modalidad_id', 2)->count();
        $presenciales = Oferta::where('estado_id', 1)->where('modalidad_id', 1)->count();
        $fullTime = Oferta::where('estado_id', 1)->where('horario_id', 1)->count();
        $partTime = Oferta::where('estado_id', 1)->where('horario_id', 2)->count();

        return view('home', compact(
            'usuario',
            'ofertas',
            'remotas',
            'presenciales',
            'fullTime',
            'partTime'
        ));
    }
}