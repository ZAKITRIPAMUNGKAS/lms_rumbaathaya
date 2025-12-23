<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin') // Admin panel menggunakan path /admin
            ->login()
            // 1. BRANDING (Logo & Nama)
            ->brandName('Rumba Athaya LMS')
            ->brandLogo(asset('Logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('Logo.png'))
            
            // 2. SKEMA WARNA (Modern & Fun - Amber/Orange)
            ->colors([
                'primary' => Color::Amber, // Warna Orens (Ceria/Semangat)
                'danger' => Color::Red,
                'gray' => Color::Slate,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            
            // 3. TYPOGRAPHY (Font yang enak dibaca)
            ->font('Outfit') // Font modern, download via Google Fonts otomatis oleh Filament
            
            // 4. UX IMPROVEMENTS
            ->sidebarCollapsibleOnDesktop() // Sidebar bisa dilipat biar lega
            ->maxContentWidth('full') // Pakai lebar layar penuh
            ->globalSearchKeyBindings(['command+k', 'ctrl+k']) // Shortcut search keren
            
            // 5. NAVIGASI (Grouping biar rapi)
            ->navigationGroups([
                'Akademik', // Siswa, Materi, Jadwal
                'Laporan', // Absensi, Rapor, Jurnal
                'Publikasi', // Sahabat RA (Mading)
                'Master Data', // Mapel, Jenjang
                'Pengaturan', // User Management
            ])
            ->darkMode(false)
            // Optimasi: Disable discovery untuk performa lebih cepat (jika resources sudah diketahui)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            // Optimasi: Disable unnecessary features untuk performa
            ->spa(false) // Disable SPA mode untuk load lebih cepat
            ->widgets([
                \App\Filament\Widgets\WelcomeAdminWidget::class,
                \App\Filament\Widgets\StatsOverview::class,
                AccountWidget::class,
                // FilamentInfoWidget::class, // Hide default info biar bersih
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn () => view('filament.admin.custom-styles')
            );
    }
}
