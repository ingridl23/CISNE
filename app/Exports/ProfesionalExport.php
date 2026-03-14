<?php
namespace App\Exports;

use App\Models\ProfesionalEnvioCV;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfesionalExport implements FromCollection, WithHeadings
{
    protected $desde;
    protected $hasta;

    public function __construct($desde, $hasta)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function collection()
    {
        $query = ProfesionalEnvioCV::query();

        if ($this->desde) {
            $query->whereDate('created_at', '>=', $this->desde);
        }

        if ($this->hasta) {
            $query->whereDate('created_at', '<=', $this->hasta);
        }

        return $query->get([
            'id',
            'nombre',
            'email',
            'telefono',
            'cv_path'
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Email',
            'Telefono',
            'CV'
        ];
    }
}