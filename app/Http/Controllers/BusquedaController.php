<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Oferta;
use App\Models\AñoAcademico;
use App\Models\DisponibilidadHoraria;
use App\Models\Modalidad;
use App\Models\HabilidadesBlandas;
use App\Models\IdiomasDisponibles;
use App\Models\Time;
use App\Models\PalabraClave;
use App\Models\Idioma;
use Illuminate\Support\Facades\Auth;
use App\Models\OfertaGuardada;



//Controlador que realiza búsquedas y filtrado de ofertas laborales según múltiples criterios (título, empresa, ubicación, carrera, año académico, modalidad, disponibilidad, habilidades, idiomas, palabras clave, experiencia y salario) y marca cuáles ofertas están guardadas por el usuario autenticado.



class BusquedaController extends Controller
{
    public function busqueda(Request $request)
    {
        // Obtiene el valor del parámetro 'orden' enviado en la solicitud (GET)
        $orden = $request->input('orden');
        // Obtiene el término de búsqueda ingresado por el usuario
        $busqueda = $request->input('busqueda');
        // Obtiene la ubicación ingresada por el usuario
        $ubicacion = $request->input('ubicacion');

        // Se obtienen todos los registros necesarios para mostrar los filtros en la vista
        $carreras = Carrera::all();
        $años_academicos = AñoAcademico::all();
        $modalidades = Modalidad::all();
        $disponibilidades = Time::all();
        $habilidades_blandas = HabilidadesBlandas::all();
        $idiomas_disponibles = IdiomasDisponibles::all();
        $idiomas = Idioma::all();


        // Se inicia una consulta sobre el modelo Oferta
        $query = Oferta::where('estado_id', 1);


        // Ordenamiento por fecha de creación, según el valor del filtro 'orden'
        if ($orden === 'antiguas') {
            $query->orderBy('created_at', 'asc'); // Más antiguas primero
        } else {
            $query->orderBy('created_at', 'desc'); // Más recientes primero
        }

        // Si hay una búsqueda por título o empresa, se aplica un filtro
        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', '%' . $busqueda . '%')
                    ->orWhere('empresa', 'like', '%' . $busqueda . '%');
            });
        }

        // Si se especifica una ubicación, se filtran las ofertas por esa ubicación
        if ($ubicacion) {
            $query->where('ubicacion', 'like', '%' . $ubicacion . '%');
        }

        // Filtra por carreras seleccionadas si hay datos enviados
        if ($request->filled('carreras')) {
            $query->whereIn('carrera_id', $request->carreras);
        }

        // Filtra por años académicos seleccionados si están presentes
        if ($request->filled('años_academicos')) {
            $query->whereIn('año_academico_id', $request->años_academicos);
        }

        // Filtra por modalidades seleccionadas (presencial, remoto, híbrido, etc.)
        if ($request->filled('modalidades')) {
            $query->whereIn('modalidad_id', $request->modalidades);
        }

        // Filtra por disponibilidad horaria (mañana, tarde, etc.)
        if ($request->filled('disponibilidades')) {
            $query->whereIn('horario_id', $request->disponibilidades);
        }

        // Filtra por habilidades blandas asociadas a la oferta (trabajo en equipo, liderazgo, etc.)
        if ($request->filled('habilidades_blandas')) {
            foreach ($request->habilidades_blandas as $habilidad_id) {
                $query->whereHas('habilidadesBlandas', function ($q) use ($habilidad_id) {
                    $q->where('habilidad_blanda_id', $habilidad_id);
                });
            }
        }

        // Filtra por idiomas requeridos para la oferta
        if ($request->filled('idiomas_disponibles')) {
            $query->whereHas('idiomasDisponibles', function ($q) use ($request) {
                $q->whereIn('idioma_id', $request->idiomas_disponibles);
            });
        }

        // (Este bloque está repetido innecesariamente, pero vuelve a filtrar por disponibilidad horaria)
        if ($request->filled('disponibilidades')) {
            $query->whereIn('horario_id', $request->disponibilidades);
        }

        // Filtra por palabras clave relacionadas a la oferta (en campo separado)
        if ($request->filled('palabras_clave')) {
            $palabras = array_map('trim', explode(',', $request->palabras_clave));
            $query->whereHas('palabrasClave', function ($q) use ($palabras) {
                $q->where(function ($subquery) use ($palabras) {
                    foreach ($palabras as $palabra) {
                        $subquery->orWhere('palabra', 'like', '%' . $palabra . '%');
                    }
                });
            });
        }

        // Filtra por experiencia mínima requerida
        if ($request->filled('min_experiencia')) {
            $query->where('años_experiencia', '>=', $request->input('min_experiencia'));
        }

        // Filtra por experiencia máxima requerida
        if ($request->filled('max_experiencia')) {
            $query->where('años_experiencia', '<=', $request->input('max_experiencia'));
        }


        // Filtra por condiciones salariales (moneda, salario mínimo y máximo)
        if ($request->filled('min_salario')) {
            $query->where('salario', '>=', $request->input('min_salario'));
        }

        if ($request->filled('max_salario')) {
            $query->where('salario', '<=', $request->input('max_salario'));
        }

        // Obtener ofertas filtradas
        $ofertas = $query->get();

        // ✅ Usuario autenticado
        $usuario = Auth::guard('usuarios')->user();
        $ofertasGuardadasIds = [];

        // 🔐 Atajo para superadministradores: si buscan "superUsuario" se abre
        // un popup con la lista de espera de alumnos/profesores pendientes de aprobar.
        // No afecta la búsqueda normal para el resto de los usuarios.
        $mostrarPopupSuperUsuario = false;
        $usuariosPendientes = collect();

        if ($usuario && $busqueda && strtolower(trim($busqueda)) === 'superusuario') {
            // En producción, solo el superadministrador puede ver esto.
            // En entorno local (APP_ENV=local) se habilita para cualquier
            // usuario logueado, únicamente para facilitar las pruebas.
            $puedeVerPopup = $usuario->rol === 'superadministrador' || app()->environment('local');

            if ($puedeVerPopup) {
                $mostrarPopupSuperUsuario = true;
                $usuariosPendientes = \App\Models\Usuario::where('estado', 'pendiente')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        if ($usuario) {
            // Si necesitas las postulaciones, asegúrate de que $usuario es un modelo Eloquent User y tiene la relación 'postulaciones'
            // Si no es necesario, puedes eliminar la siguiente línea:
            // $usuario->load('postulaciones');
            $ofertasGuardadasIds = OfertaGuardada::where('usuario_id', $usuario->id)
                ->pluck('oferta_id')
                ->toArray();
        }

        // Marcar ofertas guardadas
        foreach ($ofertas as $oferta) {
            $oferta->guardada = in_array($oferta->id, $ofertasGuardadasIds);
        }

        
        return view('busqueda', compact(
            'ofertas',
            'usuario',
            'orden',
            'busqueda',
            'ubicacion',
            'carreras',
            'años_academicos',
            'modalidades',
            'disponibilidades',
            'habilidades_blandas',
            'idiomas_disponibles',
            'idiomas',
            'mostrarPopupSuperUsuario',
            'usuariosPendientes'
        ));
        
    }
    
}