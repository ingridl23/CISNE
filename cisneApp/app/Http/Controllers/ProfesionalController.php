<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfesionalesModel;


class ProfesionalController extends Controller
{
    public function index()
    {
        // Traés los profesionales de la base
        $profesionales = ProfesionalesModel::showProfesionales();
        // Pasar la variable a la vista principal (templateHome)
        return view('layouts.templateHome', compact('profesionales'));
    }
}
