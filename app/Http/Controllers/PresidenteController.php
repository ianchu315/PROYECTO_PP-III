<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presidente;
use App\Models\Profesor;
use App\Models\Carrera;
use App\Models\Materia;
use Illuminate\Validation\Rule;


class PresidenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materia = Materia::all();
        $profesor = Profesor::all();
        $presidentes = Presidente::all();

        return view('backend.presidentes.index', compact('presidentes', 'profesor', 'materia'));
    }
    public function titulares(){

        $materias=Materia::all();
        
        return view('backend.presidentes.titulares', compact('materias'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materias = Materia::all();
        $carreras = Carrera::all();
        $profesors = Profesor::all();
        return view('backend.presidentes.create', compact('materias', 'profesors' ,'carreras'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    $request->validate([
        'nombre_id' => 'required',
        'apellido_id' => 'required',
        'materia_id' => [
            'required',
            Rule::unique('presidentes')->where(function ($query) {
                return $query->where('materia_id', request('materia_id'));
            })
        ],
        'carrera_id' => 'required',
        'horario' => 'required'
    ]);

    $presidente = new Presidente();
    $presidente->nombre_id = $request->input('nombre_id');
    $presidente->apellido_id = $request->input('apellido_id');
    $presidente->materia_id = $request->input('materia_id');
    $presidente->carrera_id = $request->input('carrera_id');
    $presidente->horario = $request->input('horario');
    $presidente->save();

    return redirect()->route('presidentes.index')->with('success', 'Presidente creado correctamente');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $presidentes = Presidente::all();
        return view('backend.presidentes.show', compact('presidentes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $materias = Materia::all();
        $profesors = Profesor::all();
        $carreras = Carrera::all();
        $presidente = Presidente::findOrFail($id);
        return view('backend.presidentes.edit', compact('presidente', 'materias', 'profesors','carreras'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $presidente = Presidente::findOrFail($id);

        $request->validate([
            'nombre_id' => 'required',
            'apellido_id' => 'required',
            'materia_id' => [
            'required',
            Rule::unique('presidentes')->where(function ($query) {
                return $query->where('materia_id', request('materia_id'));
            })
        ],
        'carrera_id' => 'required',
            'horario' => 'required'
        ]);

        $presidente->nombre_id = $request->input('nombre_id');
        $presidente->apellido_id = $request->input('apellido_id');
        $presidente->materia_id = $request->input('materia_id');
        $presidente->carrera_id = $request->input('carrera_id');
        $presidente->horario = $request->input('horario');
        $presidente->save();

        return redirect()->route('presidentes.index')->with('success', 'Presidente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presidente = Presidente::findOrFail($id);
        $presidente->delete();

        return redirect()->route('presidentes.index')->with('deleted', 'Presidente eliminado correctamente');
        return redirect()->route('presidentes.index')->with('success', 'Presidente eliminado correctamente');
    }
}