<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NoticiasModel;
use Illuminate\Support\ViewErrorBag;
class NoticiaController extends Controller
{
    public function index3(){
        $cantidad = 12;
        $noticias= NoticiasModel::with('imagenesNoticias','categoria')->latest()->paginate($cantidad);
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

    $noticias = NoticiasModel::with('categoria','imagenesNoticias')
        ->where('titulo', 'LIKE', '%' . $busqueda . '%')
        ->get()
        ->map(function ($n) {
            return [
                'id' => $n->id,
                'titulo' => $n->titulo,
                'categoria' => $n->categoria->nombre ?? 'Sin categoría',
                'imagen' => $n->imagenesNoticias->url ?? null,
                'created_at' => $n->created_at,
                'updated_at' => $n->updated_at,
            ];
        });

     return response()->json($noticias ?? []);
}
public function filterNoticiasByCategory(Request $request)
{
    $busqueda = $request->query('busqueda');

    $noticias = NoticiasModel::with('categoria','imagenesNoticias')
        ->whereHas('categoria', function ($q) use ($busqueda) {
            $q->where('nombre', 'LIKE', '%' . $busqueda . '%');
        })
        ->get()
        ->map(function ($n) {
            return [
                'id' => $n->id,
                'titulo' => $n->titulo,
                'categoria' => $n->categoria->nombre ?? 'Sin categoría',
                'imagen' => $n->imagenesNoticias->url ?? null,
                'created_at' => $n->created_at,
                'updated_at' => $n->updated_at,
            ];
        });

     return response()->json($noticias ?? []);
}



public function filterNoticiasByDate(Request $request)
{
    $busqueda = $request->query('busqueda');

    $noticias = NoticiasModel::with('categoria','imagenesNoticias')
        ->whereDate('created_at', $busqueda)
        ->get()
        ->map(function ($n) {
            return [
                'id' => $n->id,
                'titulo' => $n->titulo,
                'categoria' => $n->categoria->nombre ?? 'Sin categoría',
                'imagen' => $n->imagenesNoticias->url ?? null,
                'created_at' => $n->created_at,
                'updated_at' => $n->updated_at,
            ];
        });

     return response()->json($noticias ?? []);
}
}
