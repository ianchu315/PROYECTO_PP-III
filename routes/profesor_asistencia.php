<?php

use App\Http\Controllers\Profesor\AsistenciaProfesorController;
use Illuminate\Support\Facades\Route;

// Asistencia: la gestiona únicamente el profesor a cargo de la materia
// (administrador/superadministrador conservan acceso total). Guard
// "usuarios"; el control de rol fino se hace dentro del controlador, igual
// que en profesor_notas.php.
Route::middleware(['auth:usuarios'])
    ->prefix('bolsadetrabajo/profesor/asistencia')
    ->name('bolsadetrabajo.profesor.asistencia.')
    ->group(function () {
        Route::get('/', [AsistenciaProfesorController::class, 'index'])
            ->name('index');

        Route::get('materias/{materia}', [AsistenciaProfesorController::class, 'planilla'])
            ->name('planilla');

        Route::post('materias/{materia}', [AsistenciaProfesorController::class, 'guardarPlanilla'])
            ->name('planilla.guardar');

        Route::get('materias/{materia}/porcentajes', [AsistenciaProfesorController::class, 'porcentajes'])
            ->name('porcentajes');

        Route::get('materias/{materia}/qr', [AsistenciaProfesorController::class, 'qr'])
            ->name('qr');

        Route::post('materias/{materia}/qr', [AsistenciaProfesorController::class, 'generarQr'])
            ->name('qr.generar');

        Route::post('materias/{materia}/qr/alumnos/{usuario}/estado', [AsistenciaProfesorController::class, 'actualizarEstadoQr'])
            ->name('qr.alumno.estado');

        Route::post('materias/{materia}/qr/{codigo}/cerrar', [AsistenciaProfesorController::class, 'cerrarQr'])
            ->name('qr.cerrar');

        Route::get('materias/{materia}/qr/{codigo}/escaneos', [AsistenciaProfesorController::class, 'qrEscaneos'])
            ->name('qr.escaneos');
    });
