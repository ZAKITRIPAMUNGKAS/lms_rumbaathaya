<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentationResource\Pages;
use App\Models\Documentation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentationResource extends Resource
{
    protected static ?string $model = Documentation::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Dokumentasi';

    protected static ?string $modelLabel = 'Dokumentasi';

    protected static ?string $pluralModelLabel = 'Dokumentasi';

    protected static ?string $navigationGroup = 'Publikasi';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dokumentasi')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Judul dokumentasi'),

                        Forms\Components\Select::make('type')
                            ->label('Tipe')
                            ->options([
                                'photo' => '📷 Foto',
                                'video' => '🎥 Video',
                                'quotes' => '💬 Quotes',
                            ])
                            ->required()
                            ->default('photo')
                            ->live()
                            ->afterStateUpdated(fn($state, Forms\Set $set) => $set('video_url', null)),

                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'Kegiatan Belajar' => 'Kegiatan Belajar',
                                'Event' => 'Event',
                                'Prestasi' => 'Prestasi',
                                'Kegiatan Siswa' => 'Kegiatan Siswa',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->searchable(),

                        Forms\Components\DatePicker::make('event_date')
                            ->label('Tanggal Kegiatan')
                            ->default(now())
                            ->displayFormat('d/m/Y'),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('Deskripsi singkat tentang dokumentasi ini'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('File & Media')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Upload Foto/File')
                            ->image()
                            ->directory('documentations/files')
                            ->disk('public')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->visible(fn(Forms\Get $get) => $get('type') === 'photo' || $get('type') === 'quotes')
                            ->helperText('Upload foto dokumentasi (maksimal 5MB)'),

                        Forms\Components\TextInput::make('video_url')
                            ->label('URL Video (YouTube)')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->visible(fn(Forms\Get $get) => $get('type') === 'video')
                            ->helperText('Paste link YouTube video'),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('documentations/thumbnails')
                            ->disk('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Upload thumbnail (opsional, untuk video atau preview)'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(true)
                            ->helperText('Aktifkan untuk menampilkan di website'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka, semakin awal ditampilkan'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Preview')
                    ->square()
                    ->defaultImageUrl(fn($record) => $record->thumbnail_url ?? url('/images/default-doc.png')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'photo' => 'success',
                        'video' => 'danger',
                        'quotes' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'photo' => '📷 Foto',
                        'video' => '🎥 Video',
                        'quotes' => '💬 Quotes',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('event_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publikasi')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('event_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'photo' => '📷 Foto',
                        'video' => '🎥 Video',
                        'quotes' => '💬 Quotes',
                    ]),

                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Kegiatan Belajar' => 'Kegiatan Belajar',
                        'Event' => 'Event',
                        'Prestasi' => 'Prestasi',
                        'Kegiatan Siswa' => 'Kegiatan Siswa',
                        'Lainnya' => 'Lainnya',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->placeholder('Semua dokumentasi')
                    ->trueLabel('Hanya yang dipublikasikan')
                    ->falseLabel('Hanya yang tidak dipublikasikan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publikasikan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each->update(['is_published' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Batalkan Publikasi')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn($records) => $records->each->update(['is_published' => false]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentations::route('/'),
            'create' => Pages\CreateDocumentation::route('/create'),
            'edit' => Pages\EditDocumentation::route('/{record}/edit'),
        ];
    }
}
