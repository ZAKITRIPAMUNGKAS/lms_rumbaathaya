<?php

namespace App\Filament\Student\Resources\Materials;

use App\Models\Material;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Materi';

    protected static ?string $modelLabel = 'Materi';

    protected static ?string $pluralModelLabel = 'Materi';

    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function getEloquentQuery(): Builder
    {
        // Students can view all materials (no filter)
        return parent::getEloquentQuery()
            ->select([
                'materials.id',
                'materials.title',
                'materials.description',
                'materials.file_path',
                'materials.video_url',
                'materials.subject_id',
                'materials.class_level_id',
                'materials.uploaded_by',
                'materials.created_at',
                'materials.updated_at',
            ])
            ->with([
                'subject:id,name',
                'classLevel:id,name',
                'uploader:id,name',
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        // Students cannot create/edit materials, but we need a form for view
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->disabled(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Judul'),
                TextEntry::make('description')
                    ->label('Deskripsi'),
                TextEntry::make('subject.name')
                    ->label('Mata Pelajaran'),
                TextEntry::make('classLevel.name')
                    ->label('Jenjang'),
                TextEntry::make('uploader.name')
                    ->label('Diupload Oleh'),
                TextEntry::make('file_path')
                    ->label('File')
                    ->formatStateUsing(fn ($state) => $state ? basename($state) : '-'),
                TextEntry::make('video_url')
                    ->label('URL Video')
                    ->url(fn ($record) => $record->video_url)
                    ->openUrlInNewTab(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->paginated([10, 25, 50, 100])
            ->deferFilters()
            ->deferLoading()
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->sortable(),
                TextColumn::make('classLevel.name')
                    ->label('Jenjang')
                    ->sortable(),
                TextColumn::make('uploader.name')
                    ->label('Diupload Oleh')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('download')
                    ->label('Download File')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->visible(fn ($record) => !empty($record->file_path))
                    ->action(function ($record) {
                        if ($record->file_path && Storage::disk('public')->exists($record->file_path)) {
                            return Storage::disk('public')->download($record->file_path);
                        }
                    })
                    ->requiresConfirmation(false),
            ])
            ->toolbarActions([
                // No create/edit/delete for students
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Student\Resources\Materials\Pages\ListMaterials::route('/'),
            'view' => \App\Filament\Student\Resources\Materials\Pages\ViewMaterial::route('/{record}'),
        ];
    }

    // Disable create/edit/delete for students
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
