<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\GuardarController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\ExperienciaController;
use App\Http\Controllers\ExperienciaLaboralController;
use App\Http\Controllers\OfertaGuardadaController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\AptitudController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\AdminOfertasController;
use App\Http\Controllers\AdminUsuariosController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ComunicacionesController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\InicioSesionController;
use App\Http\Controllers\RecuperarContraseñaController;
use App\Http\Controllers\Frontend\MesaPublicaController;
use App\Http\Controllers\AdminAprobacionController;
use App\Http\Controllers\CalificacionController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


// ✅ Ruta principal
Route::get('/bolsadetrabajo/home', [HomeController::class, 'index'])->name('bolsadetrabajo.home')->middleware('auth:usuarios');


// ✅ Perfil de usuario
Route::middleware('auth:usuarios')->group(function () {
    Route::get('bolsadetrabajo/perfil', [PerfilController::class, 'index'])->name('bolsadetrabajo.perfil');
    Route::get('bolsadetrabajo/perfil/editar', [PerfilController::class, 'editar'])->name('bolsadetrabajo.perfil.editar');
    Route::post('bolsadetrabajo/perfil/actualizar', [PerfilController::class, 'actualizar'])->name('bolsadetrabajo.perfil.actualizar');
    Route::post('bolsadetrabajo/perfil/foto-guardar', [PerfilController::class, 'fotoGuardar'])->name('bolsadetrabajo.perfil.foto_guardar');
});


// ✅ Búsqueda
Route::get('bolsadetrabajo/busqueda', [BusquedaController::class, 'busqueda'])->name('bolsadetrabajo.busqueda')->middleware('auth:usuarios');


// ✅ Guardar ofertas
Route::get('bolsadetrabajo/guardar', [GuardarController::class, 'index'])->name('bolsadetrabajo.guardar.index')->middleware('auth:usuarios');
Route::post('bolsadetrabajo/guardar-oferta', [OfertaGuardadaController::class, 'store'])->name('bolsadetrabajo.guardar.oferta.store')->middleware('auth:usuarios');
Route::delete('bolsadetrabajo/guardar-oferta/{oferta}', [OfertaGuardadaController::class, 'destroy'])->name('bolsadetrabajo.guardar.oferta.destroy')->middleware('auth:usuarios');


// ✅ Experiencias laborales
Route::get('bolsadetrabajo/experiencias/crear', [ExperienciaLaboralController::class, 'create'])->name('bolsadetrabajo.experiencias.create')->middleware('auth:usuarios');
Route::post('bolsadetrabajo/experiencias', [ExperienciaLaboralController::class, 'store'])->name('bolsadetrabajo.experiencias.store')->middleware('auth:usuarios');
Route::put('bolsadetrabajo/experiencias/{id}', [ExperienciaController::class, 'update'])->name('bolsadetrabajo.experiencias.update')->middleware('auth:usuarios');
Route::delete('bolsadetrabajo/experiencias/{id}', [ExperienciaController::class, 'destroy'])->name('bolsadetrabajo.experiencias.destroy')->middleware('auth:usuarios');


// ✅ Estudios
Route::get('bolsadetrabajo/estudios/crear', [EstudioController::class, 'create'])->name('bolsadetrabajo.estudios.create')->middleware('auth:usuarios');
Route::post('bolsadetrabajo/estudios', [EstudioController::class, 'store'])->name('bolsadetrabajo.estudios.store')->middleware('auth:usuarios');
Route::put('bolsadetrabajo/estudios/{id}', [EstudioController::class, 'update'])->name('bolsadetrabajo.estudios.update')->middleware('auth:usuarios');
Route::delete('bolsadetrabajo/estudios/{id}', [EstudioController::class, 'destroy'])->name('bolsadetrabajo.estudios.destroy')->middleware('auth:usuarios');


// ✅ Cursos
Route::get('bolsadetrabajo/cursos/crear', [CursoController::class, 'create'])->name('bolsadetrabajo.cursos.create')->middleware('auth:usuarios');
Route::post('bolsadetrabajo/cursos', [CursoController::class, 'store'])->name('bolsadetrabajo.cursos.store')->middleware('auth:usuarios');
Route::put('bolsadetrabajo/cursos/{id}', [CursoController::class, 'update'])->name('bolsadetrabajo.cursos.update')->middleware('auth:usuarios');
Route::delete('bolsadetrabajo/cursos/{id}', [CursoController::class, 'destroy'])->name('bolsadetrabajo.cursos.destroy')->middleware('auth:usuarios');


