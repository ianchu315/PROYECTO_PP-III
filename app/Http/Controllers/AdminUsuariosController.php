<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Flasher\Laravel\Facade\Flasher;

//Controlador que permite listar, filtrar, crear, editar, actualizar y eliminar usuarios, incluyendo la gestión de su foto de perfil y asociación con carreras.




class AdminUsuariosController extends Controller
{

    public function index(Request $request)
    {
        $query = Usuario::with('carrera');

        if ($request->filled('busqueda')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->busqueda . '%')
                    ->orWhere('apellido', 'like', '%' . $request->busqueda . '%')
                    ->orWhere('email', 'like', '%' . $request->busqueda . '%');
            });
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        if ($request->filled('carrera_id')) {
            $query->where('carrera_id', $request->carrera_id);
        }

        // ✅ FILTRO POR GÉNERO
        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        if ($request->orden === 'antiguas') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $usuarios = $query->get();

        $conteoCarreras = Carrera::withCount('usuarios')->get();

        return view('admin_usuarios', [
            'usuarios' => $usuarios,
            'rol' => $request->rol,
            'orden' => $request->orden ?? 'recientes',
            'carrera_id' => $request->carrera_id ?? null,
            'genero' => $request->genero ?? null, // opcional, para mantener seleccionado
            'conteoCarreras' => $conteoCarreras,
        ]);
    }

    public function edit($id)
    {
        $carreras = \App\Models\Carrera::all();
        $usuario = Usuario::findOrFail($id);
        return view('admin_usuarios_editar', compact('usuario', 'carreras'));
    }


    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',
            'email'            => 'required|email|unique:usuarios,email,' . $usuario->id,
            'password'         => 'nullable|string|min:6',
            'rol'              => 'required|in:usuario,profesor,administrador,preceptor',
            'carrera_id'       => 'required|exists:carreras,id',
            'dni'              => 'required|string|max:15',
            'fecha_nacimiento' => 'required|date',
            'genero'           => 'required|string|max:20',
            'nacionalidad'     => 'required|string|max:50',
            'ciudad_residencia' => 'required|string|max:50',
            'descripcion'      => 'nullable|string|max:1000',
            'telefono'         => 'required|string|max:15',
            'sitio_web'        => 'nullable|url',
            'nueva_foto'        => 'nullable|image|mimes:jpg,jpeg,png',
        ], [
            'required' => 'Este campo es obligatorio',
        ]);

        $usuario->fill($request->except('password', 'nueva_foto'));

        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }

        if ($request->hasFile('nueva_foto')) {
            // borrar foto vieja
            if ($usuario->foto_perfil) {
                Storage::delete('public/usuarios/' . $usuario->foto_perfil);
            }

            // guardar nueva
            $foto = $request->file('nueva_foto');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/usuarios', $nombreFoto);

            $usuario->foto_perfil = $nombreFoto;
        }

        $usuario->save();

        Flasher::addSuccess('Usuario actualizado correctamente.');
        return back();
    }















    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        Flasher::addSuccess('Usuario eliminado correctamente.');
        return back();
    }




    public function create()
    {
        $carreras = Carrera::all();
        return view('admin_usuarios_crear', compact('carreras'));
    }






    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:usuario,profesor,administrador,preceptor',
            'carrera_id' => 'required|exists:carreras,id',
            'sitio_web' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'dni' => 'required|string|max:15',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string|max:20',
            'nacionalidad' => 'required|string|max:50',
            'ciudad_residencia' => 'required|string|max:50',
            'telefono' => 'required|string|max:15',
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png'
        ], [
            'required' => 'Este campo es obligatorio',
        ]);

        $nombreFoto = null;
        if ($request->hasFile('foto_perfil')) {
            $foto = $request->file('foto_perfil');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/usuarios', $nombreFoto);
        }

        Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
            'sitio_web' => $request->sitio_web,
            'dni' => $request->dni,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'nacionalidad' => $request->nacionalidad,
            'ciudad_residencia' => $request->ciudad_residencia,
            'carrera_id' => $request->carrera_id,
            'descripcion' => $request->descripcion,
            'telefono' => $request->telefono,
            'foto_perfil' => $nombreFoto, // 👈 guardamos solo el nombre del archivo
        ]);

        Flasher::addSuccess('Usuario creado correctamente.');
        return redirect()->route('bolsadetrabajo.usuarios');
    }
}
