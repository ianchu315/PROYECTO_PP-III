<?php

namespace App\Http\Controllers;

// Asistencia todavía no está modelada en la base de datos (no hay tabla ni
// lógica). Este controlador solo evita un link roto en el menú nuevo hasta
// que definamos cómo se registra/consulta la asistencia (por clase, por
// materia, etc.).
class AsistenciaPendienteController extends Controller
{
    public function index()
    {
        return view('panel.en_construccion', [
            'titulo'  => 'Asistencia',
            'mensaje' => 'Este módulo todavía no está desarrollado. En cuanto definamos cómo se registra la asistencia (por clase, por materia, etc.) lo conectamos acá.',
        ]);
    }
}
