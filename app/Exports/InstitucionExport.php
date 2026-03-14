<?php

namespace App\Exports;

use App\Models\institucion_contacto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InstitucionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return institucion_contacto::all([
            'id',
            'nombre',
            'email',
            'telefono'
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Email',
            'Telefono'
        ];
    }
}