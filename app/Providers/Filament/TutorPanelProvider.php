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
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TutorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('tutor')
            ->path('tutor') // Tutor panel menggunakan path /tutor
            ->login()
            // BRANDING
            ->brandName('Rumba Athaya - Dashboard Tutor')
            ->brandLogo(asset('Logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('Logo.png'))
            
            // SKEMA WARNA (Blue untuk Tutor - Professional)
            ->colors([
                'primary' => Color::Blue,
                'danger' => Color::Red,
                'gray' => Color::Slate,
                'info' => Color::Cyan,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            
            ->font('Outfit')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->darkMode(false)
            ->discoverResources(in: app_path('Filament/Tutor/Resources'), for: 'App\Filament\Tutor\Resources')
            ->discoverPages(in: app_path('Filament/Tutor/Pages'), for: 'App\Filament\Tutor\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Tutor/Widgets'), for: 'App\Filament\Tutor\Widgets')
            ->widgets([
                \App\Filament\Tutor\Widgets\WelcomeTutorWidget::class,
                \App\Filament\Tutor\Widgets\TutorStatsOverview::class,
                \App\Filament\Tutor\Widgets\UpcomingSchedulesWidget::class,
                \App\Filament\Tutor\Widgets\RecentAttendancesWidget::class,
            ])
            ->spa(false)
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
            ->authGuard('web')
            ->authPasswordBroker('users')
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn () => view('filament.tutor.custom-styles')
            );
    }
}
