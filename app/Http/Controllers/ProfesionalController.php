<?php

namespace App\Http\Controllers;

use App\Models\ProfesionalesModel;
use App\Models\imagesProfesionalesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Profesionales;

/**
 * @class ProfesionalController
 * @brief Controlador para la gestión de profesionales en el panel administrativo.
 *
 * Este controlador permite:
 * - Listar profesionales
 * - Mostrar el formulario de creación
 *
 * Utiliza el modelo ProfesionalesModel junto con sus imágenes asociadas.
 *
 * @package App\Http\Controllers
 */
class ProfesionalController extends Controller
{
    /* =====================================================
     * LISTADO PRINCIPAL DEL PANEL
     * ===================================================== */

    /**
 * @brief Muestra el listado de profesionales.
 *
 * Obtiene todos los profesionales junto con sus imágenes asociadas
 * y los envía a la vista del panel administrativo.
 *
 * @return \Illuminate\View\View
 */
    public function index()
    {
        $profesionales = ProfesionalesModel::with('imagenes')->get();

        return view('admin.listaProfesionales', compact('profesionales'));
    }

    /* =====================================================
     * FORM CREAR
     * ===================================================== */


    /**
 * @brief Muestra el formulario para crear un nuevo profesional.
 *
 * @return \Illuminate\View\View
 */
    public function create()
    {
        return view('admin.profesionales.formNuevoProfesional');
    }







}
