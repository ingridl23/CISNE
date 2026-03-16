<?php
namespace App\Exports;
use App\Models\Paciente_contacto;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PacienteExport implements FromCollection, WithHeadings, WithMapping
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
        $query = Paciente_contacto::query();

        if ($this->desde) {
            $query->whereDate('created_at', '>=', $this->desde);
        }

        if ($this->hasta) {
            $query->whereDate('created_at', '<=', $this->hasta);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Email',
            'Telefono',
            'Fecha Registro',
        ];
    }

    public function map($paciente): array
    {
        return [
            $paciente->id,
            $paciente->nombre,
            $paciente->email,
            $paciente->telefono,
            $paciente->created_at?->format('Y-m-d')
        ];
    }
}