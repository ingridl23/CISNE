<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\profesionalesModel;
use Database\Factories\ImagenesProfesionalFactory;


/**
 * Class ProfesionalesModel
 *
 * @property $img_id

 * @property $profesional_id
 * @property $url
 *
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */



class imagesProfesionalesModel extends Model
{
    use HasFactory;

    protected $table = 'ImagenProfesional'; //  tabla real


    protected static function newFactory()
    {
        return ImagenesProfesionalFactory::new();
    }
    use HasFactory;

    protected $fillable = [
        'id',
        'profesional_id',
        'url',
        'public_id',



    ];


    public function ProfesionalImagen()
    {
        return $this->belongsTo(profesionalesModel::class, 'profesional_id');
    }




    public static function buscar($id_emprendedor)
    {
        $imagenes = imagesProfesionalesModel::where("profesional_id", $id_emprendedor)->get();
        return $imagenes;
    }

    public static function eliminarImagen(imagesProfesionalesModel $imagen)
    {
        $imagen->delete();
    }
}
