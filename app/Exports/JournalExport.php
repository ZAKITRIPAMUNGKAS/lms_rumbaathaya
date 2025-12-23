<?php

namespace App\Exports;

use App\Models\BimbelJournal;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class JournalExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function query()
    {
        return BimbelJournal::with(['tutor', 'schedule'])
            ->orderBy('date', 'desc')
            ->orderBy('time');
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Waktu',
            'Tutor',
            'Materi',
            'Jadwal',
            'Tanggal Dibuat',
        ];
    }

    public function map($journal): array
    {
        return [
            $journal->date ? $journal->date->format('d/m/Y') : '-',
            $journal->time ?? '-',
            $journal->tutor->name ?? '-',
            $journal->material ?? '-',
            $journal->schedule ? "Schedule #{$journal->schedule->id}" : '-',
            $journal->created_at ? $journal->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '8b5cf6']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Jurnal Bimbel';
    }
}

