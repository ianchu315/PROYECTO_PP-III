<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Calificacion;
use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Mesa;
use Flasher\Laravel\Facade\Flasher;

class CalificacionController extends Controller
{
    private function ensureProfesorAprobado()
    {
        $usuario = Auth::guard('usuarios')->user();
        if (!$usuario || $usuario->rol !== 'profesor' || $usuario->estado !== 'aprobado') {
            abort(403, 'Acceso denegado. Solo profesores aprobados pueden gestionar notas.');
        }

        return $usuario;
    }

    public function index()
    {
        $this->ensureProfesorAprobado();

        $calificaciones = Calificacion::with(['usuario', 'materia', 'mesa'])
            ->orderByDesc('created_at')
            ->get();

        return view('notas.index', compact('calificaciones'));
    }

    public function create()
    {
        $this->ensureProfesorAprobado();

        $alumnos = Usuario::where('rol', 'usuario')
            ->where('estado', 'aprobado')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        $materias = Materia::orderBy('descripcion')->get();
        $mesas = Mesa::with('materia')->orderBy('fecha')->get();

        return view('notas.create', compact('alumnos', 'materias', 'mesas'));
    }

    public function store(Request $request)
    {
        $this->ensureProfesorAprobado();

        $validator = Validator::make($request->all(), [
            'usuario_id' => ['required', 'exists:usuarios,id'],
            'materia_id' => ['required', 'exists:materias,id'],
            'mesa_id' => ['nullable', 'exists:mesas,id'],
            'nota' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'aprobado' => ['required', 'boolean'],
            'fecha' => ['nullable', 'date'],
        ], [
            'usuario_id.required' => 'Debes seleccionar un alumno.',
            'usuario_id.exists' => 'El alumno seleccionado no es válido.',
            'materia_id.required' => 'Debes seleccionar una materia.',
            'materia_id.exists' => 'La materia seleccionada no es válida.',
            'mesa_id.exists' => 'La mesa seleccionada no es válida.',
            'nota.numeric' => 'La nota debe ser un número válido.',
            'nota.min' => 'La nota debe ser al menos 0.',
            'nota.max' => 'La nota no puede ser mayor a 100.',
            'aprobado.required' => 'Debes indicar si la materia fue aprobada.',
            'aprobado.boolean' => 'El valor de aprobado debe ser verdadero o falso.',
            'fecha.date' => 'La fecha debe ser válida.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Calificacion::create([
            'usuario_id' => $request->input('usuario_id'),
            'materia_id' => $request->input('materia_id'),
            'mesa_id' => $request->input('mesa_id'),
            'nota' => $request->input('nota'),
            'aprobado' => $request->boolean('aprobado'),
            'fecha' => $request->input('fecha'),
        ]);

        Flasher::addSuccess('Calificación registrada correctamente.');

        return redirect()->route('bolsadetrabajo.notas.index');
    }

    public function edit($id)
    {
        $this->ensureProfesorAprobado();

        $calificacion = Calificacion::findOrFail($id);
        $alumnos = Usuario::where('rol', 'usuario')
            ->where('estado', 'aprobado')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();
        $materias = Materia::orderBy('descripcion')->get();
        $mesas = Mesa::with('materia')->orderBy('fecha')->get();

        return view('notas.edit', compact('calificacion', 'alumnos', 'materias', 'mesas'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureProfesorAprobado();

        $calificacion = Calificacion::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'usuario_id' => ['required', 'exists:usuarios,id'],
            'materia_id' => ['required', 'exists:materias,id'],
            'mesa_id' => ['nullable', 'exists:mesas,id'],
            'nota' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'aprobado' => ['required', 'boolean'],
            'fecha' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $calificacion->update([
            'usuario_id' => $request->input('usuario_id'),
            'materia_id' => $request->input('materia_id'),
            'mesa_id' => $request->input('mesa_id'),
            'nota' => $request->input('nota'),
            'aprobado' => $request->boolean('aprobado'),
            'fecha' => $request->input('fecha'),
        ]);

        Flasher::addSuccess('Calificación actualizada correctamente.');

        return redirect()->route('bolsadetrabajo.notas.index');
    }

    public function destroy($id)
    {
        $this->ensureProfesorAprobado();

        $calificacion = Calificacion::findOrFail($id);
        $calificacion->delete();

        Flasher::addSuccess('Calificación eliminada correctamente.');
        return redirect()->route('bolsadetrabajo.notas.index');
    }

    public function myGrades()
    {
        $usuario = Auth::guard('usuarios')->user();
        if (!$usuario) {
            abort(403);
        }

        $calificaciones = Calificacion::with(['materia', 'mesa'])
            ->where('usuario_id', $usuario->id)
            ->orderByDesc('created_at')
            ->get();

        return view('notas.mine', compact('calificaciones'));
    }
}
