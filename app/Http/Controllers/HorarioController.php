<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\Profesor;
use App\Models\Carrera;
use App\Models\Resolucion;
use App\Models\Sede;
use App\Models\Materia;
use App\Models\Comision;
use App\Models\Horario;
use App\Models\Modulo;
use Illuminate\Http\Request;
use DB;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        return view('frontend.horarios.tablaCarreras');
    }*/
    //back
    public function getResolucionesByCarrera($carrera_id)
    {
        $resoluciones = \App\Models\Materia::where('carrera_id', $carrera_id)
        ->with('resolucion') // relación en el modelo Materia
        ->get()
        ->pluck('resolucion.resolucion', 'resolucion.id')
        ->unique()
        ->toArray();

        return response()->json($resoluciones);
    }

    //Back
    public function index()
    {
        $carreras = Carrera::pluck('descripcion', 'id');
        $anios = Anio::pluck('descripcion', 'id');
        $comisions = Comision::pluck('comision', 'id');
        $sedes = Sede::pluck('descripcion', 'id');
        $resoluciones = []; 

        return view('backend.horario.index', compact('carreras', 'anios', 'comisions', 'sedes', 'resoluciones'));
    }


    //Front
    public function porCarrera()
    {
        $carreras = Carrera::pluck('descripcion', 'id');
        $anios = Anio::pluck('descripcion', 'id');
        $comisions = Comision::pluck('comision', 'id');
        $sedes = Sede::pluck('descripcion', 'id');

        // Para cada carrera verificamos si tiene materias no anuales
        $carrerasConSoloAnuales = Horario::select('carrera_id')
            ->groupBy('carrera_id')
            ->havingRaw('SUM(CASE WHEN cuatrimestre_id IS NOT NULL THEN 1 ELSE 0 END) = 0')
            ->pluck('carrera_id')
            ->toArray();

        return view('frontend.horarios.porCarrera', compact(
            'carreras',
            'anios',
            'comisions',
            'sedes',
            'carrerasConSoloAnuales'
        ));
    }


    //Front
    public function porProfesor()
    {
        $profesores = Profesor::select("id", DB::raw("CONCAT(profesors.apellido,', ',profesors.nombre) as nombrecompleto"))
        ->orderby('nombrecompleto', 'ASC')->pluck('nombrecompleto');
       // $profesores = Profesor::pluck('nombrecompleto')->sortBy('apellido');

        return view('frontend.horarios.porProfesor', compact('profesores'));
    }

    //Front
    public function searchProfesor(Request $request)
    {
        $validatedData = $request->validate(
            [
                'profesor_id' => ['required']
            ]
        );
        //$horario = Horario::FindOrFail($request->input('profesor_id')); 

        $sede = Sede::find($request->input('sede_id'));
        $sedes = Sede::pluck('descripcion', 'id');
        $dias = array();

        $carrera = Carrera::find($request->input('carrera_id'));
        $anio = Anio::find($request->input('anio_id'));
        //$modulosHorarios = Modulo::all()->sortBy('horainicio');
        $modulosHorarios  = Modulo::join('horarios', 'modulos.id', '=', 'horarios.modulohorario_id')
            ->get(['modulos.id', 'horainicio', 'horafin'])->unique()->sortBy('horainicio');
        $comision = Comision::find($request->input('comision_id'));

        $horarios = Horario::where('profesor_id', ($request->input('profesor_id')))->get();
        $dias = array();
        $dias[1] = 'Lunes';
        $dias[2] = 'Martes';
        $dias[3] = 'Miércoles';
        $dias[4] = 'Jueves';
        $dias[5] = 'Viernes';

        foreach ($horarios as $key_hora => $hora) {
            foreach ($horarios as $key_hora => $hora) {
                if ($hora->dia == '6') {
                    $dias[6] = 'Sábado';
                }
            }
        }
        ksort($dias);

        return view('frontend.horarios.tablaPorProfesor', compact(
            'sede',
            'carrera',
            'sedes',
            'horarios',
            'anio',
            'dias',
            'comision',
            'modulosHorarios'
        ));
    }

    //Front
    public function porDiaHora()
    {
        $modulohorario = Modulo::select("id", DB::raw("CONCAT(modulos.horainicio,' - ',modulos.horafin) as horario"))->pluck('horario', 'id');

        $dias = array(1 => 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');

        return view('frontend.horarios.porDiaHora', compact('modulohorario', 'dias'));
    }
    public function create(Request $request)
    {
    }
    public function createHorario(Request $request)
    {
        $sede = Sede::find($request->input('sede_id'));
        $sedes = Sede::pluck('descripcion', 'id');

        $carreras = Carrera::pluck('descripcion', 'id');
        $anios = Anio::pluck('anio', 'id');
        $comisions = Comision::pluck('comision', 'id');

        $carrera = Carrera::find($request->input('carrera_id'));
        $anio = Anio::find($request->input('anio_id'));
        $profesores = Profesor::select("id", DB::raw("CONCAT(profesors.apellido,', ',profesors.nombre) as nombrecompleto"))
            ->orderby('nombrecompleto', 'ASC')->pluck('nombrecompleto', 'id');
        $materias = Materia::where('carrera_id', $carrera->id)
        ->where('anio_id', $anio->id)
        ->when($request->filled('resolucion_id'), function($query) use ($request) {
            $query->where('resolucion_id', $request->input('resolucion_id'));
        })
        ->pluck('descripcion', 'id');


        $modulo = Modulo::find($request->input('modulohorario_id'));
        $dia = $request->input('dia');
        $modulosHorario = Modulo::select("id", DB::raw("CONCAT(modulos.horainicio,' ',modulos.horafin) as horariocompleto"))
            ->pluck('horariocompleto', 'id');
        $comision = Comision::find($request->input('comision_id'));
        $dias = array();
        $dias[1] = 'Lunes';
        $dias[2] = 'Martes';
        $dias[3] = 'Miércoles';
        $dias[4] = 'Jueves';
        $dias[5] = 'Viernes';
        $dias[6] = 'Sábado';

        $horarios = Horario::where('sede_id', $sede->id)
            ->where('carrera_id', $carrera->id)
            ->where('anio_id', $anio->id)
            ->where('comision_id', $comision->id)->get();

        return view('backend.horario.create', compact(
            'sede',
            'carrera',
            'carreras',
            
            'sedes',
            'horarios',
            'anio',
            'materias',
            'dias',
            'modulosHorario',
            'comision',
            'profesores',
            'modulo',
            'dia'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'sede_id' => 'required',
                'carrera_id' => 'required',
                'anio_id' => 'required',
                'comision_id' => 'required',
                'materia_id' => 'required',
                'profesor_id' => 'required',
                'dia' => 'required',
                'modulohorario_id' => 'required'
            ]
        );

        $horario = Horario::where('sede_id', $request->input('sede_id'))
            ->where('carrera_id', $request->input('carrera_id'))
            ->where('anio_id', $request->input('anio_id'))
            ->where('comision_id', $request->input('comision_id'))
            ->where('dia', $request->input('dia'))
            ->where('comentario', $request->input('comentario'))
            ->where('materia_id', $request->input('materia_id'))
            ->where('modulohorario_id', $request->input('modulohorario_id'))->first();

        if (empty($horario)) {
            $horario = new Horario();
        }
        $horario->sede_id = $request->input('sede_id');
        $horario->carrera_id = $request->input('carrera_id');
        $horario->anio_id = $request->input('anio_id');
        $horario->comision_id = $request->input('comision_id');
        $horario->cuatrimestre_id = $request->input('cuatrimestre_id') == 0 ? null : $request->input('cuatrimestre_id');
        $horario->materia_id = $request->input('materia_id');
        $horario->profesor_id = $request->input('profesor_id');
        $horario->dia = $request->input('dia');
        $horario->modulohorario_id = $request->input('modulohorario_id');
        $horario->comentario = $request->input('comentario');
        $horario->save();
        //$request->session()->flash('status', 'Se guardó correctamente el horario '. $noticia->titulo);
        return redirect()->route('horario.search.carrera', ['sede' => $horario->sede_id, 'carrera' => $horario->carrera_id, 'anio' => $horario->anio_id, 'comision' => $horario->comision_id]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //ADMIN
    public function search(Request $request)
    {
        $validatedData = $request->validate(
            [
                'sede_id' => 'required',
                'carrera_id' => 'required',
                'anio_id' => 'required',
                'comision_id' => 'required',
                'cuatrimestre_id' => 'required',
                'resolucion_id' => 'required',
            ]
        );
        
        return redirect()->route('horario.search.carrera', [
            'sede'            => $request->input('sede_id'),
            'carrera'         => $request->input('carrera_id'),
            'anio'            => $request->input('anio_id'),
            'comision'        => $request->input('comision_id'),
            'cuatrimestre_id' => $request->input('cuatrimestre_id'),
            'resolucion_id'   => $request->input('resolucion_id'),
        ]);

    }

    //Back
    public function searchCarrera($sede, $carrera, $anio, $comision)
    {
        $cuatrimestre_id = request()->input('cuatrimestre_id');
        $resolucion_id   = request()->input('resolucion_id'); // ← tomarlo de la query

        $sede    = Sede::find($sede);
        $carrera = Carrera::find($carrera);

        $dias = [1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado'];

        $horarios = Horario::where('sede_id', $sede->id)
            ->where('carrera_id', $carrera->id)
            ->where('anio_id', $anio)
            ->where('comision_id', $comision)
            ->when($resolucion_id, function($query) use ($resolucion_id) {
                $query->whereHas('materia', function($q) use ($resolucion_id) {
                    $q->where('resolucion_id', $resolucion_id);
                });
            })
            ->when($cuatrimestre_id == 1 || $cuatrimestre_id == 2, function ($query) use ($cuatrimestre_id) {
                return $query->where(function ($q) use ($cuatrimestre_id) {
                    $q->where('cuatrimestre_id', $cuatrimestre_id)
                    ->orWhereNull('cuatrimestre_id'); // incluir anuales
                });
            })
            ->when($cuatrimestre_id == 0 || is_null($cuatrimestre_id), function ($query) {
                return $query->whereNull('cuatrimestre_id'); // solo anuales
            })
            ->get();

        $resolucion = $resolucion_id ? Resolucion::find($resolucion_id) : null;

        $anio            = Anio::find($anio);
        $modulosHorarios = Modulo::all()->sortBy('horainicio');
        $comision        = Comision::find($comision);

        return view('backend.horario.show', compact(
            'sede','carrera','resolucion','horarios','anio','dias',
            'comision','cuatrimestre_id','modulosHorarios'
        ));
    }



    //Front
    public function searchCarreraUser(Request $request) //($sede, $carrera, $anio, $comision)
    {
        $validatedData = $request->validate(
            [
                'sede_id' => 'required',
                'carrera_id' => 'required',
                'anio_id' => 'required',
                'comision_id' => 'required',
                'cuatrimestre_id' => 'required',
                'resolucion_id' => 'required'
            ]
        );
        $cuatrimestre_id = request()->input('cuatrimestre_id'); // o $request->input si usás Request
        $resolucion_id   = request()->input('resolucion_id');
        $sede = Sede::find($request->input('sede_id'));
        $sedes = Sede::pluck('descripcion', 'id');
        $dias = array();
        $carrera = Carrera::find($request->input('carrera_id'));
        $anio = Anio::find($request->input('anio_id'));
        //$modulosHorarios = Modulo::all()->sortBy('horainicio');
        $modulosHorarios  = Modulo::join('horarios', 'modulos.id', '=', 'horarios.modulohorario_id')
            ->get(['modulos.id', 'horainicio', 'horafin'])->unique()->sortBy('horainicio');
        $comision = Comision::find($request->input('comision_id'));
        $horarios = Horario::where('sede_id', $sede->id)
            ->where('carrera_id', $carrera->id)
            ->where('anio_id', $anio->id)
            ->where('comision_id', $comision->id)
            ->when($resolucion_id, function($query) use ($resolucion_id) {
                $query->whereHas('materia', function($q) use ($resolucion_id) {
                    $q->where('resolucion_id', $resolucion_id);
                });
            })
            ->when($cuatrimestre_id == 1 || $cuatrimestre_id == 2, function ($query) use ($cuatrimestre_id) {
                return $query->where(function ($q) use ($cuatrimestre_id) {
                    $q->where('cuatrimestre_id', $cuatrimestre_id)
                    ->orWhereNull('cuatrimestre_id'); // incluir materias anuales
                });
            })
            ->when($cuatrimestre_id == 0 || is_null($cuatrimestre_id), function ($query) {
                return $query->whereNull('cuatrimestre_id'); 
            })
            ->get();
        $resolucion = $resolucion_id ? Resolucion::find($resolucion_id) : null;

        $dias[1] = 'Lunes';
        $dias[2] = 'Martes';
        $dias[3] = 'Miércoles';
        $dias[4] = 'Jueves';
        $dias[5] = 'Viernes';

        foreach ($horarios as $key_hora => $hora) {
            if ($hora->dia == '6') {
                $dias[6] = 'Sábado';
            }
        }

        ksort($dias);

        return view('frontend.horarios.tablaCarreras', compact(
            'sede',
            'carrera',
            'resolucion',
            'sedes',
            'horarios',
            'anio',
            'dias',
            'comision',
            'cuatrimestre_id',
            'modulosHorarios'
        ));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */

    //Front
    public function searchPorDiaHora(Request $request)
    {
        $validatedData = $request->validate(
            [
                'dias' => 'required',
                'modulohorario_id' => 'required'
            ]
        );
        $horarios = Horario::where('dia', $request->input('dias'))
            ->where('modulohorario_id', $request->input('modulohorario_id'))->get();
        return view('frontend.horarios.tablaDiaHora', compact('horarios'));
    }

    public function show($id)
    {
        // $horarios = Horario::all();
        // return view('backend.horario.show', compact('horarios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */

    //Back
    public function edit($id)
    {
        $horarios = Horario::findOrFail($id);
        $dias = array();
        $dias[1] = 'Lunes';
        $dias[2] = 'Martes';
        $dias[3] = 'Miércoles';
        $dias[4] = 'Jueves';
        $dias[5] = 'Viernes';
        $dias[6] = 'Sábado';
        $modulosHorarios = Modulo::select("id", DB::raw("CONCAT(modulos.horainicio,' ',modulos.horafin) as horariocompleto"))
            ->pluck('horariocompleto', 'id');
        $materias = Materia::where('carrera_id', $horarios->carrera->id)
            ->where('anio_id', $horarios->anio->id)
            ->pluck('descripcion', 'id');
        $profesores = Profesor::select("id", DB::raw("CONCAT(profesors.apellido,', ',profesors.nombre) as nombrecompleto"))
            ->pluck('nombrecompleto', 'id');
        return view('backend.horario.edit', compact('horarios', 'dias', 'modulosHorarios', 'materias', 'profesores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $horario = Horario::findOrFail($id);

        $validateData = $request->validate(
            [
                'sede_id' => ['required'],
                'carrera_id' => ['required'],
                'anio_id' => ['required'],
                'profesor_id' => ['required'],
                'materia_id' => ['required'],
                'comision_id' => ['required'],
                'dia' => ['required'],
                'modulohorario_id' => ['required']
            ]
        );

        /*$horario->sede_id = $request->input('sede_id');    
        $horario->carrera_id = $request->input('carrera_id');
        $horario->anio_id = $request->input('anio_id');*/
        $horario->profesor_id = $request->input('profesor_id');
        $horario->materia_id = $request->input('materia_id');
        $horario->comentario = $request->input('comentario');
        //$horario->comision_id = $request->input('comision_id');    
        $horario->dia = $request->input('dia');
        $horario->modulohorario_id = $request->input('modulohorario_id');
        //$horario->duracion = $request->input('duracion');    
        $horario->save();
 
        $request->session()->flash('status', 'Se modificó correctamente el horario');
        return redirect()->route('horario.search.carrera', ['sede' => $horario->sede_id, 'carrera' => $horario->carrera_id, 'anio' => $horario->anio_id, 'comision' => $horario->comision_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
        $sede = $horario->sede_id;
        $carrera = $horario->carrera_id;
        $anio = $horario->anio_id;
        $comision = $horario->comision_id;
        $horario->delete();
        return redirect()->route('horario.search.carrera', ['sede' => $sede, 'carrera' => $carrera, 'anio' => $anio, 'comision' => $comision]);
    }
}