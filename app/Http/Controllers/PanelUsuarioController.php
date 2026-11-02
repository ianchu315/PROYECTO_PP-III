<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Página a la que cae cualquier usuario logueado de Bolsa de Trabajo justo
// después de iniciar sesión: saludo + navbar según su rol. Es el "dashboard
// nuevo" pedido, separado de bolsadetrabajo/home (que sigue existiendo tal
// cual estaba) y de mesasfront.
class PanelUsuarioController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user();
        $esSuperadmin = $usuario && $usuario->rol === 'superadministrador';

        $usuariosPendientes = collect();
        $usuariosActivos = collect();
        $usuariosInactivos = collect();
        $profesores = collect();
        $preceptores = collect();
        $carreras = collect();
        $materiasPorCarrera = collect();
        $buscarProfesor = $request->get('buscar_profesor', '');
        $buscarPreceptor = $request->get('buscar_preceptor', '');
        $buscarAlumno = $request->get('buscar_alumno', '');

        if ($esSuperadmin) {
            $usuariosPendientes = Usuario::where('estado', 'pendiente')
                ->with('carrera')
                ->orderBy('created_at', 'desc')
                ->get();

            // Usuarios activos = alumnos (rol "usuario") aprobados. Admite
            // ?buscar_alumno= por nombre/apellido/email, paginado de a 10
            // por la misma razón que los profesores: no renderizar cientos
            // de tarjetas de una sola vez.
            $activosQuery = Usuario::where('estado', 'aprobado')
                ->where('rol', 'usuario')
                ->with('carrerasHabilitadas');

            if ($buscarAlumno !== '') {
                $activosQuery->where(function ($q) use ($buscarAlumno) {
                    $q->where('nombre', 'like', "%{$buscarAlumno}%")
                      ->orWhere('apellido', 'like', "%{$buscarAlumno}%")
                      ->orWhere('email', 'like', "%{$buscarAlumno}%");
                });
            }

            $usuariosActivos = $activosQuery
                ->orderBy('apellido')
                ->paginate(10, ['*'], 'pagina_alumnos')
                ->withQueryString();

            $usuariosInactivos = Usuario::where('estado', 'inactivo')
                ->orderBy('apellido')
                ->get();

            // Profesores: paginado + búsqueda por nombre/apellido/email, para
            // no tener que renderizar cientos de tarjetas de una sola vez
            // cuando la base crezca (pensado para ~500 usuarios en uso).
            $profesoresQuery = Usuario::where('rol', 'profesor')
                ->where('estado', 'aprobado')
                ->with(['carrera', 'carrerasHabilitadas']);

            if ($buscarProfesor !== '') {
                $profesoresQuery->where(function ($q) use ($buscarProfesor) {
                    $q->where('nombre', 'like', "%{$buscarProfesor}%")
                      ->orWhere('apellido', 'like', "%{$buscarProfesor}%")
                      ->orWhere('email', 'like', "%{$buscarProfesor}%");
                });
            }

            $profesores = $profesoresQuery
                ->orderBy('apellido')
                ->paginate(10, ['*'], 'pagina_profesores')
                ->withQueryString();

            $preceptoresQuery = Usuario::where('rol', 'preceptor')
                ->where('estado', 'aprobado')
                ->with('carrerasAsignadas');

            if ($buscarPreceptor !== '') {
                $preceptoresQuery->where(function ($q) use ($buscarPreceptor) {
                    $q->where('nombre', 'like', "%{$buscarPreceptor}%")
                      ->orWhere('apellido', 'like', "%{$buscarPreceptor}%")
                      ->orWhere('email', 'like', "%{$buscarPreceptor}%");
                });
            }

            $preceptores = $preceptoresQuery
                ->orderBy('apellido')
                ->paginate(10, ['*'], 'pagina_preceptores')
                ->withQueryString();

            $carreras = Carrera::orderBy('descripcion')->get();

            // Materias agrupadas por carrera, para armar el checklist de cada
            // profesor sin pegarle a la base por cada uno.
            $materiasPorCarrera = Materia::orderBy('descripcion')
                ->get()
                ->groupBy('carrera_id');
        }

        return view('panel.index', compact(
            'usuario',
            'esSuperadmin',
            'usuariosPendientes',
            'usuariosActivos',
            'usuariosInactivos',
            'profesores',
            'preceptores',
            'carreras',
            'materiasPorCarrera',
            'buscarProfesor',
            'buscarPreceptor',
            'buscarAlumno'
        ));
    }
}
