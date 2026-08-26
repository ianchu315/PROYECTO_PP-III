<?php

use App\Http\Controllers\PanelUsuarioController;
use App\Http\Controllers\AsistenciaPendienteController;
use App\Http\Controllers\Frontend\AlumnoMateriasController;
use Illuminate\Support\Facades\Route;

// Dashboard nuevo al que cae cualquier usuario logueado. La navbar de este
// panel (layouts.panel) cambia según el rol; ver ese archivo para el detalle.
Route::middleware(['auth:usuarios'])->group(function () {

    Route::get('bolsadetrabajo/panel', [PanelUsuarioController::class, 'index'])
        ->name('bolsadetrabajo.panel');

    // "Mis materias" para el alumno (lectura de notas + condición).
    Route::get('bolsadetrabajo/alumno/materias', [AlumnoMateriasController::class, 'index'])
        ->name('bolsadetrabajo.alumno.materias.index');

    // Placeholder compartido por "Mi asistencia" (alumno) y "Asistencia" (profesor)
    // hasta que se defina/desarrolle ese módulo.
    Route::get('bolsadetrabajo/asistencia', [AsistenciaPendienteController::class, 'index'])
        ->name('bolsadetrabajo.asistencia.index');
});
