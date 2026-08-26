<?php
namespace App\Http\Controllers;

use App\Models\Correlativa;
use App\Models\{Materia, Anio, Carrera};
use Illuminate\Http\Request;

class CorrelativaController extends Controller
{
    public function index(Request $request)
    {
        $query = Correlativa::with(['materia', 'correlativa', 'carrera','anio',]);

        // Filtros
        if ($request->filled('carrera_id')) {
            $query->whereHas('materia', function ($q) use ($request) {
                $q->where('carrera_id', $request->carrera_id);
            });
        }

        if ($request->filled('anio_id')) {
            $query->whereHas('materia', function ($q) use ($request) {
                $q->where('anio_id', $request->anio_id);
            });
        }

        if ($request->filled('materia_id')) {
            $query->where('materia_id', $request->materia_id);
        }

        $correlativas = $query->paginate(25);

        $carreras = Carrera::all();
        $anios    = Anio::all();
        $materias = Materia::all();

        return view('backend.correlativa.index', compact('correlativas', 'carreras', 'anios', 'materias'));
    }

    public function getMaterias(Request $request)
    {
        $materias = Materia::query();

        if ($request->filled('carrera_id')) {
            $materias->where('carrera_id', $request->carrera_id);
        }
        if ($request->filled('anio_id')) {
            $materias->where('anio_id', $request->anio_id);
        }

        return response()->json($materias->orderBy('descripcion')->get());
    }

    public function getCorrelativas(Request $request)
    {
        
        $materia = Materia::find($request->materia_id);

        if (!$materia) {
            return response()->json([]);
        }
     
        $aniosAnteriores = range(1, $materia->anio_id - 1);

        if (empty($aniosAnteriores)) {
           
            return response()->json([]);
        }

        $materias = Materia::where('carrera_id', $materia->carrera_id)
            ->whereIn('anio_id', $aniosAnteriores)
            ->orderBy('anio_id')
            ->orderBy('descripcion')
            ->get();

        return response()->json($materias);
    }

    public function create()
    {
        $carreras = Carrera::all();
        $anios = Anio::all();
        $materias = Materia::all();

        return view('backend.correlativa.create', compact('carreras', 'anios', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'materia_id' => 'required|exists:materias,id',
            'correlativa_id' => 'required|exists:materias,id|different:materia_id',
        ]);

        Correlativa::create($request->all());

        return redirect()->route('backend.correlativa.index')->with('success', 'Correlativa creada.');
    }

    public function edit(Correlativa $correlativa, Request $request)
{
    $carreras = Carrera::all();
    $anios = Anio::all();
    $materias = Materia::all();

    $selectedCarrera = $request->get('carrera_id', $correlativa->carrera_id);
    $selectedAnio = $request->get('anio_id', $correlativa->anio_id);

    return view('backend.correlativa.edit', compact(
        'correlativa', 'carreras', 'anios', 'materias',
        'selectedCarrera', 'selectedAnio'
    ));
}

    public function byCarreraAndAnio(Request $request){
        $query = \App\Models\Materia::query();
        if ($request->filled('carrera_id')) {
            $query->where('carrera_id', $request->carrera_id);
        }
        if ($request->filled('anio_id')) {
            $query->where('anio_id', $request->anio_id);
        }
        $materias = $query->orderBy('descripcion')->get(['id','descripcion','anio_id']);
        return response()->json($materias);
    }

    public function correlativas(Request $request){
        // Si tenés una tabla pivot 'correlativas' con columnas (materia_id, correlativa_id):
        $ids = \DB::table('correlativas')
        ->where('materia_id', $request->materia_id)
        ->pluck('correlativa_id')
        ->toArray();
        $correlativas = \App\Models\Materia::whereIn('id', $ids)->orderBy('descripcion')->get(['id','descripcion','anio_id']);
        return response()->json($correlativas);
    }

    public function update(Request $request, Correlativa $correlativa)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'correlativa_id' => 'required|exists:materias,id|different:materia_id',
        ]);

        $correlativa->update($request->all());

        return redirect()->route('backend.correlativa.index')->with('success', 'Correlativa actualizada.');
    }

    public function destroy(Correlativa $correlativa)
    {
        $correlativa->delete();

        return redirect()->route('backend.correlativa.index')->with('success', 'Correlativa eliminada.');
    }
}
