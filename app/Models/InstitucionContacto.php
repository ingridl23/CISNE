<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @class InstitucionContacto
 * @brief Modelo que representa los contactos provenientes de instituciones.
 *
 * Este modelo almacena la información enviada por instituciones
 * a través del formulario de contacto del sistema.
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $telefono
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @table instituciones_contactoprevio
 * @package App\Models
 */
class InstitucionContacto extends Model
{
    /**
 * @var string $table Nombre de la tabla asociada
 */
protected $table = 'instituciones_contactoprevio';

/**
 * @var array $fillable Campos asignables masivamente
 */
    use HasFactory;

     protected $fillable = ['nombre', 'email', 'telefono'];
}
