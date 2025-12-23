<?php

namespace App\Filament\Resources\Registrations;

use App\Filament\Resources\Registrations\Pages\ManageRegistrations;
use App\Models\Registration;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Pendaftaran';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pendaftar')
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nickname')
                            ->label('Nama Panggilan')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('birth_place')
                            ->label('Tempat Lahir')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->maxDate(now()),
                        Textarea::make('address')
                            ->label('Alamat')
                            ->required()
                            ->rows(3),
                        TextInput::make('school_name')
                            ->label('Asal Sekolah')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Program & Kontak')
                    ->schema([
                        Select::make('program')
                            ->label('Program Berprestasi')
                            ->required()
                            ->options([
                                'Calistung (TK-SD Kelas 1)' => 'Calistung (TK-SD Kelas 1)',
                                'MAPEL SD' => 'MAPEL SD',
                                'MAPEL SMP' => 'MAPEL SMP',
                                'MAPEL SMA' => 'MAPEL SMA',
                                'Tahfidz' => 'Tahfidz',
                                'Yang lain' => 'Yang lain',
                            ])
                            ->live()
                            ->afterStateUpdated(fn ($state, Set $set) => $state !== 'Yang lain' ? $set('program_other', null) : null),
                        TextInput::make('program_other')
                            ->label('Program Lainnya')
                            ->visible(fn (Get $get) => $get('program') === 'Yang lain')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Nomor Telepon/WhatsApp')
                            ->tel()
                            ->maxLength(20),
                    ])->columns(2),

                Section::make('Dokumen & Status')
                    ->schema([
                        FileUpload::make('photo')
                            ->label('Foto Ananda')
                            ->image()
                            ->disk('public')
                            ->directory('registrations/photos')
                            ->maxSize(5120)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('4:3'),
                        Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->default('pending'),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3),
                    ])->columns(2),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'id',
                'full_name',
                'nickname',
                'program',
                'program_other',
                'school_name',
                'status',
                'photo',
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
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->size(50),
                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nickname')
                    ->label('Nama Panggilan')
                    ->searchable(),
                TextColumn::make('program')
                    ->label('Program')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Calistung (TK-SD Kelas 1)' => 'info',
                        'MAPEL SD' => 'success',
                        'MAPEL SMP' => 'warning',
                        'MAPEL SMA' => 'danger',
                        'Tahfidz' => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (Registration $record) => $record->program_display),
                TextColumn::make('school_name')
                    ->label('Asal Sekolah')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),
                SelectFilter::make('program')
                    ->label('Program')
                    ->options([
                        'Calistung (TK-SD Kelas 1)' => 'Calistung (TK-SD Kelas 1)',
                        'MAPEL SD' => 'MAPEL SD',
                        'MAPEL SMP' => 'MAPEL SMP',
                        'MAPEL SMA' => 'MAPEL SMA',
                        'Tahfidz' => 'Tahfidz',
                        'Yang lain' => 'Yang lain',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Registration $record) => $record->update(['status' => 'approved']))
                    ->visible(fn (Registration $record) => $record->status === 'pending'),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Registration $record) => $record->update(['status' => 'rejected']))
                    ->visible(fn (Registration $record) => $record->status === 'pending'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->latest());
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRegistrations::route('/'),
        ];
    }
}
