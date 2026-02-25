<?php

namespace App\Http\Controllers;

use App\Models\ProfesionalesModel;
use App\Models\imagesProfesionalesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Profesionales;

class ProfesionalController extends Controller
{
    /* =====================================================
     * LISTADO PRINCIPAL DEL PANEL
     * ===================================================== */
    public function index()
    {
        $profesionales = ProfesionalesModel::with('imagenes')->get();

        return view('admin.listaProfesionales', compact('profesionales'));
    }

    /* =====================================================
     * FORM CREAR
     * ===================================================== */
    public function create()
    {
        return view('admin.profesionales.formNuevoProfesional');
    }







}
