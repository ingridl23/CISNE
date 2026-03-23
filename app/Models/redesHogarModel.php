<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\hogarModel;

/**
 * @class redesHogarModel
 * @brief Modelo que representa las redes sociales asociadas a un hogar.
 *
 * Este modelo gestiona las redes sociales de las instituciones (hogares),
 * permitiendo almacenar y normalizar enlaces a Instagram, Facebook y WhatsApp.
 *
 * Relaciones:
 * - Un registro de redes pertenece a un hogar (1:1)
 *
 * @property int $id
 * @property string|null $instagram
 * @property string|null $facebook
 * @property string|null $whatsapp
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property HogarModel $hogar
 *
 * @table red_hogar
 * @package App\Models
 */

class redesHogarModel extends Model
{
    use HasFactory;

    protected $table = 'red_hogar'; // tu tabla real

    protected $fillable = [
        'instagram',
        'facebook',
        'whatsapp'
    ];

    //traer las redes relacionadas
    /**
 * @brief Relación con el hogar asociado.
 *
 * Un conjunto de redes pertenece a un hogar.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasOne
 */
    public function Hogar(): HasOne
    {
        return $this->hasOne(hogarModel::class, 'redes_id', 'id');
    }


    //CRUd para las redes de los hogares

    //funcion modificar
    /**
 * @brief Elimina el registro de redes sociales.
 *
 * @param redesHogarModel $redes
 * @return bool|null
 */
    public static function editarHogar_Redes($redes)
    {
        $cadena = "https";
        if (!strpos($redes->instagram, $cadena)) {
            $redes->instagram = "https://instagram.com/{$redes->instagram}";
        }
        if (!strpos($redes->facebook, $cadena)) {
            $redes->facebook = "https://facebook.com/{$redes->facebook}";
        }
        $redesEdit = $redes->save();
        return $redesEdit;
    }

    //funcion eliminar

    public static function eliminarEHogar_Redes($redes)
    {
        $redesEliminar = $redes->delete();
        return $redesEliminar;
    }

    //dar de alta
    /**
 * @brief Crea un nuevo registro de redes sociales.
 *
 * - Normaliza URLs de Instagram y Facebook
 * - Guarda en la base de datos
 *
 * @param string|null $instagram
 * @param string|null $facebook
 * @param string|null $whatsapp
 * @return redesHogarModel
 */
    public static function crearRedes($instagram, $facebook, $whatsapp)
    {
        if ($instagram) {
            $instagram = "https://instagram.com/{$instagram}";
        }
        if ($facebook) {
            $facebook = "https://facebook.com/{$facebook}";
        }

        $redes = self::create([
            'instagram' => $instagram,
            'facebook' => $facebook,
            'whatsapp' => $whatsapp,
        ]);

        return $redes; // ← DEVUELVO OBJETO
    }
}
