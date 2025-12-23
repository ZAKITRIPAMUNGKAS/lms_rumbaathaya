<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\ManageStudents;
use App\Models\ClassLevel;
use App\Models\Student;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $modelLabel = 'Siswa';

    protected static ?string $pluralModelLabel = 'Siswa';

    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // Left Column (2/3 width) - Biodata & Akademik
                Section::make('Informasi Utama')
                    ->description('Data diri dan sekolah siswa')
                    ->icon('heroicon-m-user-circle')
                    ->schema([
                        // Row 1: Nama
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-user')
                            ->placeholder('Masukkan nama lengkap siswa')
                            ->columnSpan(1),
                        
                        TextInput::make('nickname')
                            ->label('Nama Panggilan')
                            ->maxLength(255)
                            ->placeholder('Nama Panggilan')
                            ->columnSpan(1),
                        
                        // Row 2: Lahir
                        TextInput::make('place_of_birth')
                            ->label('Tempat Lahir')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-map-pin')
                            ->placeholder('Kota tempat lahir')
                            ->columnSpan(1),
                        
                        DatePicker::make('date_of_birth')
                            ->label('Tanggal Lahir')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->prefixIcon('heroicon-m-calendar-days')
                            ->maxDate(now())
                            ->placeholder('Pilih tanggal lahir')
                            ->columnSpan(1),
                        
                        // Row 3: Sekolah
                        TextInput::make('school_origin')
                            ->label('Asal Sekolah')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-academic-cap')
                            ->placeholder('Nama sekolah saat ini')
                            ->columnSpan(1),
                        
                        Select::make('class_level_id')
                            ->label('Jenjang')
                            ->relationship('classLevel', 'name', fn ($query) => $query->select('id', 'name'))
                            ->required()
                            ->searchable()
                            ->preload(false)
                            ->prefixIcon('heroicon-m-academic-cap')
                            ->placeholder('Pilih jenjang kelas')
                            ->columnSpan(1),
                        
                        // Program Interest
                        Radio::make('program_interest')
                            ->label('Program Minat')
                            ->options([
                                'Calistung' => 'Calistung',
                                'Mapel SD' => 'Mapel SD',
                                'Mapel SMP' => 'Mapel SMP',
                                'Mapel SMA' => 'Mapel SMA',
                                'Tahfidz' => 'Tahfidz',
                            ])
                            ->inline()
                            ->descriptions([
                                'Calistung' => 'Membaca, Menulis, Menghitung',
                                'Mapel SD' => 'Mata Pelajaran SD',
                                'Mapel SMP' => 'Mata Pelajaran SMP',
                                'Mapel SMA' => 'Mata Pelajaran SMA',
                                'Tahfidz' => 'Hafalan Al-Qur\'an',
                            ])
                            ->columnSpanFull(),
                        
                        // Address
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->prefixIcon('heroicon-m-map-pin')
                            ->placeholder('Masukkan alamat lengkap siswa')
                            ->columnSpanFull(),
                        
                        // Parent Phone
                        TextInput::make('parent_phone')
                            ->label('No. WhatsApp Orang Tua')
                            ->required()
                            ->tel()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-phone')
                            ->placeholder('08xxxxxxxxxx')
                            ->helperText('Nomor WhatsApp untuk komunikasi dengan orang tua')
                            ->columnSpanFull(),
                        
                        // User Account (Optional)
                        Select::make('user_id')
                            ->label('Akun User (Opsional)')
                            ->relationship('user', 'name', fn ($query) => $query->where('role', 'student')->select('id', 'name'))
                            ->searchable()
                            ->preload(false)
                            ->prefixIcon('heroicon-m-user')
                            ->placeholder('Pilih akun user jika sudah ada')
                            ->helperText('Hubungkan dengan akun user jika siswa sudah memiliki akun')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),
                
                // Right Column (1/3 width) - Foto Profil
                Section::make('Foto Profil')
                    ->description('Upload foto siswa')
                    ->icon('heroicon-m-photo')
                    ->schema([
                        FileUpload::make('profile_photo_path')
                            ->label('Foto Ananda')
                            ->image()
                            ->disk('public')
                            ->directory('student-photos')
                            ->visibility('public')
                            ->nullable()
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '16:9',
                                '4:3',
                            ])
                            ->imageEditorViewportWidth('1920')
                            ->imageEditorViewportHeight('1080')
                            ->maxSize(5120)
                            ->helperText('Format: JPG, PNG, WEBP. Maksimal 5MB. Foto akan ditampilkan dalam bentuk lingkaran.')
                            ->avatar()
                            ->deletable()
                            ->downloadable()
                            ->previewable()
                            ->openable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'students.id',
                'students.name',
                'students.nickname',
                'students.user_id',
                'students.class_level_id',
                'students.program_interest',
                'students.parent_phone',
                'students.school_origin',
                'students.profile_photo_path',
                'students.created_at',
                'students.updated_at',
            ])
            ->with([
                'user:id,name,email',
                'classLevel:id,name',
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
                ImageColumn::make('profile_photo_path')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png'))
                    ->size(50),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('nickname')
                    ->label('Nama Panggilan')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('classLevel.name')
                    ->label('Jenjang')
                    ->sortable()
                    ->badge(),
                TextColumn::make('program_interest')
                    ->label('Program')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Calistung' => 'info',
                        'Mapel SD' => 'success',
                        'Mapel SMP' => 'warning',
                        'Mapel SMA' => 'danger',
                        'Tahfidz' => 'primary',
                        default => 'gray',
                    })
                    ->toggleable(),
                TextColumn::make('parent_phone')
                    ->label('No. WhatsApp')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('school_origin')
                    ->label('Asal Sekolah')
                    ->searchable()
                    ->toggleable(),
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
            'index' => ManageStudents::route('/'),
        ];
    }
}