// ✅ Postulaciones
Route::get('bolsadetrabajo/postulaciones/crear', [PostulacionController::class, 'create'])->name('bolsadetrabajo.postulaciones.create')->middleware('auth:usuarios');
Route::post('bolsadetrabajo/postulaciones', [PostulacionController::class, 'store'])->name('bolsadetrabajo.postulaciones.store')->middleware('auth:usuarios');
Route::delete('bolsadetrabajo/postulaciones/{id}/cancelar', [PostulacionController::class, 'cancelar'])->name('bolsadetrabajo.postulaciones.cancelar')->middleware('auth:usuarios');
Route::post('bolsadetrabajo/postulaciones/export', [AdminOfertasController::class, 'exportPostulaciones'])->name('bolsadetrabajo.postulaciones.export')->middleware('auth:usuarios');


// ✅ Aptitudes
Route::get('bolsadetrabajo/aptitudes/crear', [AptitudController::class, 'create'])->name('bolsadetrabajo.aptitudes.create')->middleware('auth:usuarios');
Route::post('bolsadetrabajo/aptitudes', [AptitudController::class, 'store'])->name('bolsadetrabajo.aptitudes.store')->middleware('auth:usuarios');
Route::put('bolsadetrabajo/aptitudes/{id}', [AptitudController::class, 'update'])->name('bolsadetrabajo.aptitudes.update')->middleware('auth:usuarios');
Route::delete('bolsadetrabajo/aptitudes/{id}', [AptitudController::class, 'destroy'])->name('bolsadetrabajo.aptitudes.destroy')->middleware('auth:usuarios');


// ✅ Idiomas
Route::get('bolsadetrabajo/idiomas/crear', [IdiomaController::class, 'create'])->name('bolsadetrabajo.idiomas.create')->middleware('auth:usuarios');
Route::post('bolsadetrabajo/idiomas', [IdiomaController::class, 'store'])->name('bolsadetrabajo.idiomas.store')->middleware('auth:usuarios');
Route::put('bolsadetrabajo/idiomas/{id}', [IdiomaController::class, 'update'])->name('bolsadetrabajo.idiomas.update')->middleware('auth:usuarios');
Route::delete('bolsadetrabajo/idiomas/{id}', [IdiomaController::class, 'destroy'])->name('bolsadetrabajo.idiomas.destroy')->middleware('auth:usuarios');


// ✅ CV
Route::post('bolsadetrabajo/cv/subir', [CvController::class, 'subir'])->name('bolsadetrabajo.cv.subir')->middleware('auth:usuarios');
Route::delete('bolsadetrabajo/cv/{id}/eliminar', [CvController::class, 'eliminar'])->name('bolsadetrabajo.cv.eliminar')->middleware('auth:usuarios');


// ✅ Dashboard
Route::get('bolsadetrabajo/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('bolsadetrabajo.dashboard')->middleware(['auth:usuarios', 'rol:administrador']);


// ✅ Administración de ofertas
Route::get('bolsadetrabajo/ofertas', [AdminOfertasController::class, 'index'])->name('bolsadetrabajo.ofertas')->middleware(['auth:usuarios', 'rol:administrador']);
Route::get('bolsadetrabajo/ofertas/crear', [AdminOfertasController::class, 'crear'])->name('bolsadetrabajo.admin.ofertas.crear')->middleware(['auth:usuarios', 'rol:administrador']);
Route::post('bolsadetrabajo/ofertas', [AdminOfertasController::class, 'guardar'])->name('bolsadetrabajo.admin.ofertas.guardar')->middleware(['auth:usuarios', 'rol:administrador']);
Route::get('bolsadetrabajo/ofertas/{id}/editar', [AdminOfertasController::class, 'edit'])->name('bolsadetrabajo.ofertas.edit')->middleware(['auth:usuarios', 'rol:administrador']);
Route::put('bolsadetrabajo/ofertas/{id}', [AdminOfertasController::class, 'update'])->name('bolsadetrabajo.ofertas.update')->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/ofertas/{id}', [AdminOfertasController::class, 'destroy'])->name('bolsadetrabajo.ofertas.destroy')->middleware(['auth:usuarios', 'rol:administrador']);
Route::get('bolsadetrabajo/ofertas/{id}/postulaciones', [AdminOfertasController::class, 'postulaciones'])->name('bolsadetrabajo.ofertas.postulaciones')->middleware(['auth:usuarios', 'rol:administrador']);
Route::post('bolsadetrabajo/postulaciones/{id}/cancelar', [PostulacionController::class, 'cancelar'])
    ->name('bolsadetrabajo.postulaciones.cancelar')
    ->middleware(['auth:usuarios', 'rol:administrador']);


// ✅ Administración de beneficios, palabras y preguntas
Route::delete('bolsadetrabajo/requisito/{id}', [AdminOfertasController::class, 'destroyRequisito'])
    ->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/beneficio/{id}', [AdminOfertasController::class, 'destroyBeneficio'])->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/palabra/{id}', [AdminOfertasController::class, 'destroyPalabra'])->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/pregunta/{id}', [AdminOfertasController::class, 'destroyPregunta'])->middleware(['auth:usuarios', 'rol:administrador']);


