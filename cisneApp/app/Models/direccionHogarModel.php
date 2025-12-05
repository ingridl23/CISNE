<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\hogarModel;

class direccionHogarModel extends Model
{
    use HasFactory;



    protected $table = 'DireccionHogar'; // tu tabla real

    protected $fillable = [
        'provincia',
        'localidad',
        'ciudad',
        'calleYAltura',

    ];

    public function direccionHogar(): HasOne
    {
        return $this->hasOne(direccionHogarModel::class, 'direccion_id', 'id');
    }

    public static function crearDireccion($provincia,$ciudad, $localidad, $calle)
    {
        $direccion = direccionHogarModel::create([
            'provincia'=>$provincia,
            'localidad' => $localidad,
            'ciudad' => $ciudad,
            'calleyAltura' => $calle,

        ]);
        return $direccion->id;
    }

    public static function editarEmprendimiento($direccion)
    {
        $direccionEdit = $direccion->save();
        return $direccionEdit;
    }

    public static function eliminarEmprendimiento($direccion)
    {
        $direccionEliminar = $direccion->delete();
        return $direccionEliminar;
    }
}
