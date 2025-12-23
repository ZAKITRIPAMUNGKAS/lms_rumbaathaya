<?php

namespace App\Filament\Resources\Schedules;

use App\Filament\Resources\Schedules\Pages\ManageSchedules;
use App\Models\Schedule;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationLabel = 'Jadwal';

    protected static ?string $modelLabel = 'Jadwal';

    protected static ?string $pluralModelLabel = 'Jadwal';

    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tutor_id')
                    ->label('Tutor')
                    ->relationship('tutor', 'name', fn ($query) => $query->where('role', 'tutor')->select('id', 'name'))
                    ->required()
                    ->searchable()
                    ->preload(false),
                Select::make('student_id')
                    ->label('Siswa')
                    ->relationship('student', 'name', fn ($query) => $query->select('id', 'name'))
                    ->required()
                    ->searchable()
                    ->preload(false),
                Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name', fn ($query) => $query->select('id', 'name'))
                    ->required()
                    ->searchable()
                    ->preload(false),
                Select::make('day_of_week')
                    ->label('Hari')
                    ->options([
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu',
                    ])
                    ->required(),
                TimePicker::make('time_start')
                    ->label('Waktu Mulai')
                    ->required()
                    ->seconds(false),
                TimePicker::make('time_end')
                    ->label('Waktu Selesai')
                    ->required()
                    ->seconds(false),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'schedules.id',
                'schedules.tutor_id',
                'schedules.student_id',
                'schedules.subject_id',
                'schedules.day_of_week',
                'schedules.time_start',
                'schedules.time_end',
                'schedules.is_active',
                'schedules.created_at',
                'schedules.updated_at',
            ])
            ->with([
                'tutor:id,name',
                'student:id,name',
                'subject:id,name',
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50, 100])
            ->deferFilters()
            ->deferLoading()
            ->columns([
                TextColumn::make('tutor.name')
                    ->label('Tutor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->sortable(),
                TextColumn::make('day_of_week')
                    ->label('Hari')
                    ->formatStateUsing(fn ($state) => [
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu',
                    ][$state] ?? $state)
                    ->sortable(),
                TextColumn::make('time_start')
                    ->label('Mulai')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('time_end')
                    ->label('Selesai')
                    ->time('H:i')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSchedules::route('/'),
        ];
    }
}

