<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class CategoriasNews
 * @brief Modelo que representa las categorías de noticias.
 *
 * Este modelo gestiona las categorías utilizadas para clasificar
 * las noticias dentro del sistema.
 *
 * Cada categoría puede estar asociada a múltiples noticias.
 *
 * @table categorias_news
 * @package App\Models
 */
class CategoriasNews extends Model
{
    /** @var string Nombre de la tabla asociada al modelo. */
    protected $table = 'categorias_news';

    /** @var list<string> Campos asignables masivamente. */
    protected $fillable = ['nombre'];


    /**
 * @brief Relación uno a muchos con noticias.
 *
 * Una categoría puede tener múltiples noticias asociadas.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
    public function noticias(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NoticiasModel::class, 'categoria_id');
    }
}