<?php

namespace App\Exports;

use App\Models\Documentation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DocumentationExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function query()
    {
        return Documentation::orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Tipe',
            'URL',
            'Deskripsi',
            'Tanggal Dibuat',
        ];
    }

    public function map($doc): array
    {
        return [
            $doc->title ?? '-',
            $doc->type ?? '-',
            $doc->url ?? '-',
            $doc->description ?? '-',
            $doc->created_at ? $doc->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0d9488']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Dokumentasi';
    }
}

