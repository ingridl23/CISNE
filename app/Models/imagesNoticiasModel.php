<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\noticiasModel;
use Database\Factories\ImagenesNoticiasFactory;

class imagesNoticiasModel extends Model
{
    use HasFactory;

    protected $table = 'imagen_noticias';


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


    /**
     * Busca todas las imágenes asociadas a una noticia.
     */
    public static function buscar($id_noticia)
    {
        return self::where("noticia_id", $id_noticia)->get();
    }

    /**
     * Elimina una imagen del registro.
     */
    public static function eliminarImagen(imagesNoticiasModel $imagen)
    {
        $imagen->delete();
    }
}
