<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Aptitud;
use Flasher\Laravel\Facade\Flasher;

//Controlador que permite crear, actualizar y eliminar aptitudes de un usuario en su perfil.




class AptitudController extends Controller
{
    // Método para mostrar el formulario de creación
    public function create()
    {
        return view('crear.crear_habilidad'); // Asegurate que el nombre de la vista coincida
    }

    // Método para guardar la nueva habilidad
    public function store(Request $request)
    {
        $request->validate([
            'aptitud' => 'required|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        Aptitud::create([
            'aptitud' => $request->aptitud,
            'usuario_id' => $request->usuario_id,
        ]);

        Flasher::addSuccess('Habilidad agregada correctamente.', 'Éxito');
        
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'habilidades']);
    }

    // Método update que ya tenés
    public function update(Request $request, $id)
    {
        $aptitud = Aptitud::findOrFail($id);

        $request->validate([
            'aptitud' => 'required|string|max:255',
        ]);

        $aptitud->update([
            'aptitud' => $request->aptitud,
        ]);

        Flasher::addSuccess('Habilidad actualizada correctamente.', 'Éxito');
        
        return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'habilidades']);
    }
    public function destroy($id)
{
    $aptitud = Aptitud::findOrFail($id);
    $aptitud->delete();

    Flasher::addSuccess('Habilidad eliminada correctamente.', 'Éxito');
    
    return redirect()->route('bolsadetrabajo.perfil', ['seccion' => 'aptitudes', 'subseccion' => 'habilidades']);
}

}
