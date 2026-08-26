<?php

use App\Http\Controllers\CarreraController;
use App\Http\Controllers\CarrerasedeController;
use App\Models\Carrera;
use App\Models\Materia;

/*
|--------------------------------------------------------------------------
| Carrera                                                  | Iván, Martín
|--------------------------------------------------------------------------
*/

Route::get('/carreras', function () {
    $carreras = \App\Models\Carrera::all();

    // 🔹 ID(s) de las resoluciones nuevas — ajustá según tus datos reales
    $resolucionesNuevas = [10, 1, 6, 8, 2, 3, 4, 5];

    // 🔹 Traer solo materias con esas resoluciones
    $materias = \App\Models\Materia::whereIn('resolucion_id', $resolucionesNuevas)
        ->orderBy('anio_id')
        ->orderBy('orden')
        ->get();

    return view('frontend.carreras.index', compact('carreras', 'materias'));
})->name('carreras');

Route::group(['middleware' => ['director']], function () {
    Route::resource('carrera', CarreraController::class);
});

Route::get('/carreras/{carrera}/mesas/pdf', [CarreraController::class, 'mesasPdf'])->name('carrera.mesas.pdf');

Route::get('foto_carrera/{carrera}/{id}/{filename}', function ($carrera,$id,$filename) {
         $path = storage_path('app/public/' . $carrera . "/". $id . "/" . $filename);
         //dd( $path );
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    });