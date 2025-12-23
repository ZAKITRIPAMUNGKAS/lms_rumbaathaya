<?php

namespace App\Filament\Student\Widgets;

use App\Models\Attendance;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LatestActivitiesWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    
    // Enable lazy loading for better performance
    protected static bool $isLazy = true;
    
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    public function table(Table $table): Table
    {
        $user = Auth::user()->load('student');
        $student = $user->student;

        if (!$student) {
            return $table->query(\App\Models\Attendance::query()->whereRaw('1 = 0'));
        }

        return $table
            ->query(
                Attendance::query()
                    ->where('student_id', $student->id)
                    ->with([
                        'schedule:id,subject_id,student_id',
                        'schedule.subject:id,name',
                        'tutor:id,name'
                    ])
                    ->select('id', 'schedule_id', 'tutor_id', 'student_id', 'date', 'topic_taught', 'student_progress_note', 'photo_evidence_path', 'status')
                    ->latest('date')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('topic_taught')
                    ->label('Jurnal Materi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->topic_taught)
                    ->wrap(),
                
                Tables\Columns\ImageColumn::make('photo_evidence_path')
                    ->label('Foto Bukti')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png'))
                    ->size(50)
                    ->disk('public')
                    ->visibility('public'),
                
                Tables\Columns\TextColumn::make('status')
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
            ])
            ->recordActions([
                Action::make('viewDetail')
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn ($record) => 'Detail Jurnal - ' . $record->date->format('d M Y'))
                    ->modalContent(function ($record) {
                        return view('filament.student.widgets.attendance-detail-modal', [
                            'attendance' => $record,
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->slideOver(),
            ])
            ->defaultSort('date', 'desc')
            ->poll(null)
            ->paginated(false)
            ->deferLoading()
            ->heading('Riwayat Belajar & Jurnal')
            ->description('Daftar aktivitas belajar terbaru Anda')
            ->emptyStateHeading('Belum ada riwayat belajar')
            ->emptyStateDescription('Riwayat belajar akan muncul di sini setelah tutor membuat jurnal untuk Anda.')
            ->emptyStateIcon('heroicon-o-book-open')
            ->striped();
    }
}

