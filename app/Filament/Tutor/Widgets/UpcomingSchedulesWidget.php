<?php

namespace App\Filament\Tutor\Widgets;

use App\Models\Schedule;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UpcomingSchedulesWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    
    // Enable lazy loading for better performance
    protected static bool $isLazy = true;
    
    protected int | string | array $columnSpan = 'full';
    
    protected ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        $tutor = Auth::user();
        
        return $table
            ->query(
                Schedule::query()
                    ->where('tutor_id', $tutor->id)
                    ->where('is_active', true)
                    ->with(['student:id,name', 'subject:id,name'])
                    ->select('id', 'tutor_id', 'student_id', 'subject_id', 'day_of_week', 'time_start', 'time_end', 'is_active')
                    ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                    ->orderBy('time_start')
            )
            ->columns([
                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('day_of_week')
                    ->label('Hari')
                    ->formatStateUsing(fn (string $state): string => $this->getDayName($state))
                    ->sortable(),
                
                TextColumn::make('time_start')
                    ->label('Waktu Mulai')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        // time_start is cast as datetime:H:i, so it's already a Carbon instance
                        return is_string($state) ? Carbon::parse($state)->format('H:i') : $state->format('H:i');
                    })
                    ->sortable(),
                
                TextColumn::make('time_end')
                    ->label('Waktu Selesai')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        // time_end is cast as datetime:H:i, so it's already a Carbon instance
                        return is_string($state) ? Carbon::parse($state)->format('H:i') : $state->format('H:i');
                    })
                    ->sortable(),
            ])
            ->heading('Jadwal Mengajar')
            ->description('Daftar jadwal mengajar aktif Anda')
            ->emptyStateHeading('Belum ada jadwal')
            ->emptyStateDescription('Jadwal mengajar akan muncul di sini setelah ditambahkan oleh admin.')
            ->emptyStateIcon('heroicon-o-calendar-days')
            ->deferLoading();
    }
    
    protected function getDayName(string $dayOfWeek): string
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

        return $dayNames[$dayOfWeek] ?? $dayOfWeek;
    }
}
