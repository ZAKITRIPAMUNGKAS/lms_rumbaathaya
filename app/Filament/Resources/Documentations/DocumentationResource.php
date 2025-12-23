<?php

namespace App\Filament\Resources\Documentations;

use App\Filament\Resources\Documentations\Pages\ManageDocumentations;
use App\Models\Documentation;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class DocumentationResource extends Resource
{
    protected static ?string $model = Documentation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Dokumentasi';

    protected static ?string $modelLabel = 'Dokumentasi';

    protected static ?string $pluralModelLabel = 'Dokumentasi';

    public static function getNavigationGroup(): ?string
    {
        return 'Publikasi';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Kegiatan Belajar Kelas SD')
                    ->helperText('Judul dokumentasi kegiatan'),
                
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->maxLength(500)
                    ->placeholder('Deskripsi singkat tentang dokumentasi ini')
                    ->nullable(),
                
                Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'photo' => 'Foto',
                        'video' => 'Video',
                    ])
                    ->required()
                    ->default('photo')
                    ->live()
                    ->helperText('Pilih tipe dokumentasi: Foto atau Video'),
                
                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Kegiatan Belajar' => 'Kegiatan Belajar',
                        'Event' => 'Event',
                        'Karya Siswa' => 'Karya Siswa',
                        'Testimoni' => 'Testimoni',
                        'Quotes' => 'Quotes',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required()
                    ->default('Kegiatan Belajar'),
                
                DatePicker::make('event_date')
                    ->label('Tanggal Kegiatan')
                    ->nullable()
                    ->default(now())
                    ->displayFormat('d/m/Y')
                    ->helperText('Tanggal kapan kegiatan ini dilakukan'),
                
                // File upload untuk foto
                FileUpload::make('file_path')
                    ->label('File Foto/Video')
                    ->disk('public')
                    ->directory('documentations')
                    ->visibility('public')
                    ->nullable()
                    ->maxSize(102400) // 100MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'video/mp4', 'video/quicktime'])
                    ->helperText('Upload foto (JPG, PNG, WEBP) atau video (MP4, MOV). Maksimal 100MB.')
                    ->deletable()
                    ->downloadable()
                    ->previewable()
                    ->openable()
                    ->visible(fn ($get) => $get('type') === 'photo'),
                
                // Video URL untuk YouTube atau video eksternal
                TextInput::make('video_url')
                    ->label('URL Video (YouTube/Lainnya)')
                    ->url()
                    ->placeholder('https://www.youtube.com/watch?v=... atau https://...')
                    ->helperText('Masukkan URL video YouTube atau video eksternal lainnya')
                    ->nullable()
                    ->visible(fn ($get) => $get('type') === 'video'),
                
                // Thumbnail untuk video
                FileUpload::make('thumbnail')
                    ->label('Thumbnail Video')
                    ->image()
                    ->disk('public')
                    ->directory('documentations/thumbnails')
                    ->visibility('public')
                    ->nullable()
                    ->maxSize(2048) // 2MB
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->helperText('Thumbnail untuk video. Format: JPG, PNG, WEBP. Maksimal 2MB.')
                    ->deletable()
                    ->downloadable()
                    ->previewable()
                    ->openable()
                    ->visible(fn ($get) => $get('type') === 'video'),
                
                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0)
                    ->helperText('Angka lebih kecil akan ditampilkan lebih dulu')
                    ->required(),
                
                Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->default(false)
                    ->helperText('Aktifkan untuk menampilkan di halaman dokumentasi'),
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
                TextEntry::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'photo' => 'success',
                        'video' => 'danger',
                        default => 'gray',
                    }),
                TextEntry::make('category')
                    ->label('Kategori'),
                TextEntry::make('event_date')
                    ->label('Tanggal Kegiatan')
                    ->date('d/m/Y'),
                ImageEntry::make('file_path')
                    ->label('File')
                    ->visible(fn ($record) => $record->type === 'photo' && $record->file_path),
                TextEntry::make('video_url')
                    ->label('URL Video')
                    ->url()
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->type === 'video' && $record->video_url),
                ImageEntry::make('thumbnail')
                    ->label('Thumbnail')
                    ->visible(fn ($record) => $record->type === 'video' && $record->thumbnail),
                TextEntry::make('is_published')
                    ->label('Status Publikasi')
                    ->formatStateUsing(fn ($state) => $state ? 'Diterbitkan' : 'Draft'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'id',
                'title',
                'type',
                'category',
                'file_path',
                'thumbnail',
                'video_url',
                'is_published',
                'event_date',
                'sort_order',
                'created_at',
                'updated_at',
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
            ->defaultSort('sort_order', 'asc')
            ->columns([
                ImageColumn::make('file_path')
                    ->label('Preview')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->getStateUsing(function ($record) {
                        if ($record->type === 'photo' && $record->file_path) {
                            return asset('storage/' . $record->file_path);
                        }
                        if ($record->type === 'video' && $record->thumbnail) {
                            return asset('storage/' . $record->thumbnail);
                        }
                        return null;
                    })
                    ->size(60),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('bold'),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'photo' => 'success',
                        'video' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'photo' => 'Foto',
                        'video' => 'Video',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('event_date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
                ToggleColumn::make('is_published')
                    ->label('Status')
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
            'index' => ManageDocumentations::route('/'),
        ];
    }
}

