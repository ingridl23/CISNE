<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfesionalController;
//ruta de acceso al sitio web
Route::get('/', [HomeController::class, 'index']);
Route::get('/profesionales', [ProfesionalController::class, 'index']);
