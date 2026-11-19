<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @class HogarModel
 * @brief Modelo que representa una institución (hogar) dentro del sistema.
 *
 * Este modelo gestiona la información de hogares o instituciones,
 * incluyendo sus datos principales y relaciones asociadas.
 *
 * Relaciones:
 * - Un hogar tiene múltiples imágenes
 * - Un hogar pertenece a una dirección
 * - Un hogar pertenece a un conjunto de redes sociales
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $redes_id
 * @property int $direccion_id
 *
 * @property \Illuminate\Database\Eloquent\Collection|ImagesHogarModel[] $imagenes
 * @property DireccionHogarModel $direccion
 * @property RedesHogarModel $redes
 *
 * @table hogar_mayor
 * @package App\Models
 */
class HogarModel extends Model
{


/**
 * @var string $table Nombre de la tabla
 */
protected $table = 'hogar_mayor';

/**
 * @var array $fillable Campos asignables masivamente
 */
    use HasFactory;

   

    protected $fillable = [
        'nombre',
        'descripcion',
        'redes_id',
        'direccion_id'
    ];


    /**
 * @brief Crea un nuevo hogar en la base de datos.
 *
 * @param string $nombre
 * @param string $descripcion
 * @param int $idRedes
 * @param int $idDireccion
 *
 * @return HogarModel
 */

    public static function crearHogar($nombre, $descripcion, $idRedes, $idDireccion)
    {
        return HogarModel::create([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'redes_id' => $idRedes,
            'direccion_id' => $idDireccion,
        ]);
    }

/**
 * @brief Guarda los cambios de un hogar existente.
 *
 * @param HogarModel $hogar Instancia a actualizar
 * @return bool
 */

    public static function editarHogar($hogar)
    {
        $hogarEdit = $hogar->save();
        return $hogarEdit;
    }

    /**
 * @brief Elimina un hogar de la base de datos.
 *
 * @param HogarModel $hogar Instancia a eliminar
 * @return bool|null
 */

    public static function eliminarEmprendimiento($hogar)
    {
        $hogarEliminar = $hogar->delete();
        return $hogarEliminar;
    }




    /**
 * @brief Relación uno a muchos con imágenes del hogar.
 *
 * Un hogar puede tener múltiples imágenes asociadas.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */

    public function imagenes()
    {
        return $this->hasMany(ImagesHogarModel::class, 'hogar_id');
    }

    /**
 * @brief Relación inversa con la dirección del hogar.
 *
 * Un hogar pertenece a una dirección.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function direccion()
    {
        return $this->belongsTo(DireccionHogarModel::class, 'direccion_id');
    }

    /**
 * @brief Relación inversa con redes sociales del hogar.
 *
 * Un hogar pertenece a un registro de redes sociales.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function redes()
    {
        return $this->belongsTo(RedesHogarModel::class, 'redes_id');
    }
}
