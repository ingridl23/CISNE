<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfesionalesModel;

/**
 *
 @Brief Clase Controller de la Homepage del sitio Cisne Consultorios
 @since 2025,septiembre
 @Author Ingrid Ledesma , Tec.Desarrollo Aplicaciones Informaticas.
 *
 * @todo  Queda pendiente en caso que se necesite modificar el metodo dei magenes relacionadas con profesionales, en caso
 * que se necesite iterar mas de una imagen por cada uno de ellos.
 */



class HomeController extends Controller
{
    public function index()
    {
        // Traer profesionales con su imagen (solo retrato principal)

        $profesionales  = ProfesionalesModel::with('imagenes')->paginate(12);
        // Pasar la variable a la vista principal (templateHome)
        return view('layouts.templateHome', compact('profesionales'));
    }


}
