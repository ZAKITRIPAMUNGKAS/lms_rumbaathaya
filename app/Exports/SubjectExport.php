<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SubjectExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function query()
    {
        return Subject::orderBy('name');
    }

    public function headings(): array
    {
        return [
            'Nama Mata Pelajaran',
            'Slug',
            'Jumlah Jadwal',
            'Tanggal Dibuat',
        ];
    }

    public function map($subject): array
    {
        return [
            $subject->name ?? '-',
            $subject->slug ?? '-',
            $subject->schedules()->count() ?? 0,
            $subject->created_at ? $subject->created_at->format('d/m/Y') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'dc2626']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Mata Pelajaran';
    }
}

