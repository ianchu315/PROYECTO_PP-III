<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Mesa, Materia, Horario, Profesor, Carrera, Comision, Resolucion, Salon, Configuracion};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MesaController extends Controller
{
public function asignarSalones()
{
    $asignados = 0;
    $liberados = 0;

    // Procesamos en chunks para no explotar la memoria si hay muchas mesas
    Mesa::with(['salon', 'materia'])->chunkById(100, function ($mesas) use (&$asignados, &$liberados) {
        foreach ($mesas as $mesa) {
            $ins = (int) $mesa->inscriptos;

            // 1) Si no hay inscriptos → liberar salón (igual que pediste)
            if ($ins === 0) {
                if (! is_null($mesa->salon_id)) {
                    // quitamos relación cacheada y guardamos
                    $mesa->salon_id = null;
                    $mesa->setRelation('salon', null);
                    $mesa->save();
                    $liberados++;
                }
                continue;
            }

            // 2) Comprobamos capacidad del salón asignado (si existe)
            $salon = $mesa->relationLoaded('salon') ? $mesa->getRelation('salon') : $mesa->salon()->first();
            $capacidadSalon = is_null($salon) ? null : (int) $salon->capacidad;

            // Si hay salón asignado y es insuficiente → liberarlo Y NO reasignar
            if ($mesa->salon_id && $capacidadSalon !== null && $ins > $capacidadSalon) {
                $mesa->salon_id = null;
                $mesa->setRelation('salon', null); // evita que la misma instancia "vea" el salón
                $mesa->save();
                $liberados++;
                continue; // importante: no pasamos a asignar otro salón aquí
            }

            // 3) Si no tiene salón → intentar asignar (solo si quieres asignar automáticamente)
            if (! $mesa->salon_id) {
                $requiereLab = optional($mesa->materia)->laboratorio ?? false;

                $baseQuery = Salon::where('capacidad', '>=', $ins)
                                  ->where('laboratorio', $requiereLab);

                $salon = (clone $baseQuery)
                            ->where('carrera_id', $mesa->carrera_id)
                            ->orderBy('capacidad')
                            ->first();

                if (! $salon) {
                    $salon = $baseQuery->orderBy('capacidad')->first();
                }

                if ($salon) {
                    $mesa->salon_id = $salon->id;
                    $mesa->setRelation('salon', $salon); // actualizar cache si quieres
                    $mesa->save();
                    $asignados++;
                }
            }
        }
    });

    if ($asignados > 0 || $liberados > 0) {
        return redirect()->back()->with('success', "Se asignaron {$asignados} salones y se liberaron {$liberados} salones.");
    }

    return redirect()->back()->with('info', "No hubo cambios en la asignación de salones.");
}



    public function toggleVisibilidad()
    {
        $config = Configuracion::firstOrCreate(['clave' => 'mostrar_mesas']);
        $config->valor = !$config->valor;
        $config->save();

        return redirect()->route('mesas.index')->with('success', 'Visibilidad de mesas actualizada.');
    }

    public function generarConRango(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);

        if (Mesa::whereBetween('fecha', [$inicio, $fin])->exists()) {
            return redirect()->route('mesas.index')->with('error', 'Ya existen mesas en ese rango.');
        }

        // Validar al menos 2 días hábiles por tipo
        $diasHabiles = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        for ($f = $inicio->copy(); $f->lte($fin); $f->addDay()) {
            $dia = $f->dayOfWeekIso;
            if ($dia <= 5) $diasHabiles[$dia]++;
        }

        foreach ($diasHabiles as $cantidad) {
            if ($cantidad < 2) {
                return redirect()->route('mesas.index')
                    ->with('error', 'El rango debe tener al menos 2 días de cada tipo (lunes a viernes).');
            }
        }

        // Fechas disponibles
        $fechasOcupadas = Mesa::whereBetween('fecha', [$inicio, $fin])
            ->pluck('fecha')
            ->map(fn($f) => Carbon::parse($f)->toDateString())
            ->toArray();

        $fechasDisponibles = [1 => [], 2 => [], 3 => [], 4 => [], 5 => []];
        for ($f = $inicio->copy(); $f->lte($fin); $f->addDay()) {
            $dia = $f->dayOfWeekIso;
            if ($dia <= 5 && !in_array($f->toDateString(), $fechasOcupadas)) {
                $fechasDisponibles[$dia][] = $f->copy();
            }
        }

        $horarios = Horario::with(['materia.deCarrera', 'materia.deProfesor', 'comision'])
            ->get()
            ->groupBy('materia_id');

        $ocupacion = [];
        $noCreadas = [];

        foreach ($horarios as $materiaId => $horariosMateria) {
            $materia = $horariosMateria->first()->materia;

            if (!$materia || !$materia->profesor_id) {
                Log::warning("❌ Materia sin profesor asignado: {$materia->descripcion}");
                $noCreadas[] = $materia->descripcion ?? "ID {$materiaId}";
                continue;
            }

            // Excluir PP o prácticas
            $descripcion = Str::lower($materia->descripcion);
            if (Str::startsWith($descripcion, 'pp') || Str::contains($descripcion, ['práctica', 'practica'])) {
                continue;
            }

            $carreraId = $materia->carrera_id;
            $anioId = $materia->anio_id;

            $comisiones = $horariosMateria->pluck('comision.comision')->unique();
            $aProcesar = [];

            if ($comisiones->contains('A') && $comisiones->contains('B')) {
                $aProcesar = [
                    $horariosMateria->where('comision.comision', 'A')->first(),
                    $horariosMateria->where('comision.comision', 'B')->first()
                ];
            } else {
                $aProcesar[] = $horariosMateria->first();
            }

            foreach ($aProcesar as $horario) {
                if (!$horario || !$horario->dia || !$horario->modulohorario_id) {
                    Log::warning("❌ Horario inválido para materia: {$materia->descripcion}");
                    $noCreadas[] = $materia->descripcion;
                    continue;
                }

                $dia = $horario->dia;
                $comisionLetra = optional($horario->comision)->comision ?? 'A';

                $fechaMesa = null;
                foreach ($fechasDisponibles[$dia] as $fecha) {
                    $fechaStr = $fecha->toDateString();
                    if (!isset($ocupacion[$fechaStr][$carreraId][$anioId][$comisionLetra])) {
                        $ocupacion[$fechaStr][$carreraId][$anioId][$comisionLetra] = true;
                        $fechaMesa = $fecha->copy();
                        break;
                    }
                }

                if (!$fechaMesa) {
                    // 🔄 Fallback más permisivo: asignar la primera fecha disponible del día, aunque esté ocupada
                    if (!empty($fechasDisponibles[$dia])) {
                        $fechaMesa = $fechasDisponibles[$dia][0]->copy();
                        Log::warning("⚠️ Fallback aplicado: se asignó fecha {$fechaMesa->toDateString()} a la materia {$materia->descripcion} aunque ya estaba ocupada.");
                    } else {
                        // Si directamente no hay fechas en ese día, se sigue dejando fuera
                        Log::warning("❌ No se encontró ninguna fecha para materia: {$materia->descripcion}");
                        $noCreadas[] = $materia->descripcion;
                        continue;
                    }
                }

                // Asignar vocal
                $mesaExistente = Mesa::where('fecha', $fechaMesa->toDateString())
                    ->where('profesor_id', $materia->profesor_id)
                    ->first();

                if ($mesaExistente) {
                    $vocalId = $mesaExistente->vocal_id;
                } else {
                    $materiasCompatibles = Horario::where('dia', $dia)
                        ->where('modulohorario_id', '!=', $horario->modulohorario_id)
                        ->pluck('materia_id');

                    $vocal = Materia::whereIn('id', $materiasCompatibles)
                        ->whereNotNull('profesor_id')
                        ->where('profesor_id', '!=', $materia->profesor_id)
                        ->where('categoria_id', $materia->categoria_id)
                        ->inRandomOrder()
                        ->first();

                    if ($vocal) {
                        $vocalId = $vocal->profesor_id;
                    } else {
                        // fallback: usar cualquier presidente de mesa existente en la misma fecha
                        $mesaFallback = Mesa::where('fecha', $fechaMesa->toDateString())
                            ->inRandomOrder()
                            ->first();
                        $vocalId = $mesaFallback->profesor_id ?? $materia->profesor_id;
                    }
                }

                Mesa::create([
                    'materia_id'    => $materia->id,
                    'carrera_id'    => $carreraId,
                    'anio_id'       => $anioId,
                    'profesor_id'   => $materia->profesor_id,
                    'vocal_id'      => $vocalId,
                    'fecha'         => $fechaMesa->toDateString(),
                    'horario'       => '18:00:00',
                    'comision'      => $comisionLetra,
                    'resolucion_id' => $materia->resolucion_id ?? null,
                ]);
            }
        }

        if (!empty($noCreadas)) {
            Log::warning("Materias que NO se pudieron crear: " . implode(', ', $noCreadas));
        }

        return redirect()->route('mesas.index')->with('success', 'Mesas generadas correctamente.');
    }

    public function index(Request $request)
    {
        $query = Mesa::with(['carrera', 'materia', 'profesor', 'vocal'])
            ->orderBy('fecha', 'asc')
            ->orderBy('carrera_id')
            ->orderBy('anio_id');


        foreach (['carrera_id', 'materia_id', 'profesor_id', 'vocal_id', 'fecha', 'horario', 'comision', 'anio_id', 'resolucion_id'] as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, $request->$campo);
            }
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }

        return view('backend.mesa.index', [
            'mesas'     => $query->paginate(25),
            'carreras'  => Carrera::all(),
            'materias'  => Materia::all(),
            'comisiones'=> Comision::all(),
            'profesors' => Profesor::orderBy('nombre')->get(),
            'resoluciones' => Resolucion::all(),
        ]);
    }

    public function store(Request $request)
    {
        $materias = Materia::all();

        foreach ($materias as $materia) {
            $descripcion = Str::lower(trim($materia->descripcion));
            if (Str::startsWith($descripcion, 'pp') || Str::startsWith($descripcion, 'prácticas profesionalizantes')) continue;

            $horario = Horario::where('materia_id', $materia->id)->first();
            if (!$horario || !$horario->dia || !$horario->modulohorario_id) continue;

            $materiasCompatibles = Horario::where('dia', $horario->dia)
                ->where('modulohorario_id', '!=', $horario->modulohorario_id)
                ->pluck('materia_id');

            $vocal = Materia::whereIn('id', $materiasCompatibles)
                ->whereNotNull('profesor_id')
                ->where('profesor_id', '!=', $materia->profesor_id)
                ->when($materia->categoria_id, fn($q) => $q->where('categoria_id', $materia->categoria_id))
                ->inRandomOrder()
                ->first() ?? Materia::whereIn('id', $materiasCompatibles)
                    ->where('profesor_id', '!=', $materia->profesor_id)
                    ->inRandomOrder()
                    ->first();

            if (!$vocal) continue;

            Mesa::create([
                'materia_id'  => $materia->id,
                'carrera_id'  => $materia->carrera_id,
                'anio_id'     => $materia->anio_id,
                'profesor_id' => $materia->profesor_id,
                'vocal_id'    => $vocal->profesor_id,
                'fecha'       => now()->toDateString(),
                'horario'     => '18:00:00',
                'comision'    => optional($horario->comision)->comision ?? 'A',
                'resolucion_id' => $materia->resolucion_id ?? null,
                'salon'       => '101',
            ]);
        }

        return redirect()->route('mesas.index')->with('success', 'Mesas generadas correctamente.');
    }

    public function edit($id)
    {
        return view('backend.mesa.edit', [
            'mesa'      => Mesa::findOrFail($id),
            'materias'  => Materia::all(),
            'profesors' => Profesor::orderBy('apellido')->get(),
            'carreras'  => Carrera::all(),
            'resoluciones' => Resolucion::all(),   
            'salones' => Salon::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'materia_id'     => 'required|exists:materias,id',
            'carrera_id'     => 'required|exists:carreras,id',
            'profesor_id'    => 'required|exists:profesors,id',
            'vocal_id'       => 'required|exists:profesors,id|different:profesor_id',
            'fecha'          => 'required|date',
            'horario'        => 'required',
            'anio_id'        => 'required|integer',
            'comision'       => 'nullable|string|max:10', 
            'inscriptos'     => 'nullable|integer|min:0',
            'resolucion_id'  => 'nullable|exists:resoluciones,id',
            'salon_id'       => 'nullable|exists:salons,id',
        ]);

        Mesa::findOrFail($id)->update($data);

        $filtros = collect($request->all())
            ->only([
                'filtro_carrera_id', 'filtro_anio_id', 'filtro_materia_id',
                'filtro_profesor_id', 'filtro_vocal_id', 'filtro_fecha', 'filtro_comision'
            ])
            ->mapWithKeys(function ($value, $key) {
                return [Str::replaceFirst('filtro_', '', $key) => $value];
            });

        $pagina = $request->input('page', 1);
        return redirect()->route('mesas.index', request()->only('page', 'search'))
                         ->with('success', 'Actualizado correctamente');
    }



    public function eliminarTodas()
    {
        Mesa::truncate();
        return redirect()->route('mesas.index')->with('success', 'Todas las mesas fueron eliminadas correctamente.');
    }

    public function destroy($id)
    {
        Mesa::findOrFail($id)->delete();
        return redirect()->route('mesas.index')->with('deleted', 'Mesa eliminada correctamente');
    }
}