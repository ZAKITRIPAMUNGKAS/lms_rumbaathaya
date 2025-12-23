<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Jurnal Mengajar')
                    ->description('Isi jurnal kegiatan belajar mengajar hari ini')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->schema([
                        // Row 1: Context (Hidden tutor_id, Date, Time)
                        Hidden::make('tutor_id')
                            ->default(fn () => Auth::id())
                            ->dehydrated(),
                        
                        Select::make('schedule_id')
                            ->label('Jadwal')
                            ->relationship('schedule', 'id', fn ($query) => $query->where('is_active', true))
                            ->nullable()
                            ->searchable()
                            ->preload()
                            ->prefixIcon('heroicon-m-calendar-days')
                            ->placeholder('Pilih jadwal (opsional)')
                            ->helperText('Pilih jadwal jika sesuai dengan jadwal yang sudah ditetapkan')
                            ->columnSpan(1),
                        
                        DatePicker::make('date')
                            ->label('Tanggal')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->prefixIcon('heroicon-m-calendar')
                            ->placeholder('Pilih tanggal')
                            ->helperText('Tanggal kegiatan belajar mengajar')
                            ->columnSpan(2),
                        
                        // Row 2: Student Selection
                        Select::make('student_id')
                            ->label('Nama Siswa')
                            ->relationship('student', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->prefixIcon('heroicon-m-user')
                            ->placeholder('Pilih siswa')
                            ->helperText('Cari dan pilih siswa yang mengikuti les hari ini')
                            ->columnSpanFull(),
                        
                        // Row 3: Content
                        Textarea::make('topic_taught')
                            ->label('Materi Les')
                            ->required()
                            ->rows(3)
                            ->placeholder('Apa yang dipelajari hari ini?')
                            ->helperText('Jelaskan materi yang diajarkan dan topik yang dibahas')
                            ->columnSpanFull(),
                        
                        Textarea::make('student_progress_note')
                            ->label('Catatan Perkembangan Siswa')
                            ->rows(3)
                            ->placeholder('Catatan perkembangan, kesulitan, atau pencapaian siswa...')
                            ->helperText('Catatan khusus tentang perkembangan siswa (opsional)')
                            ->columnSpanFull(),
                        
                        // Row 4: Evidence
                        FileUpload::make('photo_evidence_path')
                            ->label('Dokumentasi Les')
                            ->image()
                            ->disk('public')
                            ->directory('journal-evidence')
                            ->maxSize(10240)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->imageEditorViewportWidth('1920')
                            ->imageEditorViewportHeight('1080')
                            ->helperText('Upload 1 foto kegiatan belajar (Max 10MB). Foto akan digunakan sebagai bukti dokumentasi.')
                            ->placeholder('Klik atau drag & drop untuk upload foto')
                            ->columnSpanFull(),
                        
                        // Status
                        Select::make('status')
                            ->label('Status Kehadiran')
                            ->options([
                                'present' => 'Hadir',
                                'absent' => 'Tidak Hadir',
                                'permission' => 'Izin',
                            ])
                            ->required()
                            ->default('present')
                            ->prefixIcon('heroicon-m-check-circle')
                            ->placeholder('Pilih status kehadiran')
                            ->helperText('Tandai status kehadiran siswa')
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->maxWidth('3xl')
                    ->extraAttributes([
                        'class' => 'mx-auto',
                    ]),
            ]);
    }
}
