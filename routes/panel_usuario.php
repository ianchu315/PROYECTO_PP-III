<?php

use App\Http\Controllers\PanelUsuarioController;
use App\Http\Controllers\Frontend\AlumnoAsistenciaController;
use App\Http\Controllers\Frontend\AlumnoMateriasController;
use App\Http\Controllers\Frontend\AlumnoMesasController;
use App\Http\Controllers\MateriaContenidoController;
use Illuminate\Support\Facades\Route;

// Dashboard nuevo al que cae cualquier usuario logueado. La navbar de este
// panel (layouts.panel) cambia según el rol; ver ese archivo para el detalle.
Route::middleware(['auth:usuarios'])->group(function () {

    Route::get('bolsadetrabajo/panel', [PanelUsuarioController::class, 'index'])
        ->name('bolsadetrabajo.panel');

    // "Mis materias" para el alumno (lectura de notas + condición).
    Route::get('bolsadetrabajo/alumno/materias', [AlumnoMateriasController::class, 'index'])
        ->name('bolsadetrabajo.alumno.materias.index');

    Route::get('bolsadetrabajo/alumno/materias/{materia}', [AlumnoMateriasController::class, 'show'])
        ->name('bolsadetrabajo.alumno.materias.show');

    Route::get('bolsadetrabajo/materias/{materia}/recursos/{recurso}', [MateriaContenidoController::class, 'descargar'])
        ->name('bolsadetrabajo.materias.recursos.descargar');

    // "Mi asistencia" del alumno: de solo lectura, la carga el profesor
    // (ver routes/profesor_asistencia.php). El profesor usa sus propias
    // rutas (bolsadetrabajo.profesor.asistencia.*), ver ese archivo.
    Route::get('bolsadetrabajo/asistencia', [AlumnoAsistenciaController::class, 'index'])
        ->name('bolsadetrabajo.asistencia.index');

    // Escaneo del QR que proyecta el profesor en clase. Va con
    // auth:usuarios como el resto de este grupo; si el alumno no está
    // logueado, el controlador lo manda a loguearse.
    Route::get('bolsadetrabajo/asistencia/escaner', [AlumnoAsistenciaController::class, 'escaner'])
        ->name('bolsadetrabajo.asistencia.escaner');

    Route::get('bolsadetrabajo/asistencia/escanear/{token}', [AlumnoAsistenciaController::class, 'escanear'])
        ->name('bolsadetrabajo.asistencia.escanear');

    // "Mesas" del alumno: bloque nuevo y exclusivo, dentro del panel, desde
    // donde se inscribe (ya no se inscribe desde /mesasfront).
    Route::get('bolsadetrabajo/alumno/mesas', [AlumnoMesasController::class, 'index'])
        ->name('bolsadetrabajo.alumno.mesas.index');
});
