<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ImagenFlyers;
use  Database\Factories\ImagenesFlyersFactory;

class imagesFlyersModel extends Model
{
    use HasFactory;



    protected $table = 'ImagenFlyer'; //  tabla real


    protected static function newFactory()
    {
        return ImagenesFlyersFactory::new();
    }
    use HasFactory;

    protected $fillable = [
        'id',
        'url',
        'public_id',




    ];


    public function FlyerImagen()
    {
        return $this->belongsTo(imagesFlyersModel::class, 'id');
    }


    public static function find($id)
    {
        $imagenes = imagesFlyersModel::where("id", $id)->get();
        return $imagenes;
    }

    public static function buscar($id)
    {
        $imagenes = imagesFlyersModel::where("id", $id)->get();
        return $imagenes;
    }

    public static function eliminarImagen(imagesFlyersModel $imagen)
    {
        $imagen->delete();
    }
}
