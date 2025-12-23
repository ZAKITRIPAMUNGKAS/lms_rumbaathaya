<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PostExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function query()
    {
        return Post::orderBy('published_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Slug',
            'Kategori',
            'Status',
            'Tanggal Publikasi',
            'Tanggal Dibuat',
        ];
    }

    public function map($post): array
    {
        return [
            $post->title ?? '-',
            $post->slug ?? '-',
            $post->category ?? '-',
            $post->is_published ? 'Published' : 'Draft',
            $post->published_at ? $post->published_at->format('d/m/Y') : '-',
            $post->created_at ? $post->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563eb']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Sahabat RA';
    }
}

