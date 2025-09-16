<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\hogarModel;

class redesHogarModel extends Model
{
    use HasFactory;

    protected $table = 'RedHogar'; // tu tabla real

    protected $fillable = [
        'instagram',
        'facebook',
        'whatsapp'
    ];

    //traer las redes relacionadas
    public function Hogar(): HasOne
    {
        return $this->hasOne(hogarModel::class, 'redes_id', 'id');
    }


    //CRUd para las redes de los hogares

    //funcion modificar
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
    public static function crearRedes($instagram, $facebook, $whatsapp)
    {
        if (isset($instagram)) {
            $instagram = "https://instagram.com/{$instagram}";
        }
        if (isset($facebook)) {
            $facebook = "https://facebook.com/{$facebook}";
        }
        $redes = redesHogarModel::create([
            'instagram' => $instagram,
            'facebook' => $facebook,
            'whatsapp' => $whatsapp,
        ]);
        return $redes->id;
    }
}
