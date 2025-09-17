<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notiicasModel;
class NoticiaController extends Controller
{
    public function index(){
        return view('layouts.Noticias');
    }
}
