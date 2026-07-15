<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global security headers
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        
        // CORS for API routes
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
        
        // CORS for static files (storage/*)
        $middleware->web(append: [
            \App\Http\Middleware\AddCorsToStaticFiles::class,
        ]);
        
        // Use custom VerifyCsrfToken middleware that excludes API routes
        $middleware->validateCsrfTokens(except: [
            'api/*',
            '/api/*',
        ]);
        
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
        
        // Redirect authenticated users from guest routes (like login) to their dashboard
        // Only apply to web routes, not API routes
        $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
            // Don't redirect API requests
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }
            
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->role === 'admin') {
                    return route('admin.dashboard');
                } elseif ($user->role === 'tutor') {
                    return route('tutor.dashboard');
                } elseif ($user->role === 'student') {
                    return route('student.dashboard');
                }
            }
            return route('home');
        });
        
        // Redirect unauthenticated users from protected routes to login
        // Only apply to web routes, not API routes (API should return 401 JSON)
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            // Don't redirect API requests - let them return 401 JSON
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle unauthenticated exceptions for API routes
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated',
                ], 401);
            }
        });

        // 🛡️ Handle CSRF Token Mismatch Exception (Error 419)
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'CSRF token mismatch. Please refresh your token.',
                ], 419);
            }
            
            // Redirect back to login with a friendly warning message
            return redirect()
                ->route('login')
                ->with('status', 'Sesi login Anda telah berakhir demi keamanan. Silakan coba masuk kembali.');
        });
    })->create();
