<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Model\imagesProfesionalModel;
use Database\Factories\ProfesionalFactory;
use App\Models\Constants;

/**
 * @class ProfesionalesModel
 * @brief Modelo que representa a los profesionales del sistema.
 *
 * Este modelo gestiona la información de los profesionales,
 * incluyendo sus datos básicos y sus imágenes asociadas.
 *
 * Relaciones:
 * - Un profesional puede tener múltiples imágenes
 *
 * @property int $id
 * @property string $nombre
 * @property string $especialidad
 * @property string|null $matricula
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $imagenes
 *
 * @table profesional
 * @package App\Models
 */

class ProfesionalesModel extends Model
{
    use HasFactory;

    protected $perPage = 12;
    protected $table = 'profesional'; // tu tabla real






    protected $fillable = [
        'nombre',
        'especialidad',
        'matricula',
    ];







    // CRUd para profesionales
/*
    public static function editarProfesional($profesional)
    {
        $profesionalEdit = $profesional->save();
        return $profesionalEdit;
    }*/

    public static function eliminarEmprendimiento($profesional)
    {
        $profesionalEliminar = $profesional->delete();
        return $profesionalEliminar;
    }

    public function imagenes()
    {
        return $this->hasMany(imagesProfesionalesModel::class, 'profesional_id');
    }
}
