<?php
use App\Http\Controllers\CategoriaController;

Route::resource('categoria', CategoriaController::class)->parameters([
    'categoria' => 'categoria'  // Esto evita que Laravel use "categorium"
]);

Route::delete('/categoria/{categoria}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');
