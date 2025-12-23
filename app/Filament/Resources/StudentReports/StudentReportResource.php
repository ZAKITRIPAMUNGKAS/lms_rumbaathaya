<?php

namespace App\Filament\Resources\StudentReports;

use App\Filament\Resources\StudentReports\Actions\DownloadPdfAction;
use App\Filament\Resources\StudentReports\Pages\ManageStudentReports;
use App\Models\StudentReport;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentReportResource extends Resource
{
    protected static ?string $model = StudentReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    protected static ?string $recordTitleAttribute = 'period';

    protected static ?string $navigationLabel = 'Laporan Progress Siswa';

    protected static ?string $modelLabel = 'Laporan Progress';

    protected static ?string $pluralModelLabel = 'Laporan Progress';

    public static function getNavigationGroup(): ?string
    {
        return 'Laporan';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                TextInput::make('score')
                    ->label('Nilai')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required()
                    ->default(0),
                TextInput::make('attendance_count')
                    ->label('Jumlah Kehadiran')
                    ->numeric()
                    ->minValue(0),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3),
                TextInput::make('period')
                    ->label('Periode')
                    ->required()
                    ->placeholder('Contoh: Desember 2024 atau Semester 1')
                    ->maxLength(255),
                DatePicker::make('report_date')
                    ->label('Tanggal Laporan')
                    ->required()
                    ->default(now()),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'student_reports.id',
                'student_reports.student_id',
                'student_reports.subject_id',
                'student_reports.score',
                'student_reports.attendance_count',
                'student_reports.period',
                'student_reports.report_date',
                'student_reports.created_at',
                'student_reports.updated_at',
            ])
            ->with([
                'student:id,name,user_id',
                'student.user:id,name',
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
            ->recordTitleAttribute('period')
            ->columns([
                TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->formatStateUsing(fn (StudentReport $record): string => 
                        $record->student->name ?? ($record->student->user->name ?? 'N/A')
                    )
                    ->sortable(),
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->sortable(),
                TextColumn::make('period')
                    ->label('Periode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('score')
                    ->label('Nilai')
                    ->badge()
                    ->color(fn (StudentReport $record): string => $record->score >= 75 ? 'success' : ($record->score >= 50 ? 'warning' : 'danger'))
                    ->sortable(),
                TextColumn::make('attendance_count')
                    ->label('Kehadiran')
                    ->sortable(),
                TextColumn::make('report_date')
                    ->label('Tanggal Laporan')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('period')
                    ->label('Periode')
                    ->options(fn () => StudentReport::query()
                        ->distinct()
                        ->pluck('period', 'period')
                        ->toArray()),
                SelectFilter::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name', fn ($query) => $query->select('id', 'name'))
                    ->searchable()
                    ->preload(false),
            ])
            ->recordActions([
                DownloadPdfAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('report_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStudentReports::route('/'),
        ];
    }
}

