<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ExperienciaLaboral;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Flasher\Laravel\Facade\Flasher;

// <!-- Gestiona la creación, actualización y eliminación de experiencias laborales del usuario, validando fechas respecto a su nacimiento y asegurando coherencia entre inicio y fin. -->





class ExperienciaLaboralController extends Controller
{
    public function create()
    {
        return view('crear.crear_experiencias');
    }

    public function store(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        $validator = Validator::make($request->all(), [
            'puesto'      => 'required|string|max:255',
            'empresa'     => 'required|string|max:255',
            'horario'     => 'required|string|max:255',
            'año_inicio'  => 'required|date_format:Y-m',
            'año_fin'     => 'nullable|date_format:Y-m',
            'descripcion' => 'nullable|string',
            'logros'      => 'nullable|string',
        ], [
            'required' => 'Este campo es obligatorio',
        ]);

        $validator->after(function ($validator) use ($request, $usuario) {
            try {
                $fechaInicio = Carbon::createFromFormat('Y-m', $request->input('año_inicio'))->startOfMonth();
            } catch (\Exception $e) {
                $validator->errors()->add('año_inicio', 'Fecha de inicio inválida.');
                return;
            }

            if (!$usuario->fecha_nacimiento) {
                $validator->errors()->add('fecha_nacimiento', 'Primero debes registrar tu fecha de nacimiento.');
                return;
            }

            $anioNacimiento = Carbon::parse($usuario->fecha_nacimiento)->startOfYear();

            if ($fechaInicio->lte($anioNacimiento)) {
                $validator->errors()->add('año_inicio', 'El año de inicio debe ser mayor al año de nacimiento.');
            }

            if ($request->filled('año_fin')) {
                try {
                    $fechaFin = Carbon::createFromFormat('Y-m', $request->input('año_fin'))->startOfMonth();
                    if ($fechaFin->lt($fechaInicio)) {
                        $validator->errors()->add('año_fin', 'El año de finalización debe ser igual o posterior al año de inicio.');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('año_fin', 'Fecha de fin inválida.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ExperienciaLaboral::create([
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
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'experiencia']);
    }

    public function update(Request $request, $id)
{
    $usuario = Auth::guard('usuarios')->user();
    $experiencia = ExperienciaLaboral::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'puesto'      => 'required|string|max:255',
        'empresa'     => 'required|string|max:255',
        'horario'     => 'required|string|max:255',
        'año_inicio'  => 'required|date_format:Y-m',
        'año_fin'     => 'nullable|date_format:Y-m',
        'descripcion' => 'nullable|string',
        'logros'      => 'nullable|string',
    ]);

    $validator->after(function ($validator) use ($request, $usuario) {
        try {
            $fechaInicio = Carbon::createFromFormat('Y-m', $request->input('año_inicio'))->startOfMonth();
        } catch (\Exception $e) {
            $validator->errors()->add('año_inicio', 'Fecha de inicio inválida.');
            return;
        }

        // 🔹 Validar contra fecha de nacimiento
        if ($usuario->fecha_nacimiento) {
            $anioNacimiento = Carbon::parse($usuario->fecha_nacimiento)->startOfYear();
            if ($fechaInicio->lte($anioNacimiento)) {
                $validator->errors()->add('año_inicio', 'El año de inicio debe ser mayor al año de nacimiento.');
            }
        }

        // 🔹 ✅ Validar que la fecha de inicio no sea posterior al mes actual
        if ($fechaInicio->gt(Carbon::now()->startOfMonth())) {
            $validator->errors()->add('año_inicio', 'La fecha de inicio no puede ser mayor al mes actual.');
        }

        // 🔹 Validar coherencia con año_fin (si está cargado)
        if ($request->filled('año_fin')) {
            try {
                $fechaFin = Carbon::createFromFormat('Y-m', $request->input('año_fin'))->startOfMonth();

                if ($fechaFin->lt($fechaInicio)) {
                    $validator->errors()->add('año_fin', 'El año de finalización debe ser igual o posterior al año de inicio.');
                }

                // 🔹 También evitar fechas futuras en año_fin
                if ($fechaFin->gt(Carbon::now()->startOfMonth())) {
                    $validator->errors()->add('año_fin', 'La fecha de finalización no puede ser mayor al mes actual.');
                }

            } catch (\Exception $e) {
                $validator->errors()->add('año_fin', 'Fecha de fin inválida.');
            }
        }
    });

    if ($validator->fails()) {
        return redirect()->route('bolsadetrabajo.perfil', [
            'seccion' => 'experiencia',
            'editarId' => $experiencia->id
        ])->withErrors($validator)->withInput();
    }

    $experiencia->update([
        'puesto'      => $request->input('puesto'),
        'empresa'     => $request->input('empresa'),
        'horario'     => $request->input('horario'),
        'año_inicio'  => $request->input('año_inicio') . '-01',
        'año_fin'     => $request->filled('año_fin') ? $request->input('año_fin') . '-01' : null,
        'descripcion' => $request->input('descripcion'),
        'logros'      => array_filter(explode("\n", $request->input('logros'))),
    ]);

    Flasher::addSuccess('Experiencia laboral actualizada correctamente.', 'Éxito');

    return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'experiencia']);
}

}
