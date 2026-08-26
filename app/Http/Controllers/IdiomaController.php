<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idioma;
use Flasher\Laravel\Facade\Flasher;


// <!-- Permite crear, actualizar y eliminar idiomas asociados a un usuario y redirige mostrando mensajes de éxito. -->

class IdiomaController extends Controller
{
    public function create()
    {
        $idiomasDisponibles = \App\Models\IdiomasDisponibles::orderBy('nombre_idioma')->get();
        $niveles = ['Básico', 'Intermedio', 'Avanzado', 'Nativo'];
        return view('crear.crear_idioma', compact('idiomasDisponibles', 'niveles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idioma' => 'required|string|max:255',
            'nivel' => 'required|string|in:Básico,Intermedio,Avanzado,Nativo',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        Idioma::create([
            'idioma' => $request->idioma,
            'nivel' => $request->nivel,
            'usuario_id' => $request->usuario_id,
        ]);

        Flasher::addSuccess('Idioma agregado correctamente.', 'Éxito');

        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'idiomas']);
    }
    public function destroy($id)
    {
        $idioma = Idioma::findOrFail($id);
        $idioma->delete();

        Flasher::addSuccess('Idioma eliminado correctamente.', 'Éxito');

        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'idiomas']);
    }
    public function update(Request $request, $id)
    {
        $idioma = Idioma::findOrFail($id);

        $request->validate([
            'idioma' => 'required|string|max:255',
            'nivel' => 'required|string|max:50',
        ]);

        $idioma->update([
            'idioma' => $request->idioma,
            'nivel' => $request->nivel,
        ]);

        return redirect()->route('bolsadetrabajo.perfil', [
            'seccion' => 'aptitudes',
            'subseccion' => 'idiomas'
        ]);
    }
}
