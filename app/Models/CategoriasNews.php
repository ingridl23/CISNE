<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriasNews extends Model
{
    protected $table = 'categorias_news';

    protected $fillable = ['nombre'];

    public function noticias()
    {
        return $this->hasMany(NoticiasModel::class, 'categoria_id');
    }
}