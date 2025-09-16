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


    protected $perPage = 10;
    protected $table = "Noticia";

    protected static function newFactory()
    {
        return NoticiasFactory::new();
    }
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria',
    ];


    public static function getUltimasNoticias($cantidad = 10)
    {
        return noticiasModel::orderBy('created_at', 'desc')
            ->paginate($cantidad);
    }


    public static function showNoticiasId($id)
    {
        $noticia = noticiasModel::where('noticias.id', $id)->get();
        if (count($noticia) > constants::VALORMIN) {
            $noticia = $noticia[0];
            return $noticia;
        }
    }
    public static function obtenerCategoriasNoticias($cantidad = 10)
    {

        return noticiasModel::with(['categoria']) // relacion
            ->orderBy('created_at', 'desc')
            ->take($cantidad)
            ->get();
    }


    public static function obtenerNoticiasCategorias()
    {
        $categorias = noticiasModel::all()->groupBy("categoria");
        return $categorias;
    }

    /**
     * Obtiene las categorias cargadas
     *
     * @return Array, Categorias cargadas
     */
    public static function obtenerCategorias()
    {
        return [
            'Turnos',
            'Novedad',

        ];
    }

    // imagenes de las noticias trae desde el model de las imagenes

    public function imagenesNoticias()
    {
        return $this->hasMany(imagesNoticiasModel::class);
    }

    // metodos del CRUD para noticias
    public static function createNoticia($request)
    {
        $noticia = noticiasModel::create([
            'titulo' => $request->titulo,
            'categoria' => Str::ucfirst($request->categoria),
            'descripcion' => Str::ucfirst($request->descripcion),
            'created_at' => date('m-d-Y G:i:s'),
            'updated_at' => date('m-d-Y G:i:s'),
        ]);
        return $noticia;
    }

    public static function editNoticia($noticia)
    {
        $noticia->save();
    }

    public static function deleteNoticia($noticia)
    {
        $eliminado = $noticia->delete();
        return $eliminado;
    }
}
