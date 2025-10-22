<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\constants;
use Database\Factories\NoticiasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\imagesNoticiasModel;

class noticiasModel extends Model
{
    use HasFactory;

    /**
     * @property $id
     * @property $created_at
     * @property $updated_at
     * @property $titulo
     * @property $descripcion
     * @property $categoria
     *  * @package App
     * @mixin \Illuminate\Database\Eloquent\Builder
     */


    protected $perPage = 20;
    protected $table = "noticia";

    protected static function newFactory()
    {
        return NoticiasFactory::new();
    }


    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'categoria',
    ];



    // imagenes de las noticias trae desde el model de las imagenes
    //hasOne en lugar de hasMany Cada noticia tiene una sola imagen, según tu lógica.
    public function imagenesNoticias()
    {
        return $this->hasOne(imagesNoticiasModel::class, 'noticia_id');
    }


    /** ------------------- CONSULTAS ------------------- **/

    public static function getUltimasNoticias($cantidad)
    {
        return self::orderBy('created_at', 'desc')->paginate($cantidad);
    }

    /**
     * showNoticiasId() devuelve first()
No hace falta get() ni comparar con $perPage.
     */
    public static function showNoticiasId($id)
    {
        return self::where('id', $id)->first();
    }

    public static function obtenerCategoriasNoticias($cantidad = 12)
    {
        return self::orderBy('created_at', 'desc')->take($cantidad)->get();
    }

    public static function obtenerNoticiasCategorias()
    {
        return self::all()->groupBy("categoria");
    }

    public static function obtenerCategorias()
    {
        return ['Turnos', 'Novedad'];
    }

    /** ------------------- CRUD ------------------- **/

    public static function createNoticia($request)
    {
        return self::create([
            'titulo' => Str::ucfirst($request->titulo),
            'categoria' => Str::ucfirst($request->categoria),
            /**
             * nl2br() dentro de createNoticia()
             *  Así el salto de línea se guarda formateado.
             */
            'descripcion' => nl2br($request->descripcion),
        ]);
    }

    public static function editNoticia($noticia)
    {
        $noticia->save();
    }


    /**
     * Eliminadas fechas manuales (created_at, updated_at)
       Laravel las maneja automáticamente.
     */
    public static function deleteNoticia($noticia)
    {
        return $noticia->delete();
    }

}
