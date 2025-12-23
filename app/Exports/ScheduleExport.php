<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ScheduleExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    /**
     * Query to fetch schedule data
     */
    public function query()
    {
        return Schedule::query()
            ->with([
                'tutor:id,name',
                'student:id,name,class_level_id',
                'student.classLevel:id,name',
                'subject:id,name',
            ])
            ->where('is_active', true)
            ->orderBy('day_of_week')
            ->orderBy('time_start');
    }

    /**
     * Headings for the Excel file
     */
    public function headings(): array
    {
        return [
            'Hari',
            'Waktu',
            'Mata Pelajaran',
            'Tutor',
            'Nama Siswa',
            'Kelas',
            'Status',
        ];
    }

    /**
     * Map each schedule record to a row
     */
    public function map($schedule): array
    {
        $dayNames = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return [
            $dayNames[$schedule->day_of_week] ?? $schedule->day_of_week,
            $schedule->time_start . ' - ' . $schedule->time_end,
            $schedule->subject->name ?? 'N/A',
            $schedule->tutor->name ?? 'N/A',
            $schedule->student->name ?? 'N/A',
            $schedule->student->classLevel->name ?? 'N/A',
            $schedule->is_active ? 'Aktif' : 'Tidak Aktif',
        ];
    }

    /**
     * Apply styles to the Excel file
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '059669'], // Green-600
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Sheet title
     */
    public function title(): string
    {
        return 'Jadwal Kelas';
    }
}

