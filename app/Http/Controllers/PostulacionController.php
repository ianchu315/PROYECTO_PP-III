<?php

namespace App\Http\Controllers;

use App\Models\Postulacion;
use App\Models\Oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flasher\Laravel\Facade\Flasher;

//Gestiona la creación, almacenamiento y cancelación de postulaciones de usuarios a ofertas, verificando sesión, duplicados y permisos. 


class PostulacionController extends Controller
{
    public function create()
    {
        $ofertas = Oferta::all();
        return view('crear.crear_postulaciones', compact('ofertas'));
    }

    public function store(Request $request)
    {
        $usuarioId = Auth::guard('usuarios')->id();

        if (!$usuarioId) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para postularte.');
        }

        $existe = Postulacion::where('usuario_id', $usuarioId)
            ->where('oferta_id', $request->oferta_id)
            ->where('estado_postulacion', 'En proceso')
            ->first();

        if ($existe) {
            return redirect()->back()->with('error', 'Ya te postulaste a esta oferta.');
        }

        Postulacion::create([
            'usuario_id' => $usuarioId,
            'oferta_id' => $request->oferta_id,
            'estado_postulacion' => 'En proceso',
            'fecha_postulacion' => now(),
            'fecha_contratacion' => null,
        ]);

        Flasher::addSuccess('¡Postulación realizada exitosamente!', 'Exito');

        return redirect()->back();
    }

    public function cancelar($id)
    {
        $postulacion = Postulacion::findOrFail($id);

        // Verifica que el usuario autenticado con el guard 'usuarios' sea el dueño de la postulación
        if ($postulacion->usuario_id !== Auth::guard('usuarios')->id()) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar esta postulación.');
        }

        $postulacion->delete(); // 👈 elimina físicamente el registro

        Flasher::addSuccess('Postulación eliminada correctamente', 'Éxito');

        return redirect()->back();
    }
}
