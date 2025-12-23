<?php

namespace App\Exports;

use App\Models\Testimonial;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TestimonialExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function query()
    {
        return Testimonial::orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Role',
            'Komentar',
            'Rating',
            'Status',
            'Tanggal Dibuat',
        ];
    }

    public function map($testimonial): array
    {
        return [
            $testimonial->name ?? '-',
            $testimonial->role ?? '-',
            $testimonial->content ?? '-',
            $testimonial->rating ?? '-',
            $testimonial->is_published ? 'Published' : 'Draft',
            $testimonial->created_at ? $testimonial->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f59e0b']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Testimoni';
    }
}

