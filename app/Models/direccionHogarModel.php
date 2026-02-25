<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\hogarModel;

class direccionHogarModel extends Model
{
    use HasFactory;



    protected $table = 'direccion_hogar'; // tu tabla real

    protected $fillable = [
        'provincia',
        'localidad',
        'ciudad',
        'calleYAltura',

    ];

    public function hogar()
    {
        return $this->hasOne(hogarModel::class, 'direccion_id');
    }


    public static function crearDireccion($provincia,$localidad,$ciudad, $calle)
    {
        $direccion = direccionHogarModel::create([
            'provincia'=>$provincia,
            'localidad' => $localidad,
            'ciudad' => $ciudad,
            'calleYAltura' => $calle,

        ]);
        return $direccion;
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
