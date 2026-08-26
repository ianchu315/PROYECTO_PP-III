<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\MesaPublicaController;

Route::get('/mesasfront', [MesaPublicaController::class, 'index'])->name('frontend.mesas.index');

// Atajo: /mesasfront/superUsuario abre la misma página de mesas, pero con
// el popup de la lista de espera de usuarios pendientes de aprobación.
Route::middleware('auth:usuarios')
    ->get('/mesasfront/superUsuario', [MesaPublicaController::class, 'index'])
    ->name('frontend.mesas.lista_espera');
