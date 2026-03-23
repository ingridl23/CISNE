<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @class Visita
 * @brief Modelo que representa las visitas registradas en el sistema.
 *
 * Este modelo almacena las visitas realizadas al sistema,
 * permitiendo obtener métricas como cantidad de accesos por fecha.
 *
 * @property int $id
 * @property \Carbon\Carbon $fecha
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @table visitas
 * @package App\Models
 */
class Visita extends Model
{
    use HasFactory;
    protected $table = 'visitas'; // tu tabla real
    protected $fillable = ['fecha'];
}
