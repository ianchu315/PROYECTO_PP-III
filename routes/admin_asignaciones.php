<?php

use App\Http\Controllers\AdminAsignacionesController;
use Illuminate\Support\Facades\Route;

// Exclusivo superadministrador (verificado dentro del controlador). Vive
// dentro del panel nuevo: ver panel/index.blade.php.
Route::middleware(['auth:usuarios'])
    ->prefix('bolsadetrabajo/admin/profesores')
    ->name('bolsadetrabajo.admin.profesores.')
    ->group(function () {
        Route::post('{profesor}/carrera', [AdminAsignacionesController::class, 'asignarCarrera'])
            ->name('carrera');

        Route::post('{profesor}/materias', [AdminAsignacionesController::class, 'asignarMaterias'])
            ->name('materias');

        Route::post('preceptores/{preceptor}/carreras', [AdminAsignacionesController::class, 'asignarCarrerasPreceptor'])
            ->name('preceptores.carreras');
    });

// Dar de baja / reactivar (aplica a cualquier usuario, no solo profesores).
Route::middleware(['auth:usuarios'])
    ->prefix('bolsadetrabajo/admin/usuarios')
    ->name('bolsadetrabajo.admin.usuarios.')
    ->group(function () {
        Route::post('{usuario}/carreras', [AdminAsignacionesController::class, 'asignarCarrerasUsuario'])
            ->name('carreras');

        Route::post('{usuario}/dar-de-baja', [AdminAsignacionesController::class, 'darDeBaja'])
            ->name('dar-de-baja');

        Route::post('{usuario}/reactivar', [AdminAsignacionesController::class, 'reactivar'])
            ->name('reactivar');
    });
