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
        return view('admin.formNuevoProfesional');
    }

    /* =====================================================
     * GUARDAR NUEVO
     * ===================================================== */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria' => 'required',
            'matricula' => 'nullable',
            'imagen' => 'required|image|max:2048',
        ]);

        $prof = ProfesionalesModel::create([
            'nombre' => $request->nombre,
            'especialidad' => $request->categoria,
            'matricula' => $request->matricula,
            'descripcion' => $request->descripcion ?? null
        ]);

        // Guardar imagen
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('profesionales', 'public');

            imagesProfesionalesModel::create([
                'profesional_id' => $prof->id,
                'url' => '/storage/' . $path
            ]);
        }

        return redirect()
            ->route('admin.profesionalespanel')
            ->with('success', 'Profesional creado correctamente');
    }

    /* =====================================================
     * FORM EDITAR
     * ===================================================== */
    public function edit($id)
    {
        $profesional = ProfesionalesModel::findOrFail($id);
        $imagenes = $profesional->imagenes;

        return view('admin.formEditarProfesional', compact('profesional', 'imagenes'));
    }

    /* =====================================================
     * GUARDAR EDICIÓN
     * ===================================================== */
    public function updateProfesional(Request $request, ProfesionalesModel $profesional)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria' => 'required',
            'matricula' => 'nullable',
            'descripcion' => 'nullable',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $profesional->update([
            'nombre' => $request->nombre,
            'especialidad' => $request->categoria,
            'matricula' => $request->matricula,
            'descripcion' => $request->descripcion
        ]);

        if ($request->hasFile('imagen')) {
            $old = $profesional->imagenes()->first();
            if ($old) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $old->url));
                $old->delete();
            }

            $path = $request->file('imagen')->store('profesionales', 'public');
            imagesProfesionalesModel::create([
                'profesional_id' => $profesional->id,
                'url' => '/storage/' . $path,
            ]);
        }

        return redirect()
            ->route('admin.profesionales')
            ->with('success', 'Profesional actualizado correctamente');
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
