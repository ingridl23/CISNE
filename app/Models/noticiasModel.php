<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\constants;
use Database\Factories\NoticiasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ImagesNoticiasModel;
use App\Models\CategoriasNews;

/**
 * @class NoticiasModel
 * @brief Modelo que representa las noticias/publicaciones del sistema.
 *
 * Este modelo gestiona las noticias del sistema, incluyendo su contenido,
 * categoría asociada y su imagen principal.
 *
 * Relaciones:
 * - Una noticia pertenece a una categoría
 * - Una noticia tiene una imagen (relación 1:1)
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property int $categoria_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property CategoriasNews $categoria
 * @property ImagesNoticiasModel $imagenesNoticias
 *
 * @table noticia
 * @package App\Models
 */
class NoticiasModel extends Model
{
    use HasFactory;

    /**
     * @property $id
     * @property $created_at
     * @property $updated_at
     * @property $titulo
     * @property $descripcion
     * @property $categoria_id
     *  * @package App
     * @mixin \Illuminate\Database\Eloquent\Builder
     */


    protected $perPage = 20;
    protected $table = "noticia";

    /**
 * @brief Define la factory asociada al modelo.
 *
 * @return \Database\Factories\NoticiasFactory
 */
    protected static function newFactory()
    {
        return NoticiasFactory::new();
    }


    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'categoria_id',
    ];


/**
 * @brief Relación con la categoría de la noticia.
 *
 * Una noticia pertenece a una categoría.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function categoria()
{
    return $this->belongsTo(CategoriasNews::class, 'categoria_id');
}

    // imagenes de las noticias trae desde el model de las imagenes
    //hasOne en lugar de hasMany Cada noticia tiene una sola imagen, según tu lógica.
    /**
 * @brief Relación con la imagen de la noticia.
 *
 * Cada noticia tiene una única imagen asociada.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasOne
 */

    public function imagenesNoticias()
    {
        return $this->hasOne(ImagesNoticiasModel::class, 'noticia_id');
    }


/**
 * @brief Obtiene todas las categorías disponibles.
 *
 * @return \Illuminate\Database\Eloquent\Collection
 */
public static function obtenerCategorias()
{
    return CategoriasNews::all();
}
    /** ------------------- CONSULTAS ------------------- **/


    /**
 * @brief Obtiene las últimas noticias paginadas.
 *
 * @param int $cantidad Cantidad de registros por página
 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
 */

    public static function getUltimasNoticias($cantidad)
    {
        return self::orderBy('created_at', 'desc')->paginate($cantidad);
    }

    /**
 * @brief Obtiene una noticia por su ID.
 *
 * @param int $id
 * @return NoticiasModel|null
 */

    public static function showNoticiasId($id)
    {
        return self::where('id', $id)->first();
    }




    /**
 * @brief Obtiene un conjunto limitado de noticias recientes.
 *
 * @param int $cantidad
 * @return \Illuminate\Database\Eloquent\Collection
 */

    public static function obtenerCategoriasNoticias($cantidad = 12)
    {
        return self::orderBy('created_at', 'desc')->take($cantidad)->get();
    }


    /**
 * @brief Agrupa las noticias por categoría.
 *
 * @return \Illuminate\Support\Collection
 */
    public static function obtenerNoticiasCategorias()
    {
        return self::all()->groupBy("categoria_id");
    }

  

    /** ------------------- CRUD ------------------- **/

    /**
 * @brief Crea una nueva noticia.
 *
 * @param \Illuminate\Http\Request $request
 * @return NoticiasModel
 */

  public static function createNoticia($request)
{
    return self::create([
        'titulo' => Str::ucfirst($request->titulo),
        'categoria_id' => $request->categoria_id,
        'descripcion' => nl2br($request->descripcion),
    ]);
}


/**
 * @brief Guarda cambios en una noticia existente.
 *
 * @param NoticiasModel $noticia
 * @return bool
 */

    public static function editNoticia($noticia)
    {
        $noticia->save();
    }


    /**
     * Eliminadas fechas manuales (created_at, updated_at)l
     * laravel la smaneja solas
     */
    /**
 * @brief Elimina una noticia.
 *
 * @param NoticiasModel $noticia
 * @return bool|null
 */

    public static function deleteNoticia($noticia)
    {
        return $noticia->delete();
    }



}
