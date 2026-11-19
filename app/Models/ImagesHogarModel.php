<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ImagenesHogarFactory;


/**
 * @class imagesHogarModel
 * @brief Modelo que representa las imágenes asociadas a un hogar.
 *
 * Este modelo gestiona las imágenes de las instituciones (hogares),
 * almacenando la URL y el identificador público (por ejemplo, Cloudinary).
 *
 * Relación:
 * - Una imagen pertenece a un hogar
 *
 * @property int $id
 * @property int $hogar_id
 * @property string $url
 * @property string $public_id
 *
 * @property HogarModel $hogar
 *
 * @table imagen_hogar
 * @package App\Models
 */
class ImagesHogarModel extends Model
{
    use HasFactory;


    protected $table = 'imagen_hogar'; //  tabla real


    /**
 * @brief Define la factory asociada al modelo.
 *
 * @return \Database\Factories\ImagenesHogarFactory
 */
    protected static function newFactory()
    {
        return ImagenesHogarFactory::new();
    }


    protected $fillable = [
        'id',
        'hogar_id',
        'url',
        'public_id',



    ];

/**
 * @brief Relación inversa con el modelo Hogar.
 *
 * Una imagen pertenece a un hogar.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function HogaresImagen()
    {
        return $this->belongsTo(ImagesHogarModel::class, 'hogar_id');
    }

/**
 * @brief Obtiene las imágenes asociadas a un hogar.
 *
 * @param int $id_hogar ID del hogar
 * @return \Illuminate\Database\Eloquent\Collection
 */
    public static function find($id_hogar)
    {
        $imagen = ImagesHogarModel::where("hogar_id", $id_hogar)->get();
        return $imagen;
    }


/**
 * @brief Elimina una imagen de la base de datos.
 *
 * @param ImagesHogarModel $imagen
 * @return bool|null
 */
    public static function eliminarImagen(ImagesHogarModel $imagen)
    {
        $imagen->delete();
    }
}
