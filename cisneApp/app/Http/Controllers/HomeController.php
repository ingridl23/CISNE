<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfesionalesModel;
use App\Models\HogarModel;
use App\Models\imagesHogarModel;
use Illuminate\Support\ViewErrorBag;
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
        // Profesionales
        $profesionales = ProfesionalesModel::with('imagenes')->paginate(12);

        // Hogares
        $hogares = HogarModel::with('imagenes','direccion','redes')->paginate(12);

        return view('layouts.templateHome', [
            'profesionales' => $profesionales,
            'hogares' => $hogares,
            'errors' => session()->get('errors') ?: new ViewErrorBag,
        ]);
    }
}
