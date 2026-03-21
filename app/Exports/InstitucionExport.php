<?php

namespace App\Exports;

use App\Models\InstitucionContacto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InstitucionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return InstitucionContacto::all([
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