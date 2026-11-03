<?php

use App\Http\Controllers\Preceptor\PreceptorController;
use Illuminate\Support\Facades\Route;

// Los preceptores gestionan alumnos de sus carreras asignadas. Administrador
// y superadministrador conservan alcance institucional. Guard "usuarios";
// el control de rol fino se hace dentro del controlador.
Route::middleware(['auth:usuarios'])
    ->prefix('bolsadetrabajo/preceptor')
    ->name('bolsadetrabajo.preceptor.')
    ->group(function () {
        Route::get('carreras', [PreceptorController::class, 'carreras'])
            ->name('carreras');

        Route::get('alumnos', [PreceptorController::class, 'alumnos'])
            ->name('alumnos.index');

        Route::get('alumnos/{usuario}', [PreceptorController::class, 'show'])
            ->name('alumnos.show');

        Route::post('alumnos/{usuario}/carrera', [PreceptorController::class, 'asignarCarrera'])
            ->name('alumnos.asignarCarrera');

        Route::post('alumnos/{usuario}/materias', [PreceptorController::class, 'asignarMateria'])
            ->name('alumnos.asignarMateria');

        Route::delete('alumnos/{usuario}/materias/{materia}', [PreceptorController::class, 'quitarMateria'])
            ->name('alumnos.quitarMateria');

        // Las notas las carga solo el profesor a cargo de la materia
        // (ver routes/profesor_notas.php). El preceptor solo las consulta.
    });
