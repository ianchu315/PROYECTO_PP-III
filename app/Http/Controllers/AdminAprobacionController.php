<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class AdminAprobacionController extends Controller
{
    // Mostrar usuarios pendientes
    public function index()
    {
        $usuarios = Usuario::where('estado', 'pendiente')->orderBy('created_at', 'desc')->get();
        return view('admin_aprobacion.index', compact('usuarios'));
    }

    // Aprobar usuario
    public function approve(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->estado = 'aprobado';
        $usuario->aprobado = true;

    // Rol asignado por el superadmin al aprobar: usuario (alumno) o profesor
        $rol = $request->input('rol');
        if (in_array($rol, ['usuario', 'profesor'], true)) {
        $usuario->rol = $rol;
        }

        

    $usuario->save();
    Flasher::addSuccess('Usuario aprobado.');
    return $this->volverODefault($request);
    }

    // Rechazar usuario
    public function reject(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->estado = 'rechazado';
        $usuario->aprobado = false;
        $usuario->save();

        Flasher::addSuccess('Usuario rechazado.');
        return $this->volverODefault($request);
    }

    // Si el popup mandó de qué página vino (campo "volver"), volvemos ahí.
    // Si no, seguimos yendo al listado normal de aprobación (comportamiento de siempre).
    private function volverODefault(Request $request)
    {
        $volver = $request->input('volver');
        if ($volver && str_starts_with($volver, url('/'))) {
            return redirect($volver);
        }
        return redirect()->route('admin.aprobacion.index');
    }
}
