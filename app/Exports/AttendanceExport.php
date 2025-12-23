<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Carbon;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $month;
    protected $year;
    protected $classLevelId;

    public function __construct($month = null, $year = null, $classLevelId = null)
    {
        $this->month = $month ?? now()->month;
        $this->year = $year ?? now()->year;
        $this->classLevelId = $classLevelId;
    }

    /**
     * Query to fetch attendance data
     */
    public function query()
    {
        $query = Attendance::query()
            ->with([
                'student:id,name,class_level_id',
                'student.classLevel:id,name',
                'schedule:id,subject_id,student_id',
                'schedule.subject:id,name',
                'tutor:id,name',
            ])
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->orderBy('date')
            ->orderBy('student_id');

        // Filter by class level if provided
        if ($this->classLevelId) {
            $query->whereHas('student', function ($q) {
                $q->where('class_level_id', $this->classLevelId);
            });
        }

        return $query;
    }

    /**
     * Headings for the Excel file
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Kelas',
            'Mata Pelajaran',
            'Status',
            'Tutor',
            'Materi yang Diajarkan',
            'Catatan Progress',
        ];
    }

    /**
     * Map each attendance record to a row
     */
    public function map($attendance): array
    {
        $statusLabels = [
            'present' => 'Hadir',
            'absent' => 'Tidak Hadir',
            'permission' => 'Izin',
            'sick' => 'Sakit',
        ];

        return [
            $attendance->date->format('d/m/Y'),
            $attendance->student->name ?? 'N/A',
            $attendance->student->classLevel->name ?? 'N/A',
            $attendance->schedule->subject->name ?? 'N/A',
            $statusLabels[$attendance->status] ?? $attendance->status,
            $attendance->tutor->name ?? 'N/A',
            $attendance->topic_taught ?? '-',
            $attendance->student_progress_note ?? '-',
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
                    'startColor' => ['rgb' => '1e40af'], // Blue-800
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
        $monthName = Carbon::create($this->year, $this->month, 1)->locale('id')->monthName;
        return "Absensi {$monthName} {$this->year}";
    }
}

