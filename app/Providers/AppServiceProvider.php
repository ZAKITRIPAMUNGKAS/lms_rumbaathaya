<?php

namespace App\Providers;

use App\Contracts\PostRepositoryInterface;
use App\Models\Attendance;
use App\Models\Material;
use App\Models\Post;
use App\Models\Student;
use App\Models\StudentReport;
use App\Models\User;
use App\Observers\AttendanceObserver;
use App\Observers\MaterialObserver;
use App\Observers\PostObserver;
use App\Observers\StudentReportObserver;
use App\Observers\UserObserver;
use App\Policies\AttendancePolicy;
use App\Policies\MaterialPolicy;
use App\Repositories\PostRepository;
use App\Services\MaterialService;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind repository interfaces to implementations
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        
        // Bind services (they will auto-resolve their dependencies)
        $this->app->singleton(PostService::class, function ($app) {
            return new PostService($app->make(PostRepositoryInterface::class));
        });
        
        $this->app->singleton(MaterialService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(Attendance::class, AttendancePolicy::class);
        Gate::policy(Material::class, MaterialPolicy::class);
        
        // Register observers for cache invalidation
        Post::observe(PostObserver::class);
        User::observe(UserObserver::class);
        Attendance::observe(AttendanceObserver::class);
        StudentReport::observe(StudentReportObserver::class);
        Material::observe(MaterialObserver::class);
    }
}
