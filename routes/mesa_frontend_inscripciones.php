<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\MesaInscripcionController;
use App\Http\Controllers\Frontend\MesaPublicaController;

Route::middleware('auth:usuarios')->group(function () {
    Route::get('/mesasfront/{mesa}/confirmar-inscripcion', [MesaInscripcionController::class, 'confirmar'])
        ->name('frontend.mesas.inscribir.confirmar');

    Route::post('/mesasfront/{mesa}/confirmar-inscripcion', [MesaInscripcionController::class, 'store'])
        ->name('frontend.mesas.inscribir.store');
    
});
