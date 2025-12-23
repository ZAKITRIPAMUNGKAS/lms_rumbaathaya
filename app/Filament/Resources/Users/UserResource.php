<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(User::class, 'email', ignoreRecord: true),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255)
                    ->helperText(fn (string $operation): string => $operation === 'create' ? 'Password wajib diisi' : 'Kosongkan jika tidak ingin mengubah password'),
                Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'tutor' => 'Tutor',
                        'student' => 'Siswa',
                    ])
                    ->required()
                    ->default('tutor'),
                FileUpload::make('avatar_url')
                    ->label('Foto Profil')
                    ->image()
                    ->disk('public')
                    ->directory('avatars')
                    ->nullable()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                    ]),
                Textarea::make('bio')
                    ->label('Bio/Deskripsi')
                    ->rows(3)
                    ->maxLength(500)
                    ->nullable()
                    ->helperText('Khusus untuk Tutor - deskripsi singkat tentang tutor'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'id',
                'name',
                'email',
                'role',
                'avatar_url',
                'bio',
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
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->getStateUsing(function ($record) {
                        if (!$record->avatar_url) {
                            return null;
                        }
                        // Use the same method as welcome page - return full URL
                        return asset('storage/' . $record->avatar_url);
                    })
                    ->extraAttributes(['class' => 'object-cover']),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'tutor' => 'primary',
                        'student' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Admin',
                        'tutor' => 'Tutor',
                        'student' => 'Siswa',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('bio')
                    ->label('Bio')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->bio)
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'tutor' => 'Tutor',
                        'student' => 'Siswa',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUsers::route('/'),
        ];
    }
}

