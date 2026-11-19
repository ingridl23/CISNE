<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProfesionalesModel;
use Database\Factories\ImagenesProfesionalFactory;


/**
 * @class imagesProfesionalesModel
 * @brief Modelo que representa las imágenes asociadas a profesionales.
 *
 * Este modelo gestiona las imágenes vinculadas a un profesional,
 * almacenando la URL y el identificador público (por ejemplo, Cloudinary).
 *
 * Relación:
 * - Una imagen pertenece a un profesional
 *
 * @property int $id
 * @property int $profesional_id
 * @property string $url
 * @property string $public_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property ProfesionalesModel $profesional
 *
 * @table imagen_profesional
 * @package App\Models
 */

class ImagesProfesionalesModel extends Model
{

/**
 * @var string $table Nombre de la tabla
 */
protected $table = 'imagen_profesional';

/**
 * @var array $fillable Campos asignables masivamente
 */
 

/**
 * @brief Define la factory asociada al modelo.
 *
 * @return \Database\Factories\ImagenesProfesionalFactory
 */
    protected static function newFactory()
    {
        return ImagenesProfesionalFactory::new();
    }


    protected $fillable = [
        'id',
        'profesional_id',
        'url',
        'public_id',



    ];

/**
 * @brief Relación inversa con el modelo Profesional.
 *
 * Una imagen pertenece a un profesional.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function ProfesionalImagen()
    {
        return $this->belongsTo(ProfesionalesModel::class, 'profesional_id');
    }


/**
 * @brief Obtiene las imágenes asociadas a un profesional.
 *
 * @param int $id_profesional ID del profesional
 * @return \Illuminate\Database\Eloquent\Collection
 */

    public static function buscar($id_emprendedor)
    {
        $imagenes = ImagesProfesionalesModel::where("profesional_id", $id_emprendedor)->get();
        return $imagenes;
    }

    /**
 * @brief Elimina una imagen de profesional.
 *
 * @param ImagesProfesionalesModel $imagen
 * @return bool|null
 */
    public static function eliminarImagen(ImagesProfesionalesModel $imagen)
    {
        $imagen->delete();
    }
}
