<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\HogarModel;

/**
 * @class direccionHogarModel
 * @brief Modelo que representa la dirección de una institución (hogar).
 *
 * Este modelo almacena los datos de ubicación asociados a un hogar:
 * - Provincia
 * - Localidad
 * - Ciudad
 * - Calle y altura
 *
 * Relación:
 * - Una dirección pertenece a un único hogar (1 a 1).
 *
 * @property int $id
 * @property string $provincia
 * @property string $localidad
 * @property string $ciudad
 * @property string $calleYAltura
 * @property HogarModel $hogar
 *
 * @table direccion_hogar
 * @package App\Models
 */
class DireccionHogarModel extends Model
{

/**
 * @var string $table Nombre de la tabla asociada
 */
protected $table = 'direccion_hogar';

/**
 * @var array $fillable Campos asignables masivamente
 */
    use HasFactory;

  

    protected $fillable = [
        'provincia',
        'localidad',
        'ciudad',
        'calleYAltura',

    ];

    /**
 * @brief Relación uno a uno con el modelo Hogar.
 *
 * Una dirección pertenece a un único hogar.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasOne
 */
    public function hogar()
    {
        return $this->hasOne(HogarModel::class, 'direccion_id');
    }

    /**
 * @brief Crea una nueva dirección en la base de datos.
 *
 * @param string $provincia
 * @param string $localidad
 * @param string $ciudad
 * @param string $calle
 *
 * @return DireccionHogarModel
 */

    public static function crearDireccion($provincia,$localidad,$ciudad, $calle)
    {
        $direccion = DireccionHogarModel::create([
            'provincia'=>$provincia,
            'localidad' => $localidad,
            'ciudad' => $ciudad,
            'calleYAltura' => $calle,

        ]);
        return $direccion;
    }


    /**
 * @brief Actualiza una dirección existente.
 *
 * @param DireccionHogarModel $direccion Instancia de la dirección a actualizar
 * @return bool
 */
    public static function editarEmprendimiento($direccion)
    {
        $direccionEdit = $direccion->save();
        return $direccionEdit;
    }

    /**
 * @brief Elimina una dirección de la base de datos.
 *
 * @param DireccionHogarModel $direccion Instancia de la dirección a eliminar
 * @return bool|null
 */
    public static function eliminarEmprendimiento($direccion)
    {
        $direccionEliminar = $direccion->delete();
        return $direccionEliminar;
    }
}
