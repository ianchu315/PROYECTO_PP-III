<?php

use App\Http\Controllers\ComisionController;
use App\Http\Controllers\AnioController;

/*
|--------------------------------------------------------------------------
| Comisión y Año                                   | Aylén, Sofía, Ulises
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['director']], function () {
    Route::resource('comision', ComisionController::class);
    Route::resource('anio', AnioController::class);
});
