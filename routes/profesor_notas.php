<?php

use App\Http\Controllers\Profesor\NotasProfesorController;
use App\Http\Controllers\MateriaContenidoController;
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

        Route::post('materias/{materia}/unidades', [MateriaContenidoController::class, 'crearUnidad'])
            ->name('materias.unidades.crear');

        Route::post('materias/{materia}/unidades/{unidad}/recursos', [MateriaContenidoController::class, 'agregarRecursos'])
            ->name('materias.unidades.recursos.agregar');

        Route::delete('materias/{materia}/unidades/{unidad}', [MateriaContenidoController::class, 'eliminarUnidad'])
            ->name('materias.unidades.eliminar');

        Route::delete('materias/{materia}/unidades/{unidad}/recursos/{recurso}', [MateriaContenidoController::class, 'eliminarRecurso'])
            ->name('materias.recursos.eliminar');

        Route::post('materias/{materia}/alumnos', [NotasProfesorController::class, 'agregarAlumno'])
            ->name('materias.agregarAlumno');

        Route::delete('materias/{materia}/alumnos/{usuario}', [NotasProfesorController::class, 'quitarAlumno'])
            ->name('materias.quitarAlumno');

        Route::post('materias/{materia}/notas', [NotasProfesorController::class, 'guardarNota'])
            ->name('materias.guardarNota');

        Route::post('materias/{materia}/notas/promediada', [NotasProfesorController::class, 'guardarNotaPromediada'])
            ->name('materias.guardarNotaPromediada');

        Route::post('materias/{materia}/notas/guardar', [NotasProfesorController::class, 'guardarNotas'])
            ->name('materias.guardarNotas');

        Route::post('materias/{materia}/notas/extra', [NotasProfesorController::class, 'guardarNotaExtra'])
            ->name('materias.guardarNotaExtra');
    });
