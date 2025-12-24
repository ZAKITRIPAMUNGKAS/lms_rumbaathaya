<?php

namespace App\Filament\Resources\Documentations;

use App\Filament\Resources\Documentations\Pages\ManageDocumentations;
use App\Models\Documentation;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentationResource extends Resource
{
    protected static ?string $model = Documentation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Dokumentasi';

    protected static ?string $modelLabel = 'Dokumentasi';

    protected static ?string $pluralModelLabel = 'Dokumentasi';

    public static function getNavigationGroup(): ?string
    {
        return 'Publikasi';
    }

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Informasi Dokumentasi')
                    ->description('Detail dokumentasi')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Judul dokumentasi')
                            ->columnSpanFull(),

                        Select::make('type')
                            ->label('Tipe')
                            ->options([
                                'photo' => 'Foto',
                                'video' => 'Video',
                                'quotes' => 'Quotes',
                            ])
                            ->required()
                            ->default('photo')
                            ->reactive()
                            ->columnSpan(1),

                        Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'kegiatan_belajar' => 'Kegiatan Belajar',
                                'event' => 'Event',
                                'prestasi' => 'Prestasi',
                                'fasilitas' => 'Fasilitas',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->columnSpan(1),

                        DatePicker::make('event_date')
                            ->label('Tanggal Event')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->columnSpan(1),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('Deskripsi singkat dokumentasi')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),

                Section::make('Media & Publikasi')
                    ->description('Upload file atau masukkan URL video')
                    ->icon('heroicon-m-photo')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('Upload Foto/File')
                            ->image()
                            ->directory('documentations')
                            ->disk('public')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->visible(fn($get) => $get('type') === 'photo' || $get('type') === 'quotes')
                            ->columnSpanFull(),

                        TextInput::make('video_url')
                            ->label('URL Video (YouTube)')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->visible(fn($get) => $get('type') === 'video')
                            ->columnSpanFull(),

                        FileUpload::make('thumbnail_path')
                            ->label('Thumbnail (Opsional)')
                            ->image()
                            ->directory('documentations/thumbnails')
                            ->disk('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->columnSpanFull(),

                        Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'asc')
            ->columns([
                ImageColumn::make('file_path')
                    ->label('Preview')
                    ->square()
                    ->defaultImageUrl(fn($record) => $record->thumbnail_url ?? url('/images/default-doc.png')),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'photo' => 'success',
                        'video' => 'danger',
                        'quotes' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'kegiatan_belajar' => 'Kegiatan Belajar',
                        'event' => 'Event',
                        'prestasi' => 'Prestasi',
                        'fasilitas' => 'Fasilitas',
                        'lainnya' => 'Lainnya',
                        default => $state,
                    }),

                TextColumn::make('event_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('Publikasi')
                    ->boolean()
                    ->sortable(),
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
            'index' => ManageDocumentations::route('/'),
        ];
    }
}
