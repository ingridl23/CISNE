<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NoticiasModel;
use Illuminate\Support\ViewErrorBag;
class NoticiaController extends Controller
{
    public function index3(){
        $cantidad = 12;
        $noticias= NoticiasModel::with('imagenesNoticias')->latest()->paginate($cantidad);
        return view('layouts.Noticias', compact('noticias'), [
            'errors' => session()->get('errors') ?: new ViewErrorBag,
       ]);
    }


    public function showNoticia($id)
    {
        if (is_numeric($id) && $id > 0) {
            $noticia = NoticiasModel::showNoticiasId($id);
            if ($noticia != null) {
                return view("layouts.NoticiaIndividual", compact('noticia'),[
                    'errors' => session()->get('errors') ?: new ViewErrorBag,
                ]);
            }
        }
    }


    public function filterNoticiasByTittle(Request $request)
    {
        $busqueda = $request->query('busqueda');

        $noticias = NoticiasModel::with('imagenesNoticias')
            ->where('titulo', 'LIKE', '%' . $busqueda . '%')
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'titulo' => $n->titulo,
                    'categoria_id' =>  $n->categoria->nombre,
                    'created_at' => $n->created_at,
                    'updated_at' => $n->updated_at,
                    'imagen' => $n->imagenesNoticias ? $n->imagenesNoticias->url : null,
                ];
            });

        return response()->json($noticias);
    }

    public function filterNoticiasByCategory(Request $request)
    {
        $busqueda = $request->query('busqueda');

        $noticias = NoticiasModel::with('imagenesNoticias','categoria')
        ->whereHas('categoria', function ($q) use ($busqueda) {
    $q->where('nombre', 'LIKE', '%' . $busqueda . '%');
})
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'titulo' => $n->titulo,
                    'categoria' => $n->categoria->nombre,
                    'created_at' => $n->created_at,
                    'updated_at' => $n->updated_at,
                    'imagen' => $n->imagenesNoticias ? $n->imagenesNoticias->url : null,
                ];
            });

        return response()->json($noticias);
    }

    public function filterNoticiasByDate(Request $request)
    {
        $busqueda = $request->query('busqueda');

        $noticias = NoticiasModel::with('imagenesNoticias')
            ->whereDate('created_at', $busqueda)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'titulo' => $n->titulo,
                    'categoria_id' => $n->categoria->nombre,
                    'created_at' => $n->created_at,
                    'updated_at' => $n->updated_at,
                    'imagen' => $n->imagenesNoticias ? $n->imagenesNoticias->url : null,
                ];
            });

        return response()->json($noticias);
    }
}
