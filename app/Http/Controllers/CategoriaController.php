<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {   
        
        $categorias = Categoria::orderBy('id')->paginate(10);
        return view('backend.categoria.index', compact('categorias'));
    }

    public function create()
    {
        return view('backend.categoria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        Categoria::create($request->only(['categoria', 'descripcion']));

        return redirect()->route('categoria.index')->with('status', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('backend.categoria.edit', compact('categoria'));
    }
    
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'categoria' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $categoria->update([
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion, 
        ]);

        return redirect()->route('categoria.index')->with('status', 'Categoría actualizada correctamente.');
    }


    public function destroy(Categoria $categoria)
    {
        
        $categoria->delete();

        return redirect()->route('categoria.index')->with('status', 'Categoría eliminada correctamente.');
    }
}
