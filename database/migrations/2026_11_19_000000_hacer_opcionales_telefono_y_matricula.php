<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * telefono (formulario de contacto) y matricula (profesionales) son opcionales
 * en la validación ('nullable'), pero las columnas eran NOT NULL.
 *
 * Con el middleware ConvertEmptyStringsToNull (restaurado en el Kernel), un campo
 * vacío llega como null y el INSERT/UPDATE fallaba.
 */
return new class extends Migration
{
    /** @var array<string, string> tabla => columna */
    private array $columnas = [
        'pacientes' => 'telefono',
        'instituciones_contactoprevio' => 'telefono',
        'profesional_envioCV' => 'telefono',
        'profesional' => 'matricula',
    ];

    public function up(): void
    {
        foreach ($this->columnas as $tabla => $columna) {
            Schema::table($tabla, function (Blueprint $table) use ($columna) {
                $table->string($columna)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->columnas as $tabla => $columna) {
            // Para volver a NOT NULL no puede haber nulls
            DB::table($tabla)->whereNull($columna)->update([$columna => '']);

            Schema::table($tabla, function (Blueprint $table) use ($columna) {
                $table->string($columna)->nullable(false)->change();
            });
        }
    }
};
