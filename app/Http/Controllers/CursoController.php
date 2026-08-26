<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use Flasher\Laravel\Facade\Flasher;
use Carbon\Carbon;

// Gestiona la creación, actualización y eliminación de cursos de un usuario validando fechas y datos requeridos, y guarda los cambios en la base de datos.

class CursoController extends Controller
{
    public function create()
    {
        return view('crear.crear_curso');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:150',
            'institucion' => 'required|string|max:150',
            'fecha' => ['required', 'date_format:Y-m', 'before_or_equal:' . now()->format('Y-m')],
            'fecha_fin' => 'nullable|date_format:Y-m|after_or_equal:fecha|before_or_equal:' . now()->format('Y-m'),
            'temas_principales' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre del curso es obligatorio.',
            'institucion.required' => 'El nombre de la institución es obligatorio.',
            'fecha.required' => 'La fecha de inicio es obligatoria.',
            'fecha.before_or_equal' => 'La fecha de inicio no puede ser mayor al mes actual.',
            'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser anterior a la fecha de inicio.',
            'fecha_fin.before_or_equal' => 'La fecha de fin no puede ser mayor al mes actual.',
        ]);

        Curso::create([
            'usuario_id' => $request->usuario_id,
            'nombre' => $request->nombre,
            'institucion' => $request->institucion,
            'fecha' => $request->fecha,
            'fecha_fin' => $request->fecha_fin,
            'temas_principales' => $request->input('temas_principales'),
        ]);

        Flasher::addSuccess('Curso añadido correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'cursos']);
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:150',
            'institucion' => 'required|string|max:150',
            'fecha' => ['required', 'date_format:Y-m', 'before_or_equal:' . now()->format('Y-m')],
            'fecha_fin' => 'nullable|date_format:Y-m|after_or_equal:fecha|before_or_equal:' . now()->format('Y-m'),
            'temas_principales' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre del curso es obligatorio.',
            'institucion.required' => 'El nombre de la institución es obligatorio.',
            'fecha.required' => 'La fecha de inicio es obligatoria.',
            'fecha.before_or_equal' => 'La fecha de inicio no puede ser mayor al mes actual.',
            'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser anterior a la fecha de inicio.',
            'fecha_fin.before_or_equal' => 'La fecha de fin no puede ser mayor al mes actual.',
        ]);

        $curso->update([
            'nombre' => $request->nombre,
            'institucion' => $request->institucion,
            'fecha' => $request->fecha,
            'fecha_fin' => $request->fecha_fin,
            'temas_principales' => $request->input('temas_principales'),
        ]);

        Flasher::addSuccess('Curso actualizado correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'cursos']);
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        Flasher::addSuccess('Curso eliminado correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'cursos']);
    }
}
