<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StudentExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $classLevelId;

    public function __construct($classLevelId = null)
    {
        $this->classLevelId = $classLevelId;
    }

    public function query()
    {
        $query = Student::with(['user', 'classLevel']);

        if ($this->classLevelId) {
            $query->where('class_level_id', $this->classLevelId);
        }

        return $query->orderBy('name');
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Nama Panggilan',
            'Email',
            'Kelas',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'No. HP Orang Tua',
            'Asal Sekolah',
            'Program Minat',
        ];
    }

    public function map($student): array
    {
        return [
            $student->name ?? '-',
            $student->nickname ?? '-',
            $student->user->email ?? '-',
            $student->classLevel->name ?? '-',
            $student->place_of_birth ?? '-',
            $student->date_of_birth ? $student->date_of_birth->format('d/m/Y') : '-',
            $student->address ?? '-',
            $student->parent_phone ?? '-',
            $student->school_origin ?? '-',
            $student->program_interest ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1e40af']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Siswa';
    }
}

