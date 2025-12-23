<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TutorExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function query()
    {
        return User::where('role', 'tutor')->orderBy('name');
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Bio',
            'Tanggal Dibuat',
        ];
    }

    public function map($tutor): array
    {
        return [
            $tutor->name ?? '-',
            $tutor->email ?? '-',
            $tutor->bio ?? '-',
            $tutor->created_at ? $tutor->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '7c3aed']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Tutor';
    }
}

