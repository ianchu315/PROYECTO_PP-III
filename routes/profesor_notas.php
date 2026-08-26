<?php

use App\Http\Controllers\Profesor\NotasProfesorController;
use Illuminate\Support\Facades\Route;

// Panel de notas exclusivo para profesores, administradores y
// superadministradores. Guard "usuarios"; el control de rol fino se hace
// dentro del controlador (incluye "administrador", cosa que el middleware
// "rol:profesor" no contempla).
Route::middleware(['auth:usuarios'])
    ->prefix('bolsadetrabajo/profesor')
    ->name('bolsadetrabajo.profesor.')
    ->group(function () {
        Route::get('materias', [NotasProfesorController::class, 'index'])
            ->name('materias.index');

        Route::get('materias/{materia}', [NotasProfesorController::class, 'show'])
            ->name('materias.show');

        Route::post('materias/{materia}/configurar-notas', [NotasProfesorController::class, 'configurarCantidadNotas'])
            ->name('materias.configurarNotas');

        Route::post('materias/{materia}/alumnos', [NotasProfesorController::class, 'agregarAlumno'])
            ->name('materias.agregarAlumno');

        Route::delete('materias/{materia}/alumnos/{usuario}', [NotasProfesorController::class, 'quitarAlumno'])
            ->name('materias.quitarAlumno');

        Route::post('materias/{materia}/notas', [NotasProfesorController::class, 'guardarNota'])
            ->name('materias.guardarNota');

        Route::post('materias/{materia}/notas/extra', [NotasProfesorController::class, 'guardarNotaExtra'])
            ->name('materias.guardarNotaExtra');
    });
