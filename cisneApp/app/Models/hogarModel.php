<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hogarModel extends Model
{
    use HasFactory;

    protected $table = 'hogar_mayor'; // tu tabla real

    protected $fillable = [
        'nombre',
        'descripcion',
        'redes_id',
        'direccion_id'
    ];

    public static function crearHogar($nombre, $descripcion, $redes_id, $direccion_id)
    {
        $hogar = hogarModel::create([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'redes_id' => $redes_id,
            'direccion_id' => $direccion_id,
        ]);
        return $hogar->id;
    }

    public static function editarHogar($hogar)
    {
        $hogarEdit = $hogar->save();
        return $hogarEdit;
    }

    public static function eliminarEmprendimiento($hogar)
    {
        $hogarEliminar = $hogar->delete();
        return $hogarEliminar;
    }


}
