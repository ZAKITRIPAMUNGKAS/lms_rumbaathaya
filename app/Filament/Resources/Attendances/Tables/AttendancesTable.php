<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'attendances.id',
                        'attendances.student_id',
                        'attendances.tutor_id',
                        'attendances.date',
                        'attendances.topic_taught',
                        'attendances.status',
                        'attendances.photo_evidence_path',
                        'attendances.created_at',
                        'attendances.updated_at',
                    ])
                    ->with([
                        'student:id,name',
                        'tutor:id,name',
                    ]);
            })
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50, 100])
            ->deferFilters()
            ->deferLoading()
            ->columns([
                // Kolom Nama Siswa dengan Search
                TextColumn::make('student.name')
                    ->label('Nama Sahabat RA')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'), // Tebalkan nama biar jelas

                // Kolom Tanggal
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                // Kolom Tutor
                TextColumn::make('tutor.name')
                    ->label('Tutor')
                    ->searchable()
                    ->sortable(),

                // Kolom Jurnal (Dibatasi panjangnya biar tabel ga berantakan)
                TextColumn::make('topic_taught')
                    ->label('Materi')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->topic_taught), // Show full text on hover

                // Kolom Status dengan WARNA (Visual Cue)
                TextColumn::make('status')
                    ->label('Status')
                    ->badge() // Bikin jadi bentuk kapsul/badge
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success', // Hijau
                        'permission' => 'warning',  // Kuning
                        'absent' => 'danger',  // Merah
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'present' => 'Hadir',
                        'permission' => 'Izin',
                        'absent' => 'Alpha',
                        default => $state,
                    })
                    ->sortable(),
                
                // Kolom Foto (Bisa di-preview saat di-hover)
                ImageColumn::make('photo_evidence_path')
                    ->label('Bukti')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->visibility('private'),
            ])
            ->filters([
                // Filter Tanggal (User Friendly banget buat cari absensi bulan lalu)
                Filter::make('date')
                    ->form([
                        DatePicker::make('date_from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('date_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['date_from'], fn ($q) => $q->whereDate('date', '>=', $data['date_from']))
                            ->when($data['date_until'], fn ($q) => $q->whereDate('date', '<=', $data['date_until']));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }
}
