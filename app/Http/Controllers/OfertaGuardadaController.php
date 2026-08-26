<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OfertaGuardada;
use Flasher\Laravel\Facade\Flasher;


// Permite a los usuarios guardar y eliminar ofertas de trabajo, evitando duplicados y asegurando que solo usuarios autenticados realicen estas acciones.


class OfertaGuardadaController extends Controller
{
    public function store(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user(); // ✅ usuario logueado

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para guardar ofertas.');
        }

        $ofertaId = $request->input('oferta_id');

        // Evitar duplicados
        $usuario->ofertasGuardadas()->syncWithoutDetaching([$ofertaId]);

        Flasher::addSuccess('Oferta guardada correctamente', 'Exito');

        return back();
    }

    public function destroy($oferta_id)
    {
        $usuarioId = Auth::guard('usuarios')->id(); // ✅ id usuario logueado

        if (!$usuarioId) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para eliminar ofertas guardadas.');
        }

        OfertaGuardada::where('oferta_id', $oferta_id)
            ->where('usuario_id', $usuarioId)
            ->delete();


        Flasher::addSuccess('Oferta eliminada correctamente', 'Exito');
        return redirect()->back();
    }
}
