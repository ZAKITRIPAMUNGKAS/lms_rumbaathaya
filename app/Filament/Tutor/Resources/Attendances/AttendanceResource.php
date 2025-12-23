<?php

namespace App\Filament\Tutor\Resources\Attendances;

use App\Filament\Tutor\Resources\Attendances\Pages\CreateAttendance;
use App\Filament\Tutor\Resources\Attendances\Pages\EditAttendance;
use App\Filament\Tutor\Resources\Attendances\Pages\ListAttendances;
use App\Filament\Tutor\Resources\Attendances\Pages\ViewAttendance;
use App\Filament\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Resources\Attendances\Schemas\AttendanceInfolist;
use App\Filament\Resources\Attendances\Tables\AttendancesTable;
use App\Models\Attendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tutor_id', Auth::id()) // Filter by tutor_id - Tutors only see their own attendances
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
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'date';

    protected static ?string $navigationLabel = 'Jurnal Mengajar';

    protected static ?string $modelLabel = 'Jurnal';

    protected static ?string $pluralModelLabel = 'Jurnal';

    public static function getNavigationGroup(): ?string
    {
        return 'Laporan';
    }

    public static function form(Schema $schema): Schema
    {
        return AttendanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AttendanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttendancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendances::route('/'),
            'create' => CreateAttendance::route('/create'),
            'view' => ViewAttendance::route('/{record}'),
            'edit' => EditAttendance::route('/{record}/edit'),
        ];
    }
}
