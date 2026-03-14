<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesionalEnvioCV extends Model
{
    use HasFactory;

    /**
     * @property $id
     * @property $nombre
     * @property $email
     * @property $telefono
     * @property $cv_path
     * @property $created_at
     * @property $updated_at
     *  * @package App
     * @mixin \Illuminate\Database\Eloquent\Builder
     */


    protected $perPage = 20;
    protected $table = "profesional_envioCV";

    protected static function newFactory()
    {
        return ProfesionalEnvioCV::new();
    }


    protected $fillable = [
        'id',
        'nombre',
        'email',
        'telefono',
        'cv_path',
        'created_at'
    ];


    /** ------------------- CONSULTAS ------------------- **/

    public static function getUltimosCVS($cantidad)
    {
        return self::orderBy('created_at', 'desc')->paginate($cantidad);
    }

    /**
     * showNoticiasId() devuelve first()
No hace falta get() ni comparar con $perPage.
     */
    public static function showCVId($id)
    {
        return self::where('id', $id)->first();
    }
    public static function obtenerUltimosCVSPorFecha($cantidad = 10,$fecha )
    {
        return self::orderBy('created_at','desc' , $fecha)->take($cantidad)->get();
    }

    public static function obtenerPorEmail($email)
    {
        return self::all()->groupBy("email");
    }



}
