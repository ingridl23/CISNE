<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\noticiasModel;
class NoticiaController extends Controller
{
    public function index(){
        $cantidad = 12;
        $noticias= noticiasModel::with('imagenesNoticias')->latest()->paginate($cantidad);
        return view('layouts.Noticias', compact('noticias'));
    }
    public function showNoticias()
    {
        $cantidad = 12;
        $noticias = noticiasModel::getUltimasNoticias($cantidad);
        return view('layouts.noticias', compact('noticias'))
            ->with('i', (request()->input('page', 1) - 1) * $noticias->perPage());
    }


    public function showNoticia($id)
    {
        if (is_numeric($id) && $id > 0) {
            $noticia = noticiasModel::showNoticiasId($id);
            if ($noticia != null) {
                return view("layouts.noticia", compact('noticia'));
            }
        }
    }

    /*Filtro de busqueda de noticias por titulo*/
    public function filterNoticiasByTittle(Request $request)
    {
        $busqueda = $request->query('busqueda');
        $noticias = noticiasModel::where('titulo', 'LIKE', '%' . $busqueda . '%')
            // ->orWhere('categoria', 'LIKE', '%' . $busqueda . '%')
            ->get();
        return response()->json($noticias);
    }
    /*Filtro de busqueda de noticias por categoria*/
    public function filterNoticiasByCategory(Request $request)
    {
        $busqueda = $request->query('busqueda');
        $noticias = noticiasModel::where('categoria', 'LIKE', '%' . $busqueda . '%')
            // ->orWhere('categoria', 'LIKE', '%' . $busqueda . '%')
            ->get();
        return response()->json($noticias);
    }

    /*Filtro de busqueda de noticias por fecha*/
    public function filterNoticiasByDate(Request $request)
    {
        $busqueda = $request->query('busqueda');
        $noticias = noticiasModel::where('created_at', 'LIKE', '%' . $busqueda . '%')
            // ->orWhere('categoria', 'LIKE', '%' . $busqueda . '%')
            ->get();
        return response()->json($noticias);
    }
    public function showFormCrearNoticia()
    {
        return view('administradores.noticias.formNuevaNoticia');
    }
}
