<?php

namespace App\Exports;

use App\Models\ClassLevel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ClassLevelExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function query()
    {
        return ClassLevel::orderBy('name');
    }

    public function headings(): array
    {
        return [
            'Nama Kelas',
            'Jumlah Siswa',
            'Tanggal Dibuat',
        ];
    }

    public function map($classLevel): array
    {
        return [
            $classLevel->name ?? '-',
            $classLevel->students()->count() ?? 0,
            $classLevel->created_at ? $classLevel->created_at->format('d/m/Y') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0891b2']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Jenjang Kelas';
    }
}

