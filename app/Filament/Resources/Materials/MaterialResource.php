<?php

namespace App\Filament\Resources\Materials;

use App\Filament\Resources\Materials\Pages\ManageMaterials;
use App\Models\Material;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3),
                Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name', fn ($query) => $query->select('id', 'name')->orderBy('name'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
                Select::make('class_level_id')
                    ->label('Jenjang')
                    ->relationship('classLevel', 'name', fn ($query) => $query->select('id', 'name')->orderBy('name'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
                FileUpload::make('file_path')
                    ->label('File (PDF/Doc)')
                    ->disk('public')
                    ->directory('materials')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240)
                    ->nullable(),
                TextInput::make('video_url')
                    ->label('URL Video (YouTube)')
                    ->url()
                    ->maxLength(255)
                    ->nullable(),
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
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'materials.id',
                'materials.title',
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
            'index' => ManageMaterials::route('/'),
        ];
    }
}
