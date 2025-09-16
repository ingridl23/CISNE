<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Model\imagesProfesionalModel;
use Database\Factories\ProfesionalFactory;
use App\Models\Constants;

/**
 * Class Profesional model
 *
 * @property $id
 * @property $nombre
 * @property $especialidad
 * @property $matricula
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class profesionalesModel extends Model
{
    use HasFactory;

    protected $perPage = 20;
    protected $table = 'Profesional'; // tu tabla real

    protected static function newFactory()
    {
        return ProfesionalFactory::new();
    }
    use HasFactory;



    protected $fillable = [
        'nombre',
        'especialidad',
        'matricula',
    ];


    public function imagenes()
    {
        return $this->hasMany(imagesProfesionalesModel::class);
    }

    public static function showProfesionales()
    {
        //$emprendimientos = emprendedores::select(['id', 'nombre', 'descripcion', 'imagen', 'categoria'])->get();
        $profesionales = profesionalesModel::all();
        if (count($profesionales) > constants::VALORMIN) {
            return  $profesionales;
        }
        return null;
    }

    // CRUd para profesionales

    public static function editarProfesional($profesional)
    {
        $profesionalEdit = $profesional->save();
        return $profesionalEdit;
    }

    public static function eliminarEmprendimiento($profesional)
    {
        $profesionalEliminar = $profesional->delete();
        return $profesionalEliminar;
    }
}
