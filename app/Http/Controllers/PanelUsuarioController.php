<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Carrera;
use App\Models\Etiqueta;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\MesaInscripcion;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Str;
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

        $infoUsuario = $usuario ? $this->armarInfoUsuario($usuario) : [];

        return view('panel.index', compact(
            'usuario',
            'infoUsuario',
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

    // Información que se muestra en el panel de cada usuario: última
    // conexión, avisos según su rol y novedades del instituto.
    private function armarInfoUsuario(Usuario $usuario): array
    {
        $zona = 'America/Argentina/Buenos_Aires';

        // La conexión "anterior" se guarda en sesión al loguearse (ver
        // InicioSesionController). Si la sesión es anterior a este cambio,
        // se usa la última registrada en la base.
        $previaRaw = session()->has('ultima_conexion_previa')
            ? session('ultima_conexion_previa')
            : $usuario->getRawOriginal('ultima_conexion');

        $ultimaConexion = $previaRaw ? Carbon::parse($previaRaw)->timezone($zona) : null;

        return [
            'ultimaConexion' => $ultimaConexion,
            'avisos'         => $this->avisosDelUsuario($usuario, $ultimaConexion),
            'novedades'      => $this->novedadesRecientes(),
        ];
    }

    private function avisosDelUsuario(Usuario $usuario, ?Carbon $desde): array
    {
        $avisos = [];

        switch ($usuario->rol) {
            case 'usuario': // alumno
                $limite = $desde ? $desde->copy()->timezone('UTC') : now()->subDays(30);

                $notasNuevas = Calificacion::where('usuario_id', $usuario->id)
                    ->whereNotNull('nota')
                    ->where('updated_at', '>', $limite)
                    ->count();

                if ($notasNuevas > 0) {
                    $avisos[] = [
                        'icono' => '📝',
                        'texto' => $notasNuevas === 1
                            ? 'Tenés 1 nota nueva cargada.'
                            : "Tenés {$notasNuevas} notas nuevas cargadas.",
                        'url'   => route('bolsadetrabajo.alumno.materias.index'),
                    ];
                }

                $mesas = MesaInscripcion::where('usuario_id', $usuario->id)
                    ->whereHas('mesa', fn ($q) => $q->whereDate('fecha', '>=', today()))
                    ->with('mesa.materia')
                    ->get()
                    ->sortBy(fn ($i) => $i->mesa->fecha)
                    ->take(3);

                foreach ($mesas as $inscripcion) {
                    $avisos[] = [
                        'icono' => '📅',
                        'texto' => 'Estás inscripto a la mesa de ' . ($inscripcion->mesa->materia->descripcion ?? 'una materia')
                                   . ' el ' . Carbon::parse($inscripcion->mesa->fecha)->format('d/m/Y') . '.',
                        'url'   => route('bolsadetrabajo.alumno.mesas.index'),
                    ];
                }

                if (!$usuario->perfil_completado) {
                    $avisos[] = [
                        'icono' => '👤',
                        'texto' => 'Todavía no completaste tu perfil.',
                        'url'   => route('bolsadetrabajo.perfil.editar'),
                    ];
                }
                break;

            case 'profesor':
                $materias = Materia::where('profesor_usuario_id', $usuario->id)->count();
                $avisos[] = [
                    'icono' => '📚',
                    'texto' => $materias === 0
                        ? 'Todavía no tenés materias asignadas.'
                        : ($materias === 1 ? 'Tenés 1 materia a cargo.' : "Tenés {$materias} materias a cargo."),
                    'url'   => $materias > 0 ? route('bolsadetrabajo.profesor.materias.index') : null,
                ];

                $profesorMesas = $usuario->profesorMesas;
                if ($profesorMesas) {
                    $proximasMesas = Mesa::where(function ($q) use ($profesorMesas) {
                            $q->where('profesor_id', $profesorMesas->id)
                              ->orWhere('vocal_id', $profesorMesas->id);
                        })
                        ->whereDate('fecha', '>=', today())
                        ->count();

                    if ($proximasMesas > 0) {
                        $avisos[] = [
                            'icono' => '📅',
                            'texto' => $proximasMesas === 1
                                ? 'Tenés 1 mesa de examen próxima.'
                                : "Tenés {$proximasMesas} mesas de examen próximas.",
                            'url'   => route('bolsadetrabajo.profesor.mesas.index'),
                        ];
                    }
                }
                break;

            case 'preceptor':
                $carreras = $usuario->carrerasAsignadas()->count();
                $avisos[] = [
                    'icono' => '🎓',
                    'texto' => $carreras === 0
                        ? 'Todavía no tenés carreras asignadas.'
                        : ($carreras === 1 ? 'Tenés 1 carrera asignada.' : "Tenés {$carreras} carreras asignadas."),
                    'url'   => $carreras > 0 ? route('bolsadetrabajo.preceptor.carreras') : null,
                ];
                break;

            case 'superadministrador':
                $pendientes = Usuario::where('estado', 'pendiente')->count();
                if ($pendientes > 0) {
                    $avisos[] = [
                        'icono' => '⏳',
                        'texto' => $pendientes === 1
                            ? 'Hay 1 usuario pendiente de aprobación.'
                            : "Hay {$pendientes} usuarios pendientes de aprobación.",
                        'url'   => null,
                    ];
                }
                break;
        }

        return $avisos;
    }

    // Últimas novedades del instituto (mismas que muestra /novedades).
    private function novedadesRecientes()
    {
        $etiqueta = Etiqueta::where('nombre', 'novedades')->first();

        if (!$etiqueta) {
            return collect();
        }

        return $etiqueta->novedades()
            ->take(4)
            ->get()
            ->map(fn ($n) => [
                'titulo' => $n->titulo,
                'resumen' => Str::limit(trim(strip_tags($n->cuerpo)), 110),
                'fecha'  => optional($n->created_at)->timezone('America/Argentina/Buenos_Aires')->format('d/m/Y'),
            ]);
    }
}
