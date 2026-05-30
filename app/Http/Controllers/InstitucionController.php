<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DireccionHogarModel;
use App\Models\Institucion_contacto;
use App\Models\RedesHogarModel;
use App\Models\HogarModel;
use Illuminate\Support\ViewErrorBag;
/**
 * @class HomeController
 * @brief Controlador de la página principal del sitio Cisne Consultorios.
 *
 * Este controlador se encarga de:
 * - Obtener y mostrar las instituciones (hogares)
 * - Cargar sus imágenes asociadas
 *
 * La información es enviada a la vista principal del sistema (homepage).
 *
 * @since 2025-09
 * @author Ingrid Ledesma
 *
 * @todo Evaluar mejoras en la carga de relaciones (imágenes, redes, dirección)
 * en caso de requerir mayor complejidad en la vista.
 */


class HomeController extends Controller{

/**
 * @brief Muestra la página principal del sitio.
 *
 * Obtiene las instituciones (hogares) con sus imágenes asociadas
 * y las envía a la vista principal.
 *
 * También incluye los errores de sesión en caso de existir.
 *
 * @return \Illuminate\View\View
 */
    public function index()
    {
        // Traer profesionales con su imagen (solo retrato principal)


        $instituciones = HogarModel::with('imagenes')->paginate(12);

        return view('layouts.templateHome', [
            'instituciones' => $instituciones,
            'errors' => session()->get('errors') ?: new ViewErrorBag,
        ]);
    }


}
