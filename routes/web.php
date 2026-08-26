<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MesaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//-----   IMPORTANTE!!  -----   IMPORTANTE!!  -----   IMPORTANTE!!   -----//
//  NO modificar web.php, hacer los cambios en los archivos de cada equipo
//  que están en la carpeta routes.
//  Cada archivo tiene el nombre de los responsables.
//                       Gracias! 
//                                              Gisela
//------------------------------------------------------------------------//

// composer require phpoffice/phpspreadsheet
// composer require mpdf/mpdf
// composer require barryvdh/laravel-dompdf
// php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
//composer require setasign/fpdf

Route::middleware('auth') // guard por defecto: web
    ->get('/perfil', [UserController::class, 'show']);

// Route::group(['middleware' => ['admin']], function () {
    //Noticias-> Gisela
    Route::group([], __DIR__ . '/blog.php');

    //Inicio-> Iván, Martín
    Route::group([], __DIR__ . '/inicio.php');

    //Carrera-> Iván, Martín
    Route::group([], __DIR__ . '/carrera.php');

    //Materia-> Iván, Martín
    Route::group([], __DIR__ . '/materia.php');

    //Programa-> Alejandro, Brian
    Route::group([], __DIR__ . '/programa.php');

    //Horario y Módulo horario-> Aylén, Sofía, Ulises
    Route::group([], __DIR__ . '/horario.php');

    //Comision y Año-> Aylén, Sofía, Ulises
    Route::group([], __DIR__ . '/comision.php');

    //Profesor-> Aylén, Sofía, Ulises
    Route::group([], __DIR__ . '/profesor.php');

    //Historia y Objetivo-> Alejo, Esteban
    Route::group([], __DIR__ . '/historia.php');

    //Contacto y Sede-> Alejo, Esteban
    Route::group([], __DIR__ . '/contacto.php');

    //Inscripciones
    Route::group([], __DIR__ . '/turnos.php');

    Route::group([], __DIR__ . '/cupos.php');

    Route::group([], __DIR__ . '/inscripciones.php');

    Route::group([], __DIR__ . '/alumnos.php');

    Route::group([], __DIR__ . '/excel.php');

    Route::group([], __DIR__ . '/residuos.php');

    //Presidente
    //Linkea las rutas presidente.php
    Route::group([], __DIR__ . '/presidentes.php');

    //Mesa
    //Linkea las rutas mesa.php
    Route::group([], __DIR__ . '/mesa.php');

    //Rutas para el front de mesas
    Route::group([], __DIR__ . '/mesafrontend.php');
    Route::group([], __DIR__ . '/mesa_frontend_inscripciones.php');

    //Categoria
    Route::group([], __DIR__ . '/categoria.php');

    //Correlativa
    Route::group([], __DIR__ . '/correlativa.php');

    //salon
    Route::group([], __DIR__ . '/salon.php');

    Route::get('/backend/inicio', function () {
        return view('backend.inicio.index');
    })->name('backend.inicio.index');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    Route::post('mesas/toggle-visibilidad', [MesaController::class, 'toggleVisibilidad'])
        ->name('mesas.toggleVisibilidad');

    Route::group([], __DIR__ . '/bolsa_trabajo.php');

    Route::group([], __DIR__ . '/profesor_notas.php');

    Route::group([], __DIR__ . '/profesor_mesas.php');

    Route::group([], __DIR__ . '/panel_usuario.php');
// });


Auth::routes();
