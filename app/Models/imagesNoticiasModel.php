<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NoticiasModel;
use Database\Factories\ImagenesNoticiasFactory;

/**
 * @class imagesNoticiasModel
 * @brief Modelo que representa las imágenes asociadas a las noticias.
 *
 * Este modelo gestiona las imágenes vinculadas a una noticia,
 * almacenando la URL y el identificador público (por ejemplo, Cloudinary).
 *
 * Relación:
 * - Una imagen pertenece a una noticia
 *
 * @property int $id
 * @property int $noticia_id
 * @property string $url
 * @property string $public_id
 *
 * @property NoticiasModel $noticia
 *
 * @table imagen_noticias
 * @package App\Models
 */
class ImagesNoticiasModel extends Model
{

/**
 * @var string $table Nombre de la tabla
 */
protected $table = 'imagen_noticias';

/**
 * @var array $fillable Campos asignables masivamente
 */
    use HasFactory;

  

/**
 * @brief Define la factory asociada al modelo.
 *
 * @return \Database\Factories\ImagenesNoticiasFactory
 */
    protected static function newFactory()
    {
        return ImagenesNoticiasFactory::new();
    }
   

    protected $fillable = [
        'id',
        'noticia_id',
        'url',
        'public_id',



    ];

/**
 * @brief Relación inversa con el modelo Noticias.
 *
 * Una imagen pertenece a una noticia.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function NoticiaImagen()
    {
        return $this->belongsTo(NoticiasModel::class, 'noticia_id');
    }


    /**
     * Busca todas las imágenes asociadas a una noticia.
     */
    public static function buscar($id_noticia)
    {
        return self::where("noticia_id", $id_noticia)->get();
    }

    /**
     * Elimina una imagen del registro.
     */
    public static function eliminarImagen(ImagesNoticiasModel $imagen)
    {
        $imagen->delete();
    }
}
