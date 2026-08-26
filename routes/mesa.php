<?php

use App\Http\Controllers\MesaController;
use App\Models\Materia;


/*
|--------------------------------------------------------------------------
|                                Juanse
|--------------------------------------------------------------------------
*/
Route::delete('/mesas/eliminar-todas', [MesaController::class, 'eliminarTodas'])->name('mesas.eliminarTodas');


//Rutas creadas para las interacciones del MODULO de "mesas", en la cual "Admin" posee acceso
Route::group(['middleware' => ['director']], function () {
    Route::resource('mesas', MesaController::class);

Route::post('/mesas/asignar-salones', [MesaController::class, 'asignarSalones'])
    ->name('mesas.asignarSalones');

    Route::resource('mesas', MesaController::class);
    Route::post('/mesas/generar-con-rango', [MesaController::class, 'generarConRango'])->name('mesas.generarConRango');
});


