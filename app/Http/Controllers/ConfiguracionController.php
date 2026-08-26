<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\IdiomasDisponibles;
use App\Models\IdiomaOferta;
use App\Models\Aptitud;
use App\Models\Idioma;
use App\Models\Time;
use App\Models\HabilidadesBlandas;
use App\Models\Modalidad;
use Illuminate\Support\Facades\DB;
use Flasher\Laravel\Facade\Flasher;



// Controlador que permite listar, crear, actualizar y eliminar configuraciones del sistema (carreras, idiomas, habilidades blandas, modalidades y horarios), validando duplicados y evitando borrar elementos en uso por usuarios u ofertas.

class ConfiguracionController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        $idiomas = IdiomasDisponibles::all();
        $habilidades = HabilidadesBlandas::all();
        $modalidades = Modalidad::all();
        $horarios = Time::all();

        return view('admin_configuracion', compact(
            'carreras',
            'idiomas',
            'habilidades',
            'modalidades',
            'horarios'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([

            'carreras' => 'array',
            'carreras.*' => 'nullable|string|max:255',
            'carreras_nuevos' => 'array',
            'carreras_nuevos.*' => 'nullable|string|max:255',


            'idiomas' => 'array',
            'idiomas.*' => 'nullable|string|max:255',
            'idiomas_nuevos' => 'array',
            'idiomas_nuevos.*' => 'nullable|string|max:255',


            'habilidades' => 'array',
            'habilidades.*' => 'nullable|string|max:255',
            'habilidades_nuevos' => 'array',
            'habilidades_nuevos.*' => 'nullable|string|max:255',


            'modalidades' => 'array',
            'modalidades.*' => 'nullable|string|max:255',
            'modalidades_nuevos' => 'array',
            'modalidades_nuevos.*' => 'nullable|string|max:255',


            'horarios' => 'array',
            'horarios.*' => 'nullable|string|max:255',
            'horarios_nuevos' => 'array',
            'horarios_nuevos.*' => 'nullable|string|max:255',
        ]);


        if (!empty($data['horarios'])) {
            foreach ($data['horarios'] as $id => $tipo) {
                $tipo = trim($tipo);
                if ($tipo !== '') {
                    $horario = Time::find($id);
                    if ($horario && $horario->tipo !== $tipo) {
                        if (!Time::where('tipo', $tipo)->exists()) {
                            $horario->update(['tipo' => $tipo]);
                        }
                    }
                }
            }
        }
        if (!empty($data['horarios_nuevos'])) {
            $nuevos = array_unique(array_map('trim', $data['horarios_nuevos']));
            foreach ($nuevos as $tipo) {
                if ($tipo !== '' && !Time::where('tipo', $tipo)->exists()) {
                    Time::create(['tipo' => $tipo]);
                }
            }
        }


        if (!empty($data['modalidades'])) {
            foreach ($data['modalidades'] as $id => $tipo) {
                $tipo = trim($tipo);
                if ($tipo !== '') {
                    $mod = Modalidad::find($id);
                    if ($mod && $mod->tipo !== $tipo) {
                        if (!Modalidad::where('tipo', $tipo)->exists()) {
                            $mod->update(['tipo' => $tipo]);
                        }
                    }
                }
            }
        }
        if (!empty($data['modalidades_nuevos'])) {
            $nuevas = array_unique(array_map('trim', $data['modalidades_nuevos']));
            foreach ($nuevas as $tipo) {
                if ($tipo !== '' && !Modalidad::where('tipo', $tipo)->exists()) {
                    Modalidad::create(['tipo' => $tipo]);
                }
            }
        }



        if (!empty($data['habilidades'])) {
            foreach ($data['habilidades'] as $id => $descripcion) {
                $descripcion = trim($descripcion);
                if ($descripcion !== '') {
                    $hab = HabilidadesBlandas::find($id);
                    if ($hab && $hab->descripcion !== $descripcion) {
                        if (!HabilidadesBlandas::where('descripcion', $descripcion)->exists()) {
                            $hab->update(['descripcion' => $descripcion]);
                        }
                    }
                }
            }
        }
        if (!empty($data['habilidades_nuevos'])) {
            $nuevas = array_unique(array_map('trim', $data['habilidades_nuevos']));
            foreach ($nuevas as $descripcion) {
                if ($descripcion !== '' && !HabilidadesBlandas::where('descripcion', $descripcion)->exists()) {
                    HabilidadesBlandas::create(['descripcion' => $descripcion]);
                }
            }
        }


        if (!empty($data['carreras'])) {
            foreach ($data['carreras'] as $id => $nombre) {
                $nombre = trim($nombre);
                if ($nombre !== '') {
                    $carrera = Carrera::find($id);
                    if ($carrera && $carrera->descripcion !== $nombre) {
                        if (!Carrera::where('descripcion', $nombre)->exists()) {
                            $carrera->update(['descripcion' => $nombre]);
                        }
                    }
                }
            }
        }
        if (!empty($data['carreras_nuevos'])) {
            $nuevas = array_unique(array_map('trim', $data['carreras_nuevos']));
            foreach ($nuevas as $nombre) {
                if ($nombre !== '' && !Carrera::where('descripcion', $nombre)->exists()) {
                    Carrera::create(['descripcion' => $nombre]);
                }
            }
        }


        if (!empty($data['idiomas'])) {
            foreach ($data['idiomas'] as $id => $nombre) {
                $nombre = trim($nombre);
                if ($nombre !== '') {
                    $idioma = IdiomasDisponibles::find($id);
                    if ($idioma && $idioma->nombre_idioma !== $nombre) {
                        if (!IdiomasDisponibles::where('nombre_idioma', $nombre)->exists()) {
                            $idioma->update(['nombre_idioma' => $nombre]);
                        }
                    }
                }
            }
        }
        if (!empty($data['idiomas_nuevos'])) {
            $nuevos = array_unique(array_map('trim', $data['idiomas_nuevos']));
            foreach ($nuevos as $nombre) {
                if ($nombre !== '' && !IdiomasDisponibles::where('nombre_idioma', $nombre)->exists()) {
                    IdiomasDisponibles::create(['nombre_idioma' => $nombre]);
                }
            }
        }


        Flasher::addSuccess('Configuración actualizada correctamente.', 'Éxito');
        return back();
    }

    public function destroyCarrera($id)
    {
        $carrera = Carrera::find($id);

        if ($carrera) {
            // Verificar si hay usuarios u ofertas con esa carrera
            $usadaEnUsuarios = \App\Models\Usuario::where('carrera_id', $id)->exists();
            $usadaEnOfertas  = \App\Models\Oferta::where('carrera_id', $id)->exists();

            if ($usadaEnUsuarios || $usadaEnOfertas) {
                return response()->json([
                    'success' => false,
                    'message' => 'La carrera está en uso y no puede eliminarse'
                ]);
            }

            $carrera->delete();
            Flasher::addSuccess('Carrera eliminada correctamente.', 'Éxito');
            return response()->json(['success' => true]);
        }

        Flasher::addError('No se encontró la carrera a eliminar.', 'Error');
        return response()->json(['success' => false]);
    }

    public function destroyIdioma($id)
    {
        $idiomaDisp = IdiomasDisponibles::find($id);

        if (!$idiomaDisp) {
            Flasher::addError('Idioma no encontrado.', 'Error');
            return response()->json(['success' => false, 'message' => 'Idioma no encontrado']);
        }

        // ¿Está usado en OFERTAS? -> pivot idiomas_ofertas
        $usadoEnOfertas = DB::table('idiomas_ofertas')
            ->where('idioma_id', $id)
            ->exists();

        // ¿Está usado en USUARIOS? -> por TEXTO en la tabla 'idiomas'
        $usadoEnUsuarios = DB::table('idiomas')
            ->where('idioma', $idiomaDisp->nombre_idioma)
            ->exists();

        if ($usadoEnOfertas || $usadoEnUsuarios) {
            return response()->json([
                'success' => false,
                'message' => 'El idioma está en uso (usuarios u ofertas) y no puede eliminarse'
            ]);
        }

        $idiomaDisp->delete();
        Flasher::addSuccess('Idioma eliminado correctamente.', 'Éxito');
        return response()->json(['success' => true]);
    }

    public function destroyHabilidad($id)
    {
        $hab = HabilidadesBlandas::find($id);

        if (!$hab) {
            Flasher::addError('Habilidad no encontrada.', 'Error');
            return response()->json(['success' => false, 'message' => 'Habilidad no encontrada']);
        }

        // ¿Está en uso en OFERTAS?
        $usadaEnOfertas = DB::table('habilidades_blandas_ofertas')
            ->where('habilidad_blanda_id', $id)
            ->exists();

        // Opcional: si tenés pivot de usuarios, chequealo aquí
        // $usadaEnUsuarios = DB::table('usuario_habilidad')->where('habilidad_id', $id)->exists();
        // En tu caso parece que no existe, así que omitimos

        if ($usadaEnOfertas) {
            Flasher::addError('La habilidad está en uso en ofertas y no puede eliminarse', 'Error');
            return response()->json([
                'success' => false,
                'message' => 'La habilidad está en uso en ofertas y no puede eliminarse'
            ]);
        }

        $hab->delete();

        Flasher::addSuccess('Habilidad eliminada correctamente.', 'Éxito');
        return response()->json(['success' => true]);
    }

    public function destroyModalidad($id)
    {
        $mod = Modalidad::find($id);

        if (!$mod) {
            Flasher::addError('Modalidad no encontrada.', 'Error');
            return response()->json(['success' => false]);
        }

        // Verificar si está en uso en OFERTAS
        $usadaEnOfertas = \App\Models\Oferta::where('modalidad_id', $id)->exists();


        if ($usadaEnOfertas) {
            return response()->json([
                'success' => false,
                'message' => 'La modalidad está en uso y no puede eliminarse'
            ]);
        }

        $mod->delete();

        Flasher::addSuccess('Modalidad eliminada correctamente.', 'Éxito');
        return response()->json(['success' => true]);
    }

    public function destroyHorario($id)
    {
        $horario = Time::find($id);

        if (!$horario) {
            Flasher::addError('Horario no encontrado.', 'Error');
            return response()->json(['success' => false]);
        }

        // Verificar si está en uso en OFERTAS
        $usadoEnOfertas = \App\Models\Oferta::where('horario_id', $id)->exists();


        if ($usadoEnOfertas) {
            return response()->json([
                'success' => false,
                'message' => 'El horario está en uso y no puede eliminarse'
            ]);
        }

        $horario->delete();

        Flasher::addSuccess('Horario eliminado correctamente.', 'Éxito');
        return response()->json(['success' => true]);
    }
}
