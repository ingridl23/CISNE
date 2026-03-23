<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ImagenFlyers;
use  Database\Factories\ImagenesFlyersFactory;


/**
 * @class imagesFlyersModel
 * @brief Modelo que representa las imágenes asociadas a flyers.
 *
 * Este modelo gestiona el almacenamiento de imágenes de flyers,
 * incluyendo su URL y el identificador público (por ejemplo, en Cloudinary).
 *
 * @property int $id
 * @property string $url
 * @property string $public_id
 *
 * @table ImagenFlyer
 * @package App\Models
 */
class imagesFlyersModel extends Model
{


/**
 * @var string $table Nombre de la tabla asociada
 */
protected $table = 'ImagenFlyer';

/**
 * @var array $fillable Campos asignables masivamente
 */
    use HasFactory;

  

/**
 * @brief Define la factory asociada al modelo.
 *
 * @return \Database\Factories\ImagenesFlyersFactory
 */
    protected static function newFactory()
    {
        return ImagenesFlyersFactory::new();
    }
 

    protected $fillable = [
        'id',
        'url',
        'public_id',




    ];

/**
 * @brief Relación con el modelo de flyer (definida actualmente como autorreferencia).
 *
 * @warning Esta relación parece incorrecta (ver observaciones).
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function FlyerImagen()
    {
        return $this->belongsTo(imagesFlyersModel::class, 'id');
    }

/**
 * @brief Busca imágenes por ID.
 *
 * @param int $id
 * @return \Illuminate\Database\Eloquent\Collection
 */
    public static function find($id)
    {
        $imagenes = imagesFlyersModel::where("id", $id)->get();
        return $imagenes;
    }

    /**
 * @brief Método alternativo para buscar imágenes por ID.
 *
 * @param int $id
 * @return \Illuminate\Database\Eloquent\Collection
 */
    public static function buscar($id)
    {
        $imagenes = imagesFlyersModel::where("id", $id)->get();
        return $imagenes;
    }

    /**
 * @brief Elimina una imagen de flyer.
 *
 * @param imagesFlyersModel $imagen
 * @return void
 */
    public static function eliminarImagen(imagesFlyersModel $imagen)
    {
        $imagen->delete();
    }
}
