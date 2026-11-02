<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\MateriaRecurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriaContenidoController extends Controller
{
    private function materiaGestionable(int $materiaId): Materia
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(
            !$usuario || !in_array($usuario->rol, ['profesor', 'administrador', 'superadministrador'], true),
            403,
            'Acceso denegado.'
        );

        $query = Materia::whereKey($materiaId);
        if ($usuario->rol === 'profesor') {
            $query->where('profesor_usuario_id', $usuario->id);
        }

        return $query->firstOrFail();
    }

    public function crearUnidad(Request $request, int $materiaId)
    {
        $materia = $this->materiaGestionable($materiaId);
        $data = $request->validate([
            'titulo' => ['required', 'string', 'max:160'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            'archivos' => ['nullable', 'array', 'max:10'],
            'archivos.*' => ['file', 'max:20480', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,rtf,odt,ods,odp,zip,jpg,jpeg,png'],
        ]);

        $unidad = $materia->unidades()->create([
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'] ?? null,
            'orden' => ((int) $materia->unidades()->max('orden')) + 1,
        ]);

        foreach ($request->file('archivos', []) as $archivo) {
            $ruta = $archivo->store("materias/{$materia->id}/unidades/{$unidad->id}", 'local');
            $unidad->recursos()->create([
                'nombre_original' => $archivo->getClientOriginalName(),
                'ruta' => $ruta,
                'tipo_mime' => $archivo->getClientMimeType(),
                'tamano_bytes' => $archivo->getSize(),
            ]);
        }

        return back()->with('success', 'Unidad y materiales agregados correctamente.');
    }

    public function eliminarUnidad(int $materiaId, int $unidadId)
    {
        $materia = $this->materiaGestionable($materiaId);
        $unidad = $materia->unidades()->with('recursos')->findOrFail($unidadId);

        foreach ($unidad->recursos as $recurso) {
            Storage::disk('local')->delete($recurso->ruta);
        }
        $unidad->delete();

        return back()->with('success', 'Unidad eliminada.');
    }

    public function agregarRecursos(Request $request, int $materiaId, int $unidadId)
    {
        $materia = $this->materiaGestionable($materiaId);
        $unidad = $materia->unidades()->findOrFail($unidadId);
        $data = $request->validate([
            'archivos' => ['required', 'array', 'max:10'],
            'archivos.*' => ['required', 'file', 'max:20480', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,rtf,odt,ods,odp,zip,jpg,jpeg,png'],
        ]);

        foreach ($request->file('archivos', []) as $archivo) {
            $ruta = $archivo->store("materias/{$materia->id}/unidades/{$unidad->id}", 'local');
            $unidad->recursos()->create([
                'nombre_original' => $archivo->getClientOriginalName(),
                'ruta' => $ruta,
                'tipo_mime' => $archivo->getClientMimeType(),
                'tamano_bytes' => $archivo->getSize(),
            ]);
        }

        return back()->with('success', 'Material agregado a la unidad.');
    }

    public function eliminarRecurso(int $materiaId, int $unidadId, int $recursoId)
    {
        $materia = $this->materiaGestionable($materiaId);
        $unidad = $materia->unidades()->findOrFail($unidadId);
        $recurso = $unidad->recursos()->findOrFail($recursoId);

        Storage::disk('local')->delete($recurso->ruta);
        $recurso->delete();

        return back()->with('success', 'Archivo eliminado.');
    }

    public function descargar(int $materiaId, int $recursoId)
    {
        $usuario = Auth::guard('usuarios')->user();
        abort_if(!$usuario, 403, 'Acceso denegado.');

        $recurso = MateriaRecurso::with('unidad.materia')->findOrFail($recursoId);
        $materia = $recurso->unidad->materia;
        abort_unless((int) $materia->id === $materiaId, 404);

        if ($usuario->rol === 'usuario') {
            $inscripto = $materia->alumnosInscriptos()
                ->where('usuarios.id', $usuario->id)
                ->exists();
            abort_unless($inscripto, 403, 'No estás inscripto en esta materia.');
        } elseif ($usuario->rol === 'profesor') {
            abort_unless((int) $materia->profesor_usuario_id === (int) $usuario->id, 403, 'No tenés acceso a esta materia.');
        } elseif (!in_array($usuario->rol, ['administrador', 'superadministrador'], true)) {
            abort(403, 'Acceso denegado.');
        }

        abort_unless(Storage::disk('local')->exists($recurso->ruta), 404);

        return response()->download(storage_path('app/' . $recurso->ruta), $recurso->nombre_original);
    }
}
