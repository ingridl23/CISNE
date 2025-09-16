<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\noticiasModel;
use Database\Factories\ImagenesNoticiasFactory;

class imagesNoticiasModel extends Model
{
    use HasFactory;

    protected $table = 'ImagenNoticias'; //  tabla real


    protected static function newFactory()
    {
        return ImagenesNoticiasFactory::new();
    }
    use HasFactory;

    protected $fillable = [
        'id',
        'noticia_id',
        'url',
        'public_id',



    ];


    public function NoticiaImagen()
    {
        return $this->belongsTo(noticiasModel::class, 'noticia_id');
    }


    public static function find($id_noticia)
    {
        $imagenes = imagesNoticiasModel::where("noticia_id", $id_noticia)->get();
        return $imagenes;
    }

    public static function buscar($id_noticia)
    {
        $imagenes = imagesNoticiasModel::where("noticia_id", $id_noticia)->get();
        return $imagenes;
    }

    public static function eliminarImagen(imagesNoticiasModel $imagen)
    {
        $imagen->delete();
    }
}
