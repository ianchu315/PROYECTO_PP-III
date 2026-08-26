<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudio;
use Flasher\Laravel\Facade\Flasher;
use Carbon\Carbon;

class EstudioController extends Controller
{
    public function create()
    {
        return view('crear.crear_estudio');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        // Convertir los campos type="month" a formato completo YYYY-MM-01
        if (!empty($input['fecha_inicio'])) {
            $input['fecha_inicio'] .= '-01';
        }
        if (!empty($input['fecha_fin'])) {
            $input['fecha_fin'] .= '-01';
        }

        // Base de validaciones
        $reglas = [
            'usuario_id' => 'required|exists:usuarios,id',
            'institucion' => 'required|string|max:150',
            'titulo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:cursando,recibido',
        ];
        $mensajes = [
            'required' => 'Este campo es obligatorio.',
            'string' => 'El valor debe ser texto.',
            'max' => 'El campo no puede superar los :max caracteres.',
            'date' => 'Debe ingresar una fecha válida.',
            'after_or_equal' => 'La fecha de finalización no puede ser anterior a la de inicio.',
            'in' => 'Seleccione una opción válida.',
            'exists' => 'El usuario seleccionado no existe.',
        ];
        $request->validate($reglas, $mensajes);


        // Validaciones condicionales
        if ($request->estado === 'cursando') {
            $reglas['materias_aprobadas'] = 'required|integer|min:0';
            $reglas['materias_totales'] = 'required|integer|min:1|gte:materias_aprobadas';
            $reglas['promedio_final'] = 'nullable';
        } elseif ($request->estado === 'recibido') {
            $reglas['materias_aprobadas'] = 'nullable';
            $reglas['materias_totales'] = 'nullable';
            $reglas['promedio_final'] = 'required|numeric|min:0|max:10';
        }

        $validator = \Validator::make($input, $reglas);

        // Validaciones adicionales para fechas
        $validator->after(function ($validator) use ($input) {
            try {
                $fechaInicio = \Carbon\Carbon::parse($input['fecha_inicio'])->startOfMonth();
                $mesActual = \Carbon\Carbon::now()->startOfMonth();

                if ($fechaInicio->gt($mesActual)) {
                    $validator->errors()->add('fecha_inicio', 'La fecha de inicio no puede ser mayor al mes actual.');
                }

                if (!empty($input['fecha_fin'])) {
                    $fechaFin = \Carbon\Carbon::parse($input['fecha_fin'])->startOfMonth();
                    if ($fechaFin->lt($fechaInicio)) {
                        $validator->errors()->add('fecha_fin', 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.');
                    }
                    if ($fechaFin->gt($mesActual)) {
                        $validator->errors()->add('fecha_fin', 'La fecha de finalización no puede ser mayor al mes actual.');
                    }
                }
            } catch (\Exception $e) {
                $validator->errors()->add('fecha_inicio', 'Formato de fecha inválido.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ajustar valores según estado
        if ($request->estado === 'cursando') {
            $input['promedio_final'] = null;
            $input['fecha_fin'] = null;
        } elseif ($request->estado === 'recibido') {
            $input['materias_totales'] = null;
            // $input['materias_aprobadas'] = null;
        }

        Estudio::create([
            'usuario_id' => $input['usuario_id'],
            'institucion' => $input['institucion'],
            'titulo' => $input['titulo'],
            'descripcion' => $input['descripcion'],
            'fecha_inicio' => $input['fecha_inicio'],
            'fecha_fin' => $input['fecha_fin'] ?? null,
            'estado' => $input['estado'],
            'materias_aprobadas' => $input['materias_aprobadas'] ?? null,
            'materias_totales' => $input['materias_totales'] ?? null,
            'promedio_final' => $input['promedio_final'] ?? null,
        ]);

        Flasher::addSuccess('Educación añadida correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'educacion']);
    }


    public function update(Request $request, $id)
    {
        $estudio = Estudio::findOrFail($id);
        $input = $request->all();

        if (!empty($input['fecha_inicio'])) {
            $input['fecha_inicio'] .= '-01';
        }
        if (!empty($input['fecha_fin'])) {
            $input['fecha_fin'] .= '-01';
        }

        $validator = validator($input, [
            'institucion' => 'required|string|max:150',
            'titulo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:cursando,recibido',
            'materias_aprobadas' => 'required|integer|min:0',
            'materias_totales' => 'nullable|integer|min:0',

        ], [
            'required' => 'Este campo es obligatorio',
        ]);


        // 🔹 Validación adicional para fechas futuras
        $validator->after(function ($validator) use ($input) {
            $hoy = Carbon::now()->startOfMonth();

            if (!empty($input['fecha_inicio'])) {
                $fechaInicio = Carbon::parse($input['fecha_inicio'])->startOfMonth();
                if ($fechaInicio->gt($hoy)) {
                    $validator->errors()->add('fecha_inicio', 'La fecha de inicio no puede ser mayor al mes actual.');
                }
            }

            if (!empty($input['fecha_fin'])) {
                $fechaFin = Carbon::parse($input['fecha_fin'])->startOfMonth();
                if ($fechaFin->gt($hoy)) {
                    $validator->errors()->add('fecha_fin', 'La fecha de finalización no puede ser mayor al mes actual.');
                }
            }
        });

        $validator->validate();

        // Ajustar campos según estado
        if ($input['estado'] === 'cursando') {
            $input['promedio_final'] = null;
            $input['fecha_fin'] = null;
            $input['materias_totales'] = $input['materias_totales'] ?? 0;
        } elseif ($input['estado'] === 'recibido') {
            $input['materias_totales'] = null;
            $input['promedio_final'] = $input['promedio_final'] ?? 0;
        }

        $estudio->update($input);

        Flasher::addSuccess('Educación actualizada correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'educacion']);
    }

    public function destroy($id)
    {
        $estudio = Estudio::findOrFail($id);
        $estudio->delete();

        Flasher::addSuccess('Educación eliminada correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'educacion']);
    }
}
