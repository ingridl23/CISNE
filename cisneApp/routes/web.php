<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiaController;

//ruta de acceso al sitio web

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profesionales', [HomeController::class, 'index'])->name('profesionales');
Route::get('/novedades', [NoticiaController::class, 'index'])->name('novedades');
//Route::get('/noticias/id',[NoticiaController::class, 'showNoticia'])->name('noticia');

//http://cisne.test/cisneApp/public/
