<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experiencia;
use Illuminate\Support\Facades\Auth;
use Flasher\Laravel\Facade\Flasher;

class ExperienciaController extends Controller
{
    public function create()
    {
        return view('crear.crear_experiencias');
    }

    public function store(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        // Validaciones básicas
        $request->validate([
            'puesto'      => 'required|string|max:255',
            'empresa'     => 'required|string|max:255',
            'horario'     => 'nullable|string|max:255',
            'año_inicio'  => 'required|date_format:Y-m',
            'año_fin'     => 'nullable|date_format:Y-m|after:año_inicio',
            'descripcion' => 'nullable|string',
            'logros'      => 'nullable|string',
        ], [
            'required' => 'Este campo es obligatorio',
        ]);

        // Validar que año_inicio y año_fin no sean el mismo mes
        if ($request->filled('año_fin') && $request->input('año_inicio') === $request->input('año_fin')) {
            Flasher::addError('El año de fin no puede ser el mismo mes que el inicio.', 'Error');
            return redirect()->route('perfil', ['seccion' => 'experiencia'])
                             ->withInput();
        }

        // Validar año_inicio > año de nacimiento
        $anioNacimiento = (int) date('Y', strtotime($usuario->fecha_nacimiento));
        $anioInicio = (int) date('Y', strtotime($request->input('año_inicio') . '-01'));

        if ($anioInicio <= $anioNacimiento) {

            Flasher::addError('El año de inicio debe ser mayor al año de nacimiento.', 'Error');
            return redirect()->route('perfil', ['seccion' => 'experiencia'])
                             ->withInput();
        }

        // Crear experiencia
        Experiencia::create([
            'usuario_id'  => $usuario->id,
            'puesto'      => $request->input('puesto'),
            'empresa'     => $request->input('empresa'),
            'horario'     => $request->input('horario'),
            'año_inicio'  => $request->input('año_inicio') . '-01',
            'año_fin'     => $request->filled('año_fin') ? $request->input('año_fin') . '-01' : null,
            'descripcion' => $request->input('descripcion'),
            'logros'      => array_filter(explode("\n", $request->input('logros'))),
        ]);

        
        Flasher::addSuccess('Experiencia laboral agregada correctamente.', 'Exito');
        return redirect()->route('perfil', ['seccion' => 'experiencia']);
    }

    public function update(Request $request, $id)
    {
        $usuario = Auth::guard('usuarios')->user();
        $experiencia = Experiencia::findOrFail($id);

        // Validaciones básicas
        $request->validate([
            'puesto'      => 'required|string|max:255',
            'empresa'     => 'required|string|max:255',
            'horario'     => 'nullable|string|max:255',
            'año_inicio'  => 'required|date_format:Y-m',
            'año_fin'     => 'nullable|date_format:Y-m|after:año_inicio',
            'descripcion' => 'nullable|string',
            'logros'      => 'nullable|string',
        ], [
            'required' => 'Este campo es obligatorio',
        ]);

        // Validar que año_inicio y año_fin no sean el mismo mes
        if ($request->filled('año_fin') && $request->input('año_inicio') === $request->input('año_fin')) {
            Flasher::addError('El año de fin no puede ser el mismo mes que el inicio.', 'Error');
            return redirect()->route('perfil', ['seccion' => 'experiencia', 'editarId' => $id])
                             ->withInput();
        }

        // Validar año_inicio > año de nacimiento
        $anioNacimiento = (int) date('Y', strtotime($usuario->fecha_nacimiento));
        $anioInicio = (int) date('Y', strtotime($request->input('año_inicio') . '-01'));

        if ($anioInicio <= $anioNacimiento) {
            Flasher::addError('El año de inicio debe ser mayor al año de nacimiento.', 'Error');
            return redirect()->route('perfil', ['seccion' => 'experiencia', 'editarId' => $id])
                             ->withInput();
        }

        // Actualizar experiencia
        $experiencia->update([
            'puesto'      => $request->input('puesto'),
            'empresa'     => $request->input('empresa'),
            'horario'     => $request->input('horario'),
            'año_inicio'  => $request->input('año_inicio') . '-01',
            'año_fin'     => $request->filled('año_fin') ? $request->input('año_fin') . '-01' : null,
            'descripcion' => $request->input('descripcion'),
            'logros'      => array_filter(explode("\n", $request->input('logros'))),
        ]);

        Flasher::addSuccess('Experiencia laboral actualizada correctamente.', 'Exito');
        return redirect()->route('perfil', ['seccion' => 'experiencia']);
    }

    public function destroy($id)
    {
        $experiencia = Experiencia::findOrFail($id);
        $experiencia->delete();

        Flasher::addSuccess('Experiencia eliminada correctamente.', 'Exito');
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'experiencia']);
    }
}