<?php

namespace App\Http\Controllers;

/**
 * @class ProfesionalController
 * @brief Formulario de creación de profesionales del panel administrativo.
 *
 * El listado y el resto del CRUD están en AdminController.
 *
 * @package App\Http\Controllers
 */
class ProfesionalController extends Controller
{
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
