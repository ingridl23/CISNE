<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ImagenesHogarFactory;

class imagesHogarModel extends Model
{
    use HasFactory;


    protected $table = 'ImagenHogar'; //  tabla real


    protected static function newFactory()
    {
        return ImagenesHogarFactory::new();
    }
    use HasFactory;

    protected $fillable = [
        'id',
        'hogar_id',
        'url',
        'public_id',



    ];


    public function HogaresImagen()
    {
        return $this->belongsTo(imagesHogarModel::class, 'hogar_id');
    }


    public static function find($id_hogar)
    {
        $imagenes = imagesHogarModel::where("hogar_id", $id_hogar)->get();
        return $imagenes;
    }

    public static function buscar($id_hogar)
    {
        $imagenes = imagesHogarModel::where("hogar_id", $id_hogar)->get();
        return $imagenes;
    }

    public static function eliminarImagen(imagesHogarModel $imagen)
    {
        $imagen->delete();
    }
}
