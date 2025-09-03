<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;



//ruta de la home page cisne
Route::get('/', [HomeController::class, "index"]); //homepage  general, este seria nuestro index

