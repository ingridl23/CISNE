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


    /* =====================================================
     * FORM EDITAR
     * ===================================================== */
    public function edit($id)
    {
        $profesional = ProfesionalesModel::findOrFail($id);
        $imagenes = $profesional->imagenes;

        return view('admin.profesionales.formEditarProfesional', compact('profesional', 'imagenes'));
    }


    /* =====================================================
     * LISTADO PARA EDITAR (updateList)
     * ===================================================== */
    public function updateList()
    {
        $profesionales = ProfesionalesModel::with('imagenes')->get();
        return view('admin.listaProfesionalesUpdate', compact('profesionales'));
    }

    /* =====================================================
     * ELIMINAR
     * ===================================================== */
    public function destroy($id)
    {
        $prof = ProfesionalesModel::findOrFail($id);

        // Borrar imagen
        if ($prof->imagenes->first()) {
            $path = str_replace('/storage/', '', $prof->imagenes->first()->url);
            Storage::disk('public')->delete($path);
            $prof->imagenes->first()->delete();
        }

        $prof->delete();

        return back()->with('success', 'Profesional eliminado');
    }
}
