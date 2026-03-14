<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstitucionController;

/* ==========================
   RUTAS DEL SITIO PÚBLICO
   ========================== */

Route::get('/', [HomeController::class, 'index'])->name('home');
/*Route::get('/profesionales', [HomeController::class, 'index'])->name('profesionales');
Route::get('/instituciones', [HomeController::class, 'index'])->name('instituciones');*/
Route::get('/novedades', [NoticiaController::class, 'index3'])->name('novedades');


Route::get("/noticias/{id}", [NoticiaController::class, "showNoticia"]);



Route::get('/noticias/buscadorTitulo', [NoticiaController::class, 'filterNoticiasByTittle']);
Route::get('/noticias/buscadorCategoria', [NoticiaController::class, 'filterNoticiasByCategory']);
Route::get('/noticias/buscadorFecha', [NoticiaController::class, 'filterNoticiasByDate']);

/* ==========================
   FORMULARIO DE CONTACTO
   ========================== */

Route::get('/formar/parte', [FormController::class, "contacto"]);
Route::post('/contacto', [FormController::class, 'enviar'])->name('contacto.enviar');

/* ==========================
   LOGIN
   ========================== */

Route::get('/showlogin', [HomeController::class, 'showloginForm']);
Route::post('/login',  [LoginController::class, 'login'])->name("login");
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



/* ==========================
   PANEL ADMIN (solo admin)
   ========================== */
// RUTAS DEL PANEL ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // PANEL
        Route::get('/panel', [AdminController::class, 'adminPanel'])->name('panel');
    // Endpoint de estadísticas (AJAX)
    Route::get('/panel/estadisticas', [AdminController::class, 'estadisticasPanel'])
        ->name('panel.estadisticas');
        //DESCARGAR EXCEL
Route::get('/panel/descargas', [AdminController::class, 'descargarContactos'])
     ->name('panel.descargas');

    // PROFESIONALES
    Route::get('/profesionales', [AdminController::class, 'profesionales'])->name('profesionales');
    Route::get('/profesionales/crear', [ProfesionalController::class, 'create'])->name('profesionales.create');
    Route::post('/profesionales', [AdminController::class, 'store'])->name('profesionales.store');

    Route::get('/profesionales/{id}/editar', [ProfesionalController::class, 'edit'])->name('profesionales.edit');
    Route::put('/profesionales/{id}', [AdminController::class, 'updateProfesional'])->name('profesionales.update');

   //Route::post('/profesionales/{id}/imagen', [AdminController::class, 'editarImagenProfesional'])->name('profesionales.editarImagen');
    Route::delete('/profesionales/{id}', [AdminController::class, 'eliminarProfesional'])->name('profesionales.destroy');


    //INSTITUCIONES

    Route::get('/instituciones', [AdminController::class, 'instituciones'])->name('instituciones');
    Route::get('/instituciones/crear', [AdminController::class,'createHogar'])->name('instituciones.create');

    Route::get('/instituciones/{id}/editar', [AdminController::class, 'editShowHogar'])->name('instituciones.edit');
    Route::post('/instituciones', [AdminController::class, 'storeHogar'])->name('instituciones.storeHogar');
    Route::put('/instituciones/{id}', [AdminController::class, 'updateHogar'])->name('instituciones.update');

   // Route::post('/instituciones/{id}/imagen', [InstitucionController::class, 'editarImagenProfesional'])->name('profesionales.editarImagen');
    Route::delete('/instituciones/{id}', [AdminController::class, 'eliminarHogar'])->name('instituciones.destroy');


    // NOTICIAS
    Route::get('/noticias', [AdminController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/crear', [AdminController::class, 'showFormCreateNoticia'])->name('noticias.create');
    Route::post('/noticias', [AdminController::class, 'storeNoticia'])->name('noticias.storeNoticia');

    Route::get('/noticias/{id}/editar', [AdminController::class, 'showFormEditNoticia'])->name('noticias.edit');
    Route::put('/noticias/{id}', [AdminController::class, 'editNoticia'])->name('noticias.update');
    Route::post('/noticias/{id}/imagen', [AdminController::class, 'editarImagenNoticia'])->name('noticias.editarImagen');
    Route::delete('/noticias/{id}', [AdminController::class, 'deleteNoticia'])->name('noticias.destroy');
    });