// ✅ Administración de usuarios
Route::get('bolsadetrabajo/usuarios', [AdminUsuariosController::class, 'index'])->name('bolsadetrabajo.usuarios')->middleware(['auth:usuarios', 'rol:administrador']);
Route::get('bolsadetrabajo/usuarios/create', [AdminUsuariosController::class, 'create'])->name('bolsadetrabajo.usuarios.create')->middleware(['auth:usuarios', 'rol:administrador']);
Route::post('bolsadetrabajo/usuarios', [AdminUsuariosController::class, 'store'])->name('bolsadetrabajo.usuarios.store')->middleware(['auth:usuarios', 'rol:administrador']);
Route::get('bolsadetrabajo/usuarios/{id}/editar', [AdminUsuariosController::class, 'edit'])->name('bolsadetrabajo.usuarios.edit')->middleware(['auth:usuarios', 'rol:administrador']);
Route::put('bolsadetrabajo/usuarios/{id}', [AdminUsuariosController::class, 'update'])->name('bolsadetrabajo.usuarios.update')->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/usuarios/{id}', [AdminUsuariosController::class, 'destroy'])->name('bolsadetrabajo.usuarios.destroy')->middleware(['auth:usuarios', 'rol:administrador']);


// ✅ Configuración
Route::get('bolsadetrabajo/configuracion', [ConfiguracionController::class, 'index'])->name('bolsadetrabajo.configuracion.index')->middleware(['auth:usuarios', 'rol:administrador']);
Route::post('bolsadetrabajo/configuracion', [ConfiguracionController::class, 'store'])->name('bolsadetrabajo.configuracion.store')->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/configuracion/carrera/{id}', [ConfiguracionController::class, 'destroyCarrera'])->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/configuracion/idioma/{id}', [ConfiguracionController::class, 'destroyIdioma'])->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/configuracion/habilidad/{id}', [ConfiguracionController::class, 'destroyHabilidad'])->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/configuracion/modalidad/{id}', [ConfiguracionController::class, 'destroyModalidad'])->middleware(['auth:usuarios', 'rol:administrador']);
Route::delete('bolsadetrabajo/configuracion/horario/{id}', [ConfiguracionController::class, 'destroyHorario'])->middleware(['auth:usuarios', 'rol:administrador']);


// ✅ Comunicaciones
Route::get('bolsadetrabajo/comunicaciones', [ComunicacionesController::class, 'index'])->name('bolsadetrabajo.comunicaciones')->middleware(['auth:usuarios', 'rol:administrador']);
Route::get('bolsadetrabajo/comunicaciones/buscar', [ComunicacionesController::class, 'buscarAlumnos'])->name('bolsadetrabajo.comunicaciones.buscar')->middleware(['auth:usuarios', 'rol:administrador']);
Route::get('bolsadetrabajo/comunicaciones/alumnos-carrera/{id}', [ComunicacionesController::class, 'alumnosPorCarrera'])->name('bolsadetrabajo.comunicaciones.alumnosPorCarrera')->middleware(['auth:usuarios', 'rol:administrador']);
Route::post('bolsadetrabajo/comunicaciones/enviar', [ComunicacionesController::class, 'enviar'])->name('bolsadetrabajo.comunicaciones.enviar')->middleware(['auth:usuarios', 'rol:administrador']);


