<?php

use App\Http\Controllers\CorrelativaController;

Route::group(['middleware' => ['director']], function () {
    Route::resource('correlativa', CorrelativaController::class)->names('backend.correlativa');
});
Route::get('/correlativas/materias', [App\Http\Controllers\CorrelativaController::class, 'getMaterias'])->name('correlativas.materias');
Route::get('/correlativas/correlativas', [App\Http\Controllers\CorrelativaController::class, 'getCorrelativas'])->name('correlativas.correlativas');
Route::get('/api/materias', [CorrelativaController::class, 'byCarreraAndAnio'])->name('api.materias');
Route::get('/api/correlativas', [CorrelativaController::class, 'correlativas'])->name('api.correlativas');