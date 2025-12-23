<?php

namespace App\Filament\Tutor\Widgets;

use App\Models\Attendance;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RecentAttendancesWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    
    // Enable lazy loading for better performance
    protected static bool $isLazy = true;
    
    protected int | string | array $columnSpan = 'full';
    
    protected ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        $tutor = Auth::user();
        
        return $table
            ->query(
                Attendance::query()
                    ->where('tutor_id', $tutor->id)
                    ->with(['student:id,name', 'schedule.subject:id,name'])
                    ->select('id', 'tutor_id', 'student_id', 'schedule_id', 'date', 'topic_taught', 'status', 'photo_evidence_path')
                    ->latest('date')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('schedule.subject.name')
                    ->label('Mata Pelajaran')
                    ->badge()
                    ->color('info')
                    ->default('N/A'),
                
                TextColumn::make('topic_taught')
                    ->label('Materi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->topic_taught),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'absent' => 'danger',
                        'permission' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'present' => 'Hadir',
                        'absent' => 'Tidak Hadir',
                        'permission' => 'Izin',
                        default => $state,
                    }),
                
                ImageColumn::make('photo_evidence_path')
                    ->label('Bukti')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->getStateUsing(function ($record) {
                        if (!$record->photo_evidence_path) {
                            return null;
                        }
                        return asset('storage/' . $record->photo_evidence_path);
                    }),
            ])
            ->heading('Jurnal Terbaru')
            ->description('10 jurnal mengajar terakhir')
            ->emptyStateHeading('Belum ada jurnal')
            ->emptyStateDescription('Jurnal mengajar akan muncul di sini setelah Anda membuat jurnal.')
            ->emptyStateIcon('heroicon-o-clipboard-document-check')
            ->deferLoading();
    }
}
