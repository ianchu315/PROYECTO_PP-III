<?php

use App\Http\Controllers\PresidenteController;
use App\Models\Materia;


/*
|--------------------------------------------------------------------------
|                                Juanse
|--------------------------------------------------------------------------
*/

//Rutas creadas para las interacciones del MODULO de "Presidentes", en la cual "Admin" posee acceso
Route::group(['middleware' => ['admin']], function () {
    Route::resource('presidentes', PresidenteController::class);
    //Extra para ver las relaciones
    Route::get('titulares',[PresidenteController::class,'titulares'])->name('titulares');
});