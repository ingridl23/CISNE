<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente_contacto extends Model
{
    use HasFactory;

    protected $table = 'pacientes'; // tu tabla real
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'created_at'
    ];



}
