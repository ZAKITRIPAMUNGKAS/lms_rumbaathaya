<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\ManageTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Testimoni';

    protected static ?string $modelLabel = 'Testimoni';

    protected static ?string $pluralModelLabel = 'Testimoni';

    public static function getNavigationGroup(): ?string
    {
        return 'Publikasi';
    }

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Informasi Testimoni')
                    ->description('Data pemberi testimoni')
                    ->icon('heroicon-m-user-circle')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nama pemberi testimoni')
                            ->columnSpan(1),

                        TextInput::make('role')
                            ->label('Peran/Jabatan')
                            ->maxLength(255)
                            ->placeholder('Contoh: Siswa SD, Orang Tua Siswa, Alumni')
                            ->columnSpan(1),

                        Select::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '⭐ 1 Bintang',
                                2 => '⭐⭐ 2 Bintang',
                                3 => '⭐⭐⭐ 3 Bintang',
                                4 => '⭐⭐⭐⭐ 4 Bintang',
                                5 => '⭐⭐⭐⭐⭐ 5 Bintang',
                            ])
                            ->default(5)
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka, semakin awal ditampilkan')
                            ->columnSpan(1),

                        Textarea::make('content')
                            ->label('Isi Testimoni')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->placeholder('Tulis testimoni di sini...')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),

                Section::make('Foto & Publikasi')
                    ->description('Upload foto dan atur publikasi')
                    ->icon('heroicon-m-photo')
                    ->schema([
                        FileUpload::make('photo_path')
                            ->label('Foto')
                            ->image()
                            ->directory('testimonials/photos')
                            ->disk('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->maxSize(2048)
                            ->helperText('Upload foto pemberi testimoni (maksimal 2MB, rasio 1:1)')
                            ->columnSpanFull(),

                        Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(true)
                            ->helperText('Aktifkan untuk menampilkan testimoni di website')
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
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('role')
                    ->label('Peran')
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn(int $state): string => str_repeat('⭐', $state))
                    ->sortable(),

                TextColumn::make('content')
                    ->label('Testimoni')
                    ->limit(50)
                    ->wrap()
                    ->searchable(),

                IconColumn::make('is_published')
                    ->label('Publikasi')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
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
            'index' => ManageTestimonials::route('/'),
        ];
    }
}
