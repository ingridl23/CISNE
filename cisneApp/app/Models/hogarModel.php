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

    public static function crearHogar($nombre, $descripcion, $idRedes, $idDireccion)
    {
        return hogarModel::create([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'redes_id' => $idRedes,
            'direccion_id' => $idDireccion,
        ]);
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

    public function imagenes()
    {
        return $this->hasMany(imagesHogarModel::class, 'hogar_id');
    }

    public function direccion()
    {
        return $this->belongsTo(direccionHogarModel::class, 'direccion_id');
    }
    public function redes()
    {
        return $this->belongsTo(redesHogarModel::class, 'redes_id');
    }
}