// ✅ Registro e inicio de sesión
Route::get('bolsadetrabajo/registro', [RegistroController::class, 'index'])->name('bolsadetrabajo.registro');
Route::post('bolsadetrabajo/registro', [RegistroController::class, 'store'])->name('bolsadetrabajo.registro.store');

Route::get('bolsadetrabajo/inicio', [InicioSesionController::class, 'index'])->name('bolsadetrabajo.iniciar-sesion');
Route::post('bolsadetrabajo/inicio', [InicioSesionController::class, 'procesar'])->name('bolsadetrabajo.iniciar-sesion.procesar');
Route::post('bolsadetrabajo/logout', [InicioSesionController::class, 'logout'])->name('bolsadetrabajo.logout');

// Mesas integradas en Bolsa de Trabajo (vista protegida)
Route::get('bolsadetrabajo/mesas', [MesaPublicaController::class, 'index'])->name('bolsadetrabajo.mesas')->middleware('auth:usuarios');

// Rutas de notas
Route::middleware(['auth:usuarios', 'rol:profesor'])->group(function () {
    Route::get('bolsadetrabajo/notas', [CalificacionController::class, 'index'])->name('bolsadetrabajo.notas.index');
    Route::get('bolsadetrabajo/notas/crear', [CalificacionController::class, 'create'])->name('bolsadetrabajo.notas.create');
    Route::post('bolsadetrabajo/notas', [CalificacionController::class, 'store'])->name('bolsadetrabajo.notas.store');
    Route::get('bolsadetrabajo/notas/{id}/editar', [CalificacionController::class, 'edit'])->name('bolsadetrabajo.notas.edit');
    Route::put('bolsadetrabajo/notas/{id}', [CalificacionController::class, 'update'])->name('bolsadetrabajo.notas.update');
    Route::delete('bolsadetrabajo/notas/{id}', [CalificacionController::class, 'destroy'])->name('bolsadetrabajo.notas.destroy');
});

Route::get('bolsadetrabajo/mis-notas', [CalificacionController::class, 'myGrades'])->name('bolsadetrabajo.notas.mine')->middleware('auth:usuarios');

// Rutas de aprobación (exclusivas para SuperAdministrador)
Route::middleware(['auth:usuarios', 'rol:superadministrador'])->group(function () {
    Route::get('bolsadetrabajo/admin/aprobacion', [AdminAprobacionController::class, 'index'])->name('admin.aprobacion.index');
    Route::post('bolsadetrabajo/admin/aprobacion/{id}/approve', [AdminAprobacionController::class, 'approve'])->name('admin.aprobacion.approve');
    Route::post('bolsadetrabajo/admin/aprobacion/{id}/reject', [AdminAprobacionController::class, 'reject'])->name('admin.aprobacion.reject');
});

Route::get('cv/{filename}', function ($filename) {
        $path = storage_path('app/public/cv/' . $filename);
        //dd( $path );
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    })->name("download_cv");


// ✅ Recuperar contraseña
Route::get('bolsadetrabajo/recuperar', [RecuperarContraseñaController::class, 'index'])->name('password.request');
Route::post('bolsadetrabajo/recuperar', [RecuperarContraseñaController::class, 'enviarMail'])->name('password.email');
// ✅ Mostrar formulario de cambio de contraseña (desde el link del email)
Route::get('bolsadetrabajo/reset/{token}', [RecuperarContraseñaController::class, 'mostrarFormularioReset'])
    ->name('password.reset');

// ✅ Guardar nueva contraseña
Route::post('bolsadetrabajo/reset', [RecuperarContraseñaController::class, 'resetPassword'])
    ->name('password.update');

    Route::get('perfil/{filename}', function ($filename) {
    $path = storage_path('app/public/usuarios/' . $filename);
    //dd( $path );
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name("perfil_foto");

Route::get('bolsadetrabajo/postulaciones/{oferta}', [AdminOfertasController::class, 'show'])
    ->name('bolsadetrabajo.postulaciones')
    ->middleware(['auth:usuarios', 'rol:administrador']);




    Route::post('/perfil/foto/guardar', [PerfilController::class, 'guardarFoto'])
    ->name('bolsadetrabajo.perfil.foto_guardar');