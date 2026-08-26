<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use App\Models\Oferta;
use App\Models\Carrera;
use App\Models\IdiomasDisponibles;
use Flasher\Laravel\Facade\Flasher;

// Gestiona la visualización, edición y actualización del perfil de usuario, incluyendo foto de perfil, validación de datos y carga de relaciones como experiencias, estudios, aptitudes y postulaciones.

class PerfilController extends Controller
{
    public function index(Request $request)
    {
        // Obtenemos el usuario autenticado
        $usuario = Auth::guard('usuarios')->user();

        // Cargamos las relaciones necesarias solo si es una instancia de Usuario
        if ($usuario instanceof \App\Models\Usuario) {
            $usuario->load(
                'carrera',
                'experienciasLaborales',
                'estudios',
                'aptitudes',
                'cursos',
                'postulaciones.oferta',
                'idiomas',
                'cvs'
            );
        }

        $ofertas = Oferta::all();
        // 👇 nuevo: traemos los idiomas disponibles de la tabla
        $idiomasDisponibles = IdiomasDisponibles::all();
        $seccion = $request->query('seccion', 'experiencia');
        $editarId = $request->query('editar');

        return view('perfil', compact('usuario', 'ofertas', 'seccion', 'editarId', 'idiomasDisponibles'));
    }

    public function editar()
    {
        $usuario = Auth::guard('usuarios')->user();
        if ($usuario instanceof \App\Models\Usuario) {
            $usuario->load('carrera');
        }
        $carreras = Carrera::all();

        return view('perfil.editar', compact('usuario', 'carreras'));
    }

    public function actualizar(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        // Manejo de foto de perfil independiente
        if ($request->hasFile('foto_perfil')) {
            $file = $request->file('foto_perfil');

            // Borrar foto anterior si existe
            if ($usuario->foto_perfil) {
                Storage::delete('public/usuarios/' . $usuario->foto_perfil);
            }

            $nombreFoto = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/usuarios', $nombreFoto);

            $usuario->foto_perfil = $nombreFoto;

            // Guardamos inmediatamente la foto
            if ($usuario instanceof \App\Models\Usuario) {
                $usuario->save();
            }
        }

        // Validación de los demás campos
        $validator = Validator::make($request->all(), [
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'fecha_nacimiento'  => 'required|date|before:today',
            'email'             => 'required|email|unique:usuarios,email,' . $usuario->id,
            'descripcion'       => 'required|string|max:1000',
            'ciudad_residencia' => 'required|string|max:50',
            'nacionalidad'      => 'required|string|max:50',
            'sitio_web'         => 'nullable|url|max:255',
            'telefono'          => 'required|string|max:20',
            'dni'               => 'required|string|max:20',
            'genero'            => 'required|string|max:20',
            'carrera_id'        => 'required|exists:carreras,id',
        ], [
            'required' => 'Este campo es obligatorio',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Guardar los demás datos
        if ($usuario instanceof \App\Models\Usuario) {
            $usuario->fill($request->except('foto_perfil'));
            $usuario->perfil_completado = true;
            $usuario->save();
        }

        Flasher::addSuccess('Perfil actualizado correctamente', 'Exito');
        return redirect()->route('bolsadetrabajo.perfil');
    }
    public function fotoGuardar(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        if ($request->hasFile('foto_perfil')) {
            $file = $request->file('foto_perfil');

            // Borrar foto anterior
            if ($usuario->foto_perfil) {
                Storage::delete('public/usuarios/' . $usuario->foto_perfil);
            }

            $nombreFoto = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/usuarios', $nombreFoto);

            $usuario->foto_perfil = $nombreFoto;
            if ($usuario instanceof \App\Models\Usuario) {
                $usuario->save();
            }

            return response()->json(['success' => true, 'foto' => $nombreFoto]);
        }

        return response()->json(['success' => false]);
    }
}




