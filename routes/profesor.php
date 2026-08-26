<?php

use App\Http\Controllers\ProfesorController;
use App\Models\Profesor;


/*
|--------------------------------------------------------------------------
| Profesor                                         | Aylén, Sofía, Ulises
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['director']], function () {
    Route::resource('profesor', ProfesorController::class);

});

Route::get('/profesores/login', [ProfesorController::class, 'login']);

