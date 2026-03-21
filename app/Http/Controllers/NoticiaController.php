<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NoticiasModel;
use App\Models\CategoriasNews;
use Illuminate\Support\ViewErrorBag;
class NoticiaController extends Controller
{
      /**
     * Visualizar las publicaciones vigentes en el sistema:
     * Permite a todos los usuarios acceder a la interfaz funcional de las publicaciones.
     * @return \Illuminate\Http\RedirectResponse Redirige al usuario hacia la seccion de ultimas publicaciones.
     */
    public function index3(){
        $cantidad = 12;
        $categorias = CategoriasNews::all();

        $noticias= NoticiasModel::with('imagenesNoticias','categoria')->latest()->paginate($cantidad);
        return view('layouts.Noticias', compact('noticias','categorias'))
            ->with('i', (request()->input('page', 1) - 1) * $noticias->perPage());
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
/*
public function filterNoticiasByCategory(Request $request)
{
    return response()->json([
        "ok" => true,
        "mensaje" => "llegó al controller",
        "busqueda" => $request->query('busqueda')
    ]);
}
*/

public function filterNoticiasByCategory(Request $request)
{
    $busqueda = $request->query('busqueda');

    $noticias = NoticiasModel::with('categoria','imagenesNoticias')
        ->where('categoria_id', $busqueda)
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
