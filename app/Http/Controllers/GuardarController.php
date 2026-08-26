<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estado;




// <!-- Muestra las ofertas guardadas activas del usuario, permitiendo buscarlas y ordenarlas por fecha. -->

class GuardarController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user(); 

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus ofertas guardadas.');
        }

        // Trae las ofertas guardadas con la relación
        $usuario->load(['postulaciones', 'ofertasGuardadas']);
        $ofertasGuardadas = $usuario->ofertasGuardadas;

        // Solo ofertas activas
        $ofertasGuardadas = $ofertasGuardadas->filter(fn($oferta) => $oferta->estado_id == 1);

        // Filtro por búsqueda
        $busqueda = $request->input('buscar');
        if (!empty($busqueda)) {
            $ofertasGuardadas = $ofertasGuardadas->filter(fn($oferta) =>
                stripos($oferta->titulo, $busqueda) !== false ||
                stripos($oferta->empresa, $busqueda) !== false
            );
        }

        // Orden
        $orden = $request->input('orden');
        $ofertasGuardadas = $orden === 'antiguas'
            ? $ofertasGuardadas->sortBy('created_at')
            : $ofertasGuardadas->sortByDesc('created_at');

        $estados = Estado::all();

        return view('guardar', compact('ofertasGuardadas', 'usuario', 'orden', 'busqueda', 'estados'));
    }
}
