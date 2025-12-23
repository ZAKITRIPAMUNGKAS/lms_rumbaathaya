<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages\ManagePosts;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Sahabat RA';

    protected static ?string $modelLabel = 'Post';

    protected static ?string $pluralModelLabel = 'Posts';

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
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Post::class, 'slug', ignoreRecord: true)
                    ->dehydrated(),
                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Kabar Rumba' => 'Kabar Rumba',
                        'Karya Siswa' => 'Karya Siswa',
                        'Info' => 'Info',
                    ])
                    ->required(),
                RichEditor::make('content')
                    ->label('Konten')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'undo',
                        'redo',
                    ]),
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('posts/thumbnails')
                    ->visibility('public')
                    ->nullable()
                    ->maxSize(2048)
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->helperText('Format: JPG, PNG, WEBP. Maksimal 2MB.')
                    ->deletable()
                    ->downloadable()
                    ->previewable()
                    ->openable(),
                Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->default(false),
                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->nullable()
                    ->default(now()),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Judul'),
                TextEntry::make('slug')
                    ->label('Slug'),
                TextEntry::make('category')
                    ->label('Kategori'),
                TextEntry::make('content')
                    ->label('Konten')
                    ->html(),
                ImageEntry::make('thumbnail')
                    ->label('Thumbnail'),
                TextEntry::make('is_published')
                    ->label('Status Publikasi')
                    ->formatStateUsing(fn ($state) => $state ? 'Diterbitkan' : 'Draft'),
                TextEntry::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'id',
                'title',
                'slug',
                'category',
                'thumbnail',
                'is_published',
                'published_at',
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
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->getStateUsing(function ($record) {
                        if (!$record->thumbnail) {
                            return null;
                        }
                        // Use the same method as welcome page - return full URL
                        return asset('storage/' . $record->thumbnail);
                    })
                    ->size(50),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Kabar Rumba' => 'info',
                        'Karya Siswa' => 'success',
                        'Info' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                ToggleColumn::make('is_published')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime()
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
            'index' => ManagePosts::route('/'),
        ];
    }
}


