<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salon;  
use App\Models\Carrera; 
use App\Models\Anio;    
use App\Models\Comision;

class SalonController extends Controller
{
    /**4
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salones = Salon::with('carrera', 'anio', 'comision')
        ->orderBy('numero_salon', 'asc')
        ->get();
    
        return view('backend.salon.index', compact('salones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carreras = Carrera::all();
        $anios = Anio::all();
        $comisiones = Comision::all();

        return view('backend.salon.create', compact('carreras', 'anios', 'comisiones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $validated = $request->validate([
        'numero_salon' => 'required|string|max:50',
        'capacidad'    => 'required|integer|min:1',
        'carrera_id'   => 'required|exists:carreras,id',
        'anio_id'      => 'required|exists:anios,id',
        'comision_id'  => 'required|exists:comisions,id',
        'laboratorio'  => 'nullable|boolean',
        ]);

        Salon::create($validated);

        return redirect()
            ->route('salones.index')
            ->with('success', 'El salón fue creado correctamente ✅');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $salon = Salon::findOrFail($id);
        $carreras = Carrera::all();
        $anios = Anio::all();
        $comisiones = Comision::all();

        return view('backend.salon.edit', compact('salon', 'carreras', 'anios', 'comisiones'));
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
        $request->validate([
            'numero_salon' => 'required|string|max:50',
            'capacidad'    => 'required|integer|min:1',
            'carrera_id'   => 'required|exists:carreras,id',
            'anio_id'      => 'required|exists:anios,id',
            'comision_id'  => 'required|exists:comisions,id',
            'laboratorio'  => 'nullable|boolean',
        ]);

        $salon = Salon::findOrFail($id);
        $salon->update($request->only(['numero_salon', 'capacidad', 'carrera_id', 'anio_id', 'comision_id', 'laboratorio']));

        return redirect()->route('salones.index')
                        ->with('success', 'El salón se actualizó correctamente ✅');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $salon = Salon::findOrFail($id);

        // Verificar si alguna mesa usa este salón
        if ($salon->mesas()->exists()) {
            return redirect()->back()->with('error', 'No se puede borrar el salón porque está asignado a mesas.');
        }

        $salon->delete();
        return redirect()->back()->with('success', 'Salón eliminado correctamente.');
    }

}
