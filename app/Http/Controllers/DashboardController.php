<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Postulacion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


//  Genera estadísticas para el dashboard, incluyendo cantidad de usuarios por carrera y género, ofertas y postulaciones de los últimos 7 días, y obtiene las últimas ofertas y postulaciones para mostrarlas en la vista.

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        // --- Estadísticas de carreras ---
        $carreras = DB::table('carreras')
            ->leftJoin('usuarios', 'carreras.id', '=', 'usuarios.carrera_id')
            ->select('carreras.id', 'carreras.descripcion', DB::raw('COUNT(usuarios.id) as cantidad'))
            ->groupBy('carreras.id', 'carreras.descripcion')
            ->get();

        $labelsCarreras = [];
        $cantidadesCarreras = [];
        $idsCarreras = [];

        foreach ($carreras as $carrera) {
            $labelsCarreras[] = $carrera->descripcion;
            $cantidadesCarreras[] = $carrera->cantidad;
            $idsCarreras[] = $carrera->id;
        }

        // --- Ofertas últimos 7 días ---
        $ofertasLabels = [];
        $ofertasFechas = [];
        $ofertasData = [];

        for ($i = 6; $i >= 0; $i--) {
            $fecha = $hoy->copy()->subDays($i);
            $ofertasLabels[] = $fecha->isoFormat('dddd'); // nombre del día
            $ofertasFechas[] = $fecha->toDateString();    // fecha exacta
            $cantidad = Oferta::whereDate('created_at', $fecha)->count();
            $ofertasData[] = $cantidad;
        }

        $ofertas = Oferta::latest()->take(5)->get();
        $ultimasPostulaciones = Postulacion::latest()->take(5)->get();
        $todasPostulaciones = Postulacion::count();
        $usuarios = DB::table('usuarios')->count();

        // --- Alumnos por género ---
        $generosPredefinidos = ['Masculino', 'Femenino', 'No binario', 'Transgénero', 'Otro', 'Prefiero no decirlo'];
        $generos = DB::table('usuarios')
            ->select('genero', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('genero')
            ->pluck('cantidad', 'genero'); // array asociativo [genero => cantidad]

        $labelsGeneros = [];
        $cantidadesGeneros = [];
        $idsGeneros = [];

        foreach ($generosPredefinidos as $g) {
            $labelsGeneros[] = $g;
            $cantidadesGeneros[] = $generos[$g] ?? 0;
            $idsGeneros[] = strtolower(str_replace(' ', '_', $g)); // ej: "No binario" -> "no_binario"
        }

        // --- Postulaciones últimos 7 días (solo postulaciones reales) ---
        $postulacionesLabels = [];
        $postulacionesFechas = [];
        $postulacionesData = [];

        for ($i = 6; $i >= 0; $i--) {
            $fecha = $hoy->copy()->subDays($i);
            $postulacionesLabels[] = $fecha->isoFormat('dddd');
            $postulacionesFechas[] = $fecha->toDateString();

            // contar solo postulaciones reales
            $cantidad = DB::table('postulaciones')
                ->whereDate('created_at', $fecha)
                ->count();

            $postulacionesData[] = $cantidad;
        }

        // --- Retornar la vista con todas las variables ---
        return view('dashboard', [
            'labelsCarreras' => $labelsCarreras,
            'cantidadesCarreras' => $cantidadesCarreras,
            'idsCarreras' => $idsCarreras,
            'ofertasLabels' => $ofertasLabels,
            'ofertasFechas' => $ofertasFechas,
            'ofertasData' => $ofertasData,
            'ofertas' => $ofertas,
            'ultimasPostulaciones' => $ultimasPostulaciones,
            'todasPostulaciones' => $todasPostulaciones,
            'usuarios' => $usuarios,
            'labelsGeneros' => $labelsGeneros,
            'cantidadesGeneros' => $cantidadesGeneros,
            'idsGeneros' => $idsGeneros,
            'postulacionesLabels' => $postulacionesLabels,
            'postulacionesFechas' => $postulacionesFechas,
            'postulacionesData' => $postulacionesData,
        ]);
    }
}
