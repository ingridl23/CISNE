<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\FormController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Auth;
//ruta de acceso al sitio web

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profesionales', [HomeController::class, 'index'])->name('profesionales');
Route::get('/novedades', [NoticiaController::class, 'index'])->name('novedades');
//Route::get('/noticias/id',[NoticiaController::class, 'showNoticia'])->name('noticia');

//http://cisne.test/cisneApp/public/

Route::get('/noticias/buscadorTitulo', [NoticiaController::class, 'filterNoticiasByTittle']); //Filtro para noticias por titulo
Route::get('/noticias/buscadorCategoria', [NoticiaController::class, 'filterNoticiasByCategory']); //Filtro para noticias por categoria
Route::get('/noticias/buscadorFecha', [NoticiaController::class, 'filterNoticiasByDate']); //Filtro para noticias por fecha


// Admin - panel
Route::get('/admin/panel', [AdminController::class, 'adminPanel'])->name('admin.panel');

// PROFESIONALES
Route::get('/admin/profesionales', [AdminController::class, 'profesionales'])->name('admin.profesionales');
Route::get('/admin/profesionales/crear', [AdminController::class, 'showFormCrearProfesional'])->name('profesionales.create');
Route::post('/admin/profesionales', [AdminController::class, 'crearProfesional'])->name('profesionales.store');
Route::get('/admin/profesionales/{id}/editar', [AdminController::class, 'showFormEditarProfesional'])->name('profesionales.edit');
Route::delete('/admin/profesionales/{id}', [AdminController::class, 'eliminarProfesional'])->name('profesionales.destroy');
// Si necesitás endpoint para subir/editar sólo imagen:
Route::post('/admin/profesionales/{id}/imagen', [AdminController::class, 'editarImagenProfesional'])->name('profesionales.editarImagen');

//RUTAS NOTICIAS ADMIN


// NOTICIAS
Route::get('/admin/noticias', [AdminController::class, 'mostrarNoticias'] ?? [AdminController::class, 'index'])->name('admin.noticias'); // si no tenés index, podés reutilizar la vista
Route::get('/admin/noticias/crear', [AdminController::class, 'showFormCreateNoticia'])->name('noticias.create');
Route::post('/admin/noticias', [AdminController::class, 'createNoticia'])->name('noticias.store');
Route::get('/admin/noticias/{id}/editar', [AdminController::class, 'showFormEditNoticia'])->name('noticias.edit');
Route::put('/admin/noticias/{id}', [AdminController::class, 'editNoticia'])->name('noticias.update');
Route::delete('/admin/noticias/{id}', [AdminController::class, 'deleteNoticia'])->name('noticias.destroy');
Route::post('/admin/noticias/{id}/imagen', [AdminController::class, 'editarImagenNoticia'])->name('noticias.editarImagen');







/**Route::post("/noticias/cargarNuevaNoticia", [AdminController::class, "createNoticia"]);
//Route::get('/noticias/nuevaNoticia', [NoticiasController::class, 'obtenerCategorias']);
Route::get('/noticias/nuevaNoticia', [AdminController::class, "showFormCreateNoticia"]); //Muestra formulario para cargar una nueva noticia
Route::get('/noticias/formEditarNoticia/{id}', [AdminController::class, "showFormEditNoticia"]); //Muestra formulario para editar los datos de una noticia
Route::PATCH('/noticias/{id}', [AdminController::class, "EditNoticia"]); //Edita la noticia con los datos que llegan del formulario
Route::DELETE('/noticias/{id}', [AdminController::class, "deleteNoticia"]); //Elimina la noticia segun el id único que tenga.
*/

//RUTAS LOGIN
Route::post('/logout', [LoginController::class, 'logout']); //Cierra la sesión
Route::post('/login',  [LoginController::class, 'login']); //invoca la logica del login admin
Route::get('/showlogin', [HomeController::class, 'showlogin'])->name("showlogin"); //invoca la vista del login admin (formulario)

//rutas admin y roles
Auth::routes();
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/panel', [AdminController::class, 'adminPanel']);
});


//Route::get('/', [HomeController::class, "index"]); //home del sitio emprendedores general, este seria nuestro index

//rutas del formulario de contacto
Route::get('/formar/parte', [FormController::class, "contacto"]); // redireccionamiento al formulario
Route::post('/formulario/enviar', [FormController::class, 'enviar'])->name('formulario.enviar'); //ruta que envia  la regla post del formulario


//vista admin noticias
Route::get("/noticias", [NoticiaController::class, "showNoticias"]);
Route::get("/noticias/{id}", [NoticiaController::class, "showNoticia"]);


