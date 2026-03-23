<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NoticiasModel;
use App\Models\CategoriasNews;
use Illuminate\Support\ViewErrorBag;
/**
* @class NoticiaController
* @brief Controlador encargado de la gestión y visualización de noticias.
*
* Este controlador permite:
* - Listar noticias con paginación
* - Visualizar una noticia individual
* - Filtrar noticias por título, categoría y fecha
*
* Incluye soporte para respuestas en formato JSON para búsquedas dinámicas
* (AJAX o consumo desde frontend).
*
* @package App\Http\Controllers
*/
class NoticiaController extends Controller
{

    /**
 * @brief Muestra el listado de noticias con paginación.
 *
 * Obtiene las noticias ordenadas por fecha (más recientes primero),
 * incluyendo sus relaciones:
 * - Imágenes
 * - Categoría
 *
 * También carga todas las categorías disponibles.
 *
 * @return \Illuminate\View\View
 */
    public function index3(){
        $cantidad = 12;
        $categorias = CategoriasNews::all();

        $noticias= NoticiasModel::with('imagenesNoticias','categoria')->latest()->paginate($cantidad);
        return view('layouts.Noticias', compact('noticias','categorias'))
            ->with('i', (request()->input('page', 1) - 1) * $noticias->perPage());
    }


/**
 * @brief Muestra el detalle de una noticia específica.
 *
 * Valida que el ID sea numérico y mayor a cero.
 * Si la noticia existe, retorna la vista con sus datos.
 *
 * @param int $id ID de la noticia
 * @return \Illuminate\View\View|null
 */

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



/**
 * @brief Filtra noticias por título.
 *
 * Realiza una búsqueda parcial (LIKE) sobre el campo "titulo".
 * Retorna los resultados en formato JSON.
 *
 * @param Request $request Contiene el parámetro 'busqueda'
* @return \Illuminate\Http\JsonResponse
 */

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


/**
 * @brief Filtra noticias por categoría.
 *
 * Busca noticias que coincidan con el ID de categoría enviado.
 * Retorna los resultados en formato JSON.
 *
 * @param Request $request Contiene el ID de la categoría
 * @return \Illuminate\Http\JsonResponse
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


/**
 * @brief Filtra noticias por fecha de creación.
 *
 * Busca noticias creadas en una fecha específica.
 * Retorna los resultados en formato JSON.
 *
 * @param Request $request Contiene la fecha de búsqueda
 * @return \Illuminate\Http\JsonResponse
 */

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
