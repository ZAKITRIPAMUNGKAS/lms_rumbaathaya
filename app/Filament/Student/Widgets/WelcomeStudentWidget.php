<?php

namespace App\Filament\Student\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeStudentWidget extends Widget
{
    protected static ?int $sort = 1;
    
    protected string $view = 'filament.student.widgets.welcome-student-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    // Matikan polling untuk performa
    protected static ?string $pollingInterval = null;

    protected function getViewData(): array
    {
        $user = Auth::user()->load('student');
        $student = $user->student;
        
        // Pastikan nama ditampilkan dengan benar
        $studentName = $student ? ($student->name ?? $user->name) : ($user->name ?? 'Siswa');
        $studentName = ucwords(strtolower(trim($studentName)));
        
        return [
            'studentName' => $studentName,
            'email' => $user->email ?? '',
        ];
    }
}

