<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfesionalesModel;


class ProfesionalController extends Controller
{
    public function index()
    {
        // Traés los profesionales de la base
        $profesionales = profesionalesModel::all();

        // Se los pasás a la vista
        return view("layouts.profesional-card", compact('profesionales'));
    }
}
