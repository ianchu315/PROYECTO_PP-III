<?php

use App\Http\Controllers\Profesor\MesaInscriptosController;
use Illuminate\Support\Facades\Route;

// Panel de "alumnos inscriptos a mesas finales", exclusivo para profesores,
// administradores y superadministradores. El control de rol se hace dentro
// del controlador (MesaInscriptosController::profesorActual) porque incluye
// también a "administrador", cosa que el middleware "rol:profesor" no
// contempla.
Route::middleware(['auth:usuarios'])
    ->prefix('bolsadetrabajo/profesor')
    ->name('bolsadetrabajo.profesor.')
    ->group(function () {
        Route::get('mesas', [MesaInscriptosController::class, 'index'])
            ->name('mesas.index');

        Route::get('mesas/{mesa}', [MesaInscriptosController::class, 'show'])
            ->name('mesas.show');
    });
