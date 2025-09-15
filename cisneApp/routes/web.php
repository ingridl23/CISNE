<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
//ruta de acceso al sitio web
Route::get('/', [HomeController::class, 'index']);
