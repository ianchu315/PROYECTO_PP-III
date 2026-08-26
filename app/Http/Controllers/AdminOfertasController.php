<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Carrera;
use App\Models\Time;
use App\Models\Modalidad;
use App\Models\Salario;
use App\Models\Estado;
use App\Models\HabilidadesBlandas;
use App\Models\RequisitoOferta;
use Illuminate\Support\Facades\Storage;
use App\Models\Postulacion;
use App\Models\Usuario;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Flasher\Laravel\Facade\Flasher;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\AñoAcademico;
use App\Models\DisponibilidadHoraria;
use App\Models\IdiomasDisponibles;
use App\Models\PalabraClave;
use App\Models\Idioma;
use Illuminate\Support\Facades\Auth;
use App\Models\OfertaGuardada;
use Illuminate\Support\Facades\Schema;
use App\Models\Aptitud;
use ZipArchive;
use App\Exports\PostulacionesExport;



//Controlador que permite listar, filtrar, crear, editar, actualizar y eliminar ofertas de trabajo, gestionar sus requisitos, beneficios, palabras clave, preguntas, habilidades e idiomas, y exportar postulaciones seleccionadas a Excel.




class AdminOfertasController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');
        $estado = $request->input('estado');
        $orden = $request->input('orden');
        $fecha = $request->input('fecha');
        $carreras = Carrera::all();
        $query = Oferta::with('estado')->newQuery();


        $estadoExpirada = Estado::firstOrCreate(['tipo' => 'Expirada']);

        // Actualizar todas las ofertas cuya fecha de expiración pasó y cuyo estado no es 'Expirada'
        Oferta::whereDate('fecha_expiracion', '<', now())
            ->where('estado_id', '!=', $estadoExpirada->id)
            ->update(['estado_id' => $estadoExpirada->id]);
        // Filtro por búsqueda
        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', "%{$busqueda}%")
                    ->orWhere('empresa', 'like', "%{$busqueda}%");
            });
        }

        // Filtro por estado
        if ($estado) {
            $query->whereHas('estado', function ($q) use ($estado) {
                $q->where('tipo', $estado);
            });
        }

        // Filtro por fecha si existe
        if ($fecha) {
            $query->whereDate('created_at', $fecha);
        }

        // Orden
        $query->orderBy('created_at', $orden === 'antiguas' ? 'asc' : 'desc');

        $ofertas = $query->get();
        $carreras = Carrera::all();
        $horarios = Time::all();
        $modalidades = Modalidad::all();
        $estados = Estado::all();

        return view('admin_ofertas', compact(
            'ofertas',
            'estado',
            'orden',
            'busqueda',
            'fecha',
            'carreras',
            'horarios',
            'modalidades',
            'estados'
        ));
    }




    public function edit($id)
    {
        $oferta = Oferta::with([
            'carrera',
            'horario',
            'modalidad',
            'estado',
            'requisitos',
            'habilidadesBlandas',
            'beneficios',
            'palabrasClave',
            'preguntas'
        ])->findOrFail($id);

        $carreras = Carrera::all();
        $horarios = Time::all();
        $modalidades = Modalidad::all();
        $estados = Estado::all();
        $habilidadesBlandas = HabilidadesBlandas::all();
        $habilidadesSeleccionadas = $oferta->habilidadesBlandas->pluck('id')->toArray();

        $oferta = Oferta::with('idiomas')->findOrFail($id);
        $idiomasDisponibles = \App\Models\IdiomasDisponibles::all();
        $idiomasSeleccionados = $oferta->idiomas->pluck('id')->toArray();

        return view('admin.ofertas.edit', compact('oferta', 'carreras', 'horarios', 'modalidades', 'estados', 'habilidadesBlandas', 'habilidadesSeleccionadas', 'idiomasDisponibles', 'idiomasSeleccionados'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'años_experiencia' => 'required|integer|min:0',
            'salario' => 'nullable|numeric|min:0',
            'fecha_expiracion' => 'required|date|after:today',
            'carrera_id' => 'required|exists:carreras,id',
            'horario_id' => 'required|exists:times,id',
            'modalidad_id' => 'required|exists:modalidades,id',
            'estado_id' => 'required|exists:estados,id',
            'nueva_imagen' => 'nullable|image|max:5120', // 5MB máx

        ], [
            'required' => 'Este campo es obligatorio',
        ]);

        $oferta = Oferta::findOrFail($id);

        $oferta->titulo = $request->input('titulo');
        $oferta->empresa = $request->input('empresa');
        $oferta->ubicacion = $request->input('ubicacion');
        $oferta->descripcion = $request->input('descripcion');
        $oferta->años_experiencia = $request->input('años_experiencia');
        $oferta->salario = str_replace('.', '', $request->input('salario'));
        $oferta->fecha_expiracion = $request->input('fecha_expiracion');
        $oferta->carrera_id = $request->input('carrera_id');
        $oferta->horario_id = $request->input('horario_id');
        $oferta->modalidad_id = $request->input('modalidad_id');
        $oferta->estado_id = $request->input('estado_id');
        $oferta->habilidadesBlandas()->sync($request->input('habilidades_blandas', []));

        if ($request->hasFile('nueva_imagen')) {
            $imagen = $request->file('nueva_imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/ofertas', $nombreImagen);


            if ($oferta->imagen) {
                Storage::delete('public/ofertas/' . $oferta->imagen);
            }

            $oferta->imagen = $nombreImagen;
        }


        $oferta->idiomas()->sync($request->input('idiomas', []));



        $oferta->save();



        foreach ($request->input('requisitos', []) as $id => $texto) {
            \App\Models\RequisitoOferta::where('id', $id)->update(['requisito' => $texto]);
        }


        foreach ($request->input('beneficios', []) as $id => $texto) {
            \App\Models\BeneficioOferta::where('id', $id)->update(['beneficio' => $texto]);
        }




        foreach ($request->input('palabras', []) as $id => $texto) {
            \App\Models\PalabraClave::where('id', $id)->update(['palabra' => $texto]);
        }

        foreach ($request->input('preguntas', []) as $id => $texto) {
            \App\Models\PreguntaOferta::where('id', $id)->update(['pregunta' => $texto]);
        }

        if ($request->filled('requisitos_nuevos')) {
            foreach ($request->input('requisitos_nuevos') as $nuevoRequisito) {
                \App\Models\RequisitoOferta::create([
                    'oferta_id' => $oferta->id,
                    'requisito' => $nuevoRequisito,
                ]);
            }
        }


        if ($request->has('beneficios_nuevos')) {
            foreach ($request->input('beneficios_nuevos') as $nuevoBeneficio) {
                if (!empty(trim($nuevoBeneficio))) {
                    \App\Models\BeneficioOferta::create([
                        'oferta_id' => $oferta->id,
                        'beneficio' => $nuevoBeneficio,
                    ]);
                }
            }
        }


        if ($request->has('palabras_nuevas')) {
            foreach ($request->palabras_nuevas as $palabra) {
                if (!empty($palabra)) {
                    \App\Models\PalabraClave::create([
                        'oferta_id' => $oferta->id,
                        'palabra' => $palabra,
                    ]);
                }
            }
        }

        if ($request->has('preguntas_nuevas')) {
            foreach ($request->preguntas_nuevas as $pregunta) {
                if (!empty($pregunta)) {
                    \App\Models\PreguntaOferta::create([
                        'oferta_id' => $oferta->id,
                        'pregunta' => $pregunta,
                    ]);
                }
            }
        }

        Flasher::addSuccess('Oferta actualizada correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.ofertas');
    }


    public function destroyRequisito($id)
    {
        $requisito = \App\Models\RequisitoOferta::find($id);

        if ($requisito) {
            $requisito->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


    public function destroyBeneficio($id)
    {
        \App\Models\BeneficioOferta::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function destroyPalabra($id)
    {
        \App\Models\PalabraClave::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function destroyPregunta($id)
    {
        \App\Models\PreguntaOferta::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }










    public function crear()
    {
        $carreras = \App\Models\Carrera::all();
        $horarios = \App\Models\Time::all();
        $modalidades = \App\Models\Modalidad::all();
        $estados = \App\Models\Estado::all();
        $habilidadesBlandas = \App\Models\HabilidadesBlandas::all();
        $idiomasDisponibles = \App\Models\IdiomasDisponibles::all();
        $habilidadesSeleccionadas = [];
        $idiomasSeleccionados = [];

        // Los errores de validación se mostrarán automáticamente en la vista usando @error en los campos del formulario.



        return view('admin.ofertas.crear', compact('carreras', 'horarios', 'modalidades', 'estados', 'habilidadesBlandas', 'habilidadesSeleccionadas', 'idiomasDisponibles', 'idiomasSeleccionados'));
    }

    public function guardar(Request $request)
    {

        $request->validate([
            'titulo' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'años_experiencia' => 'required|numeric|min:0',
            'salario' => 'required|string',
            'fecha_expiracion' => 'required|date',
            'carrera_id' => 'required|exists:carreras,id',
            'horario_id' => 'required|exists:times,id',
            'modalidad_id' => 'nullable|exists:modalidades,id',
            'estado_id' => 'nullable|exists:estados,id',
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:2048',

        ], [
            'required' => 'Este campo es obligatorio',
        ]);


        $nombreImagen = null;
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/ofertas', $nombreImagen);
        }



        $oferta = \App\Models\Oferta::create([
            'titulo' => $request->input('titulo'),
            'empresa' => $request->input('empresa'),
            'ubicacion' => $request->input('ubicacion'),
            'descripcion' => $request->input('descripcion'),
            'años_experiencia' => $request->input('años_experiencia'),
            'salario' => str_replace('.', '', $request->input('salario')),
            'fecha_expiracion' => $request->input('fecha_expiracion'),
            'carrera_id' => $request->input('carrera_id'),
            'horario_id' => $request->input('horario_id'),
            'modalidad_id' => $request->input('modalidad_id'),
            'estado_id' => $request->input('estado_id'),
            'imagen' => $nombreImagen,
        ]);


        $requisitos = array_merge($request->input('requisitos', []), $request->input('requisitos_nuevos', []));
        foreach ($requisitos as $req) {
            if (!empty(trim($req))) {
                \App\Models\RequisitoOferta::create([
                    'oferta_id' => $oferta->id,
                    'requisito' => $req
                ]);
            }
        }


        $beneficios = array_merge($request->input('beneficios', []), $request->input('beneficios_nuevos', []));
        foreach ($beneficios as $ben) {
            if (!empty(trim($ben))) {
                \App\Models\BeneficioOferta::create([
                    'oferta_id' => $oferta->id,
                    'beneficio' => $ben
                ]);
            }
        }


        $palabras = array_merge($request->input('palabras', []), $request->input('palabras_nuevas', []));
        foreach ($palabras as $pal) {
            if (!empty(trim($pal))) {
                \App\Models\PalabraClave::create([
                    'oferta_id' => $oferta->id,
                    'palabra' => $pal
                ]);
            }
        }

        $preguntas = array_merge($request->input('preguntas', []), $request->input('preguntas_nuevas', []));
        foreach ($preguntas as $p) {
            if (!empty(trim($p))) {
                \App\Models\PreguntaOferta::create([
                    'oferta_id' => $oferta->id,
                    'pregunta' => $p
                ]);
            }
        }


        $oferta->habilidadesBlandas()->sync($request->input('habilidades_blandas', []));

        $oferta->idiomas()->sync($request->input('idiomas', []));

        Flasher::addSuccess('Oferta creada correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.ofertas');
    }



    public function destroy($id)
    {
        $oferta = Oferta::findOrFail($id);


        if ($oferta->imagen) {
            Storage::delete('public/ofertas/' . $oferta->imagen);
        }


        $oferta->habilidadesBlandas()->detach();
        $oferta->idiomas()->detach();
        \App\Models\RequisitoOferta::where('oferta_id', $id)->delete();
        \App\Models\BeneficioOferta::where('oferta_id', $id)->delete();
        \App\Models\PalabraClave::where('oferta_id', $id)->delete();
        \App\Models\PreguntaOferta::where('oferta_id', $id)->delete();


        $oferta->delete();

        Flasher::addSuccess('Oferta eliminada correctamente.', 'Éxito');
        return redirect()->route('bolsadetrabajo.ofertas');
    }















    public function postulaciones($id, Request $request)
    {
        $oferta = Oferta::findOrFail($id);

        $carreras = Carrera::all();
        $idiomas_disponibles = \App\Models\IdiomasDisponibles::all();
        $modalidades = Modalidad::all();
        $disponibilidades = Time::all();
        $habilidades_blandas = HabilidadesBlandas::all();
        $aptitudes = Aptitud::select('aptitud')->distinct()->orderBy('aptitud')->get();

        // 🔹 Consulta base (solo una)
        $query = Postulacion::with([
            'usuario.carrera',
            'usuario.idiomas',
            'usuario.experiencias',
            'usuario.estudios',
            'usuario.aptitudes'
        ])->where('oferta_id', $id);

        // 🔹 Filtro de aptitudes
        if ($request->filled('aptitudes_palabras')) {
            $palabras = array_map('trim', explode(',', $request->input('aptitudes_palabras')));

            $query->whereHas('usuario.aptitudes', function ($q) use ($palabras) {
                $q->where(function ($sub) use ($palabras) {
                    foreach ($palabras as $palabra) {
                        $sub->orWhere('aptitud', 'like', '%' . $palabra . '%');
                    }
                });
            });
        }



        // Filtros opcionales (si vienen por GET)
        if ($request->filled('carreras')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->whereIn('carrera_id', (array) $request->carreras);
            });
        }

        // -- Idiomas (filtro robusto) --
        if ($request->filled('idiomas_disponibles')) {
            $selected = (array) $request->input('idiomas_disponibles');

            // 1) Caso: tabla 'idiomas' almacena 'idioma_id' (referencia a tabla idiomas_disponibles)
            if (Schema::hasColumn('idiomas', 'idioma_id')) {
                $query->whereHas('usuario.idiomas', function ($q) use ($selected) {
                    $q->whereIn('idioma_id', $selected);
                });

                // 2) Caso: tabla 'idiomas' guarda el NOMBRE del idioma en una columna (ej. 'idioma', 'nombre', 'nombre_idioma', 'descripcion')
            } else {
                // detectar la columna de texto con el nombre del idioma
                $nameCol = null;
                foreach (['idioma', 'nombre', 'nombre_idioma', 'descripcion'] as $col) {
                    if (Schema::hasColumn('idiomas', $col)) {
                        $nameCol = $col;
                        break;
                    }
                }

                if ($nameCol) {
                    // convertir los ids seleccionados (de idiomas_disponibles) en nombres
                    $names = IdiomasDisponibles::whereIn('id', $selected)->pluck('nombre_idioma')->filter()->values()->all();

                    if (!empty($names)) {
                        // buscar usuarios cuyos registros en 'idiomas' tengan el texto coincidente
                        $query->whereHas('usuario.idiomas', function ($q) use ($nameCol, $names) {
                            $q->whereIn($nameCol, $names);
                        });
                    } else {
                        // fallback: intentar buscar por id en la tabla idiomas (si el usuario seleccionó ids que coinciden con idiomas.id)
                        $query->whereHas('usuario.idiomas', function ($q) use ($selected) {
                            $q->whereIn('id', $selected);
                        });
                    }
                } else {
                    // fallback final: intentar filtrar por id de idioma en la relación
                    $query->whereHas('usuario.idiomas', function ($q) use ($selected) {
                        $q->whereIn('id', $selected);
                    });
                }
            }
        }

        // 🔹 Filtros restantes
        if ($request->filled('habilidades_blandas')) {
            $query->whereHas('usuario.aptitudes', function ($q) use ($request) {
                $q->whereIn('id', (array) $request->habilidades_blandas);
            });
        }

        if ($request->filled('modalidades')) {
            $query->whereHas('usuario.modalidades', function ($q) use ($request) {
                $q->whereIn('modalidad_id', (array) $request->modalidades);
            });
        }

        if ($request->filled('disponibilidades')) {
            $query->whereHas('usuario.disponibilidades', function ($q) use ($request) {
                $q->whereIn('disponibilidad_id', (array) $request->disponibilidades);
            });
        }

        // 🔹 Finalmente ejecutar la consulta
        $postulaciones = $query->get();

        return view('admin.ofertas.postulaciones', compact(
            'oferta',
            'postulaciones',
            'carreras',
            'idiomas_disponibles',
            'modalidades',
            'disponibilidades',
            'habilidades_blandas',
            'aptitudes',


        ));
    }
















    





    public function exportPostulaciones(Request $request)
    {
        $usuariosIds = $request->input('usuarios', []);
        $ofertaId = $request->input('oferta_id');

        if (empty($usuariosIds)) {
            return back()->with('error', 'Debes seleccionar al menos un usuario.');
        }

        $oferta = \App\Models\Oferta::find($ofertaId);
        if (!$oferta) {
            return back()->with('error', 'No se encontró la oferta.');
        }

        $usuarios = \App\Models\Usuario::with(['carrera', 'experiencias', 'estudios', 'aptitudes', 'idiomas', 'cvs'])
            ->whereIn('id', $usuariosIds)
            ->get();

        // 1️⃣ Crear Excel temporal
        $excelPath = storage_path('app/temp/postulaciones_oferta.xlsx');
        Excel::store(new PostulacionesExport($usuarios, $oferta), 'temp/postulaciones_oferta.xlsx');

        // 2️⃣ Crear ZIP temporal
        $zipPath = storage_path('app/temp/postulaciones_export.zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Añadir Excel
            $zip->addFile($excelPath, 'postulaciones_oferta.xlsx');

            // Crear carpeta CVs dentro del ZIP
            foreach ($usuarios as $user) {
                foreach ($user->cvs as $cv) {
                    $cvPath = storage_path('app/public/cv/' . $cv->nombre_archivo);
                    if (file_exists($cvPath)) {
                        $zip->addFile($cvPath, 'CVs/' . $user->nombre . '_' . $user->apellido . '_' . $cv->nombre_archivo);
                    }
                }
            }
            $zip->close();
        }

        // 3️⃣ Descargar ZIP y eliminar archivos temporales
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }





    public function show($oferta_id, Request $request)
    {
        $oferta = Oferta::findOrFail($oferta_id);
        $carreras = Carrera::all();

        $query = Postulacion::with('usuario.carrera', 'usuario.idiomas', 'usuario.experiencias')
            ->where('oferta_id', $oferta->id);

        // Filtros dinámicos
        if ($request->filled('carrera_id')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('carrera_id', $request->carrera_id);
            });
        }

        if ($request->filled('genero')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('genero', $request->genero);
            });
        }

        if ($request->filled('idioma')) {
            $query->whereHas('usuario.idiomas', function ($q) use ($request) {
                $q->where('idioma', 'like', '%' . $request->idioma . '%');
            });
        }

        $postulaciones = $query->get();
        $carreras = Carrera::all();

        return view('bolsadetrabajo.postulaciones', compact('oferta', 'postulaciones', 'carreras'));
    }
}
