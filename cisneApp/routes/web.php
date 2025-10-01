<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiaController;
//use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;
//ruta de acceso al sitio web

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profesionales', [HomeController::class, 'index'])->name('profesionales');
Route::get('/novedades', [NoticiaController::class, 'index'])->name('novedades');
//Route::get('/noticias/id',[NoticiaController::class, 'showNoticia'])->name('noticia');

//http://cisne.test/cisneApp/public/

Route::get('/noticias/buscadorTitulo', [NoticiaController::class, 'filterNoticiasByTittle']); //Filtro para noticias por titulo
Route::get('/noticias/buscadorCategoria', [NoticiaController::class, 'filterNoticiasByCategory']); //Filtro para noticias por categoria
Route::get('/noticias/buscadorFecha', [NoticiaController::class, 'filterNoticiasByDate']); //Filtro para noticias por fecha



//RUTAS NOTICIAS ADMIN
Route::post("/noticias/cargarNuevaNoticia", [AdminController::class, "createNoticia"]);
//Route::get('/noticias/nuevaNoticia', [NoticiasController::class, 'obtenerCategorias']);
Route::get('/noticias/nuevaNoticia', [AdminController::class, "showFormCreateNoticia"]); //Muestra formulario para cargar una nueva noticia
Route::get('/noticias/formEditarNoticia/{id}', [AdminController::class, "showFormEditNoticia"]); //Muestra formulario para editar los datos de una noticia
Route::PATCH('/noticias/{id}', [AdminController::class, "EditNoticia"]); //Edita la noticia con los datos que llegan del formulario
Route::DELETE('/noticias/{id}', [AdminController::class, "deleteNoticia"]); //Elimina la noticia segun el id único que tenga.


//RUTAS LOGIN
Route::post('/logout', [LoginController::class, 'logout']); //Cierra la sesión
Route::post('/login',  [LoginController::class, 'login']); //invoca la logica del login admin
Route::get('/showlogin', [HomeController::class, 'showlogin'])->name("showlogin"); //invoca la vista del login admin (formulario)


Route::get('/', [HomeController::class, "index"]); //home del sitio emprendedores general, este seria nuestro index

//rutas del formulario de contacto
Route::get('/formar/parte', [FormController::class, "contacto"]); // redireccionamiento al formulario
Route::post('/formulario/enviar', [FormController::class, 'enviar'])->name('formulario.enviar'); //ruta que envia  la regla post del formulario



//rutas admin y roles
Auth::routes();



Route::get("/noticias", [NoticiaController::class, "showNoticias"]);
Route::get("/noticias/{id}", [NoticiaController::class, "showNoticia"]);
