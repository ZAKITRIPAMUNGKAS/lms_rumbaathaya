<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MaterialExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function query()
    {
        return Material::with(['subject', 'classLevel', 'tutor', 'uploader'])
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Deskripsi',
            'Mata Pelajaran',
            'Kelas',
            'Tutor',
            'Diupload Oleh',
            'Tanggal Upload',
        ];
    }

    public function map($material): array
    {
        return [
            $material->title ?? '-',
            $material->description ?? '-',
            $material->subject->name ?? '-',
            $material->classLevel->name ?? '-',
            $material->tutor->name ?? '-',
            $material->uploader->name ?? '-',
            $material->created_at ? $material->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ea580c']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Materi & Konten';
    }
}

