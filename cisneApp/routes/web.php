<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;

/* ==========================
   RUTAS DEL SITIO PÚBLICO
   ========================== */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profesionales', [HomeController::class, 'index'])->name('profesionales');
Route::get('/novedades', [NoticiaController::class, 'index'])->name('novedades');

Route::get("/noticias", [NoticiaController::class, "showNoticias"]);
Route::get("/noticias/{id}", [NoticiaController::class, "showNoticia"]);

Route::get('/noticias/buscadorTitulo', [NoticiaController::class, 'filterNoticiasByTittle']);
Route::get('/noticias/buscadorCategoria', [NoticiaController::class, 'filterNoticiasByCategory']);
Route::get('/noticias/buscadorFecha', [NoticiaController::class, 'filterNoticiasByDate']);

/* ==========================
   LOGIN
   ========================== */

Route::post('/login',  [LoginController::class, 'login']);
Route::get('/showlogin', [HomeController::class, 'showlogin'])->name("showlogin");
Route::post('/logout', [LoginController::class, 'logout']);

Auth::routes();

/* ==========================
   PANEL ADMIN (solo admin)
   ========================== */
// RUTAS DEL PANEL ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // 🟦 PANEL
        Route::get('/panel', [AdminController::class, 'adminPanel'])->name('panel');

    // Profesionales
    Route::get('/profesionales', [AdminController::class, 'profesionales'])->name('profesionales');
    Route::get('/profesionales/crear', [ProfesionalController::class, 'create'])->name('profesionales.create');
    Route::post('/profesionales', [AdminController::class, 'crearProfesional'])->name('profesionales.store');

    Route::get('/profesionales/{id}/editar', [AdminController::class, 'showFormEditarProfesional'])->name('profesionales.edit');
    Route::put('/profesionales/{id}', [ProfesionalController::class, 'updateProfesional'])->name('profesionales.update');

    Route::post('/profesionales/{id}/imagen', [AdminController::class, 'editarImagenProfesional'])->name('profesionales.editarImagen');
    Route::delete('/profesionales/{id}', [AdminController::class, 'eliminarProfesional'])->name('profesionales.destroy');

    // 🟧 NOTICIAS
    Route::get('/noticias', [AdminController::class, 'mostrarNoticias'])->name('noticias');
        Route::get('/noticias/crear', [AdminController::class, 'showFormCreateNoticia'])->name('noticias.create');
        Route::post('/noticias', [AdminController::class, 'createNoticia'])->name('noticias.store');

        Route::get('/noticias/{id}/editar', [AdminController::class, 'showFormEditNoticia'])->name('noticias.edit');
        Route::put('/noticias/{id}', [AdminController::class, 'editNoticia'])->name('noticias.update');
        Route::post('/noticias/{id}/imagen', [AdminController::class, 'editarImagenNoticia'])->name('noticias.editarImagen');
        Route::delete('/noticias/{id}', [AdminController::class, 'deleteNoticia'])->name('noticias.destroy');
    });
/* ==========================
   FORMULARIO DE CONTACTO
   ========================== */

Route::get('/formar/parte', [FormController::class, "contacto"]);
Route::post('/formulario/enviar', [FormController::class, 'enviar'])->name('formulario.enviar');
