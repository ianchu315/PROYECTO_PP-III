<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cv;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Flasher\Laravel\Facade\Flasher;

// Permite subir múltiples CVs validando su formato y tamaño, los guarda en almacenamiento y en la base de datos, y también permite eliminar CVs existentes junto con su archivo.

class CvController extends Controller
{
    
    public function subir(Request $request)
    {
        $request->validate([
            'cv.*' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $usuarioId = Auth::id();

        $archivos = $request->file('cv');

        foreach ($archivos as $archivo) {
            $nombreArchivo = time() . '_' . Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $archivo->getClientOriginalExtension();

            $archivo->storeAs('public/cv', $nombreArchivo);

            Cv::create([
                'usuario_id' => $usuarioId,
                'nombre_archivo' => $nombreArchivo,
            ]);
        }

        Flasher::addSuccess('¡CV subido correctamente!', 'Éxito');
        return back();
    }


    public function eliminar($id)
    {
        $cv = Cv::findOrFail($id);

        Storage::delete('public/cv/' . $cv->nombre_archivo);

        $cv->delete();

        Flasher::addSuccess('¡CV eliminado correctamente!', 'Éxito');
        return redirect()->back();
    }
}
