<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\StudentReport;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.student')]
class Achievements extends Component
{
    public function render()
    {
        $user = Auth::user();
        $student = $user->student;

        $reports = $student
            ? StudentReport::where('student_id', $student->id)
                ->orderBy('created_at', 'desc')
                ->get()
            : collect();

        // Calculate achievements from reports
        $totalReports = $reports->count();
        $averageScore = $totalReports > 0 ? $reports->avg('score') : 0;
        $highestScore = $totalReports > 0 ? $reports->max('score') : 0;
        $completedMaterials = $student ? Material::where('class_level_id', $student->class_level_id)->count() : 0;

        // Badges Logic
        $badges = [
            ['name' => 'Pemula', 'icon' => 'star', 'earned' => true, 'desc' => 'Selamat datang!'],
            ['name' => 'Rajin', 'icon' => 'books', 'earned' => $totalReports >= 5, 'desc' => '5 Laporan'],
            ['name' => 'Juara', 'icon' => 'trophy', 'earned' => $highestScore >= 90, 'desc' => 'Nilai 90+'],
            ['name' => 'Konsisten', 'icon' => 'trend-up', 'earned' => $totalReports >= 10, 'desc' => '10 Laporan'],
            ['name' => 'Sempurna', 'icon' => 'medal', 'earned' => $highestScore >= 100, 'desc' => 'Nilai 100'],
            ['name' => 'Master', 'icon' => 'crown', 'earned' => $totalReports >= 20 && $averageScore >= 85, 'desc' => '20 Laporan & Rata-rata 85+'],
        ];

        return view('livewire.student.achievements', [
            'reports' => $reports,
            'stats' => [
                'average' => $averageScore,
                'highest' => $highestScore,
                'reports' => $totalReports,
                'materials' => $completedMaterials
            ],
            'badges' => $badges,
        ]);
    }
}
