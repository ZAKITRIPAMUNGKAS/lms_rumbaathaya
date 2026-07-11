<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('pages.landing');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', \App\Livewire\RegistrationWizard::class)->name('register');
    Route::get('/daftar', \App\Livewire\RegistrationWizard::class)->name('daftar');
    Route::get('/pendaftaran', \App\Livewire\RegistrationWizard::class)->name('pendaftaran');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', \App\Livewire\AdminDashboard::class)->name('dashboard');

        // Students Management
        Route::get('/students', \App\Livewire\Admin\Students::class)->name('students.index');

        // Tutors Management
        Route::get('/tutors', \App\Livewire\Admin\Tutors::class)->name('tutors.index');

        // Posts Management
        Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings');
        Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
        Route::get('/posts', \App\Livewire\Admin\Posts::class)->name('posts.index');

        // Materials Management
        Route::get('/materials', \App\Livewire\Admin\Materials::class)->name('materials.index');

        // Testimonials Management
        Route::get('/testimonials', \App\Livewire\Admin\Testimonials::class)->name('testimonials.index');

        // Documentations Management
        Route::get('/documentations', \App\Livewire\Admin\Documentations::class)->name('documentations.index');

        // Schedules Management
        Route::get('/schedules', \App\Livewire\Admin\Schedules::class)->name('schedules.index');

        // Attendances Management
        Route::get('/attendances', \App\Livewire\Admin\Attendances::class)->name('attendances.index');

        // Journals Management
        Route::get('/journals', \App\Livewire\Admin\Journals::class)->name('journals.index');

        // Subjects Management
        Route::get('/subjects', \App\Livewire\Admin\Subjects::class)->name('subjects.index');

        // Class Levels Management
        Route::get('/class-levels', \App\Livewire\Admin\ClassLevels::class)->name('class-levels.index');
    });

    // Tutor Routes
    Route::middleware('role:tutor')->prefix('tutor')->name('tutor.')->group(function () {
        Route::get('/dashboard', \App\Livewire\TutorDashboard::class)->name('dashboard');

        // Materials Management
        Route::get('/materials', function () {
            return view('pages.tutor.materials.index');
        })->name('materials.index');
        Route::get('/materials/create', function () {
            return view('pages.tutor.materials.create');
        })->name('materials.create');
        Route::get('/materials/{id}/edit', function ($id) {
            return view('pages.tutor.materials.edit', ['id' => $id]);
        })->name('materials.edit');

        // Schedules Management
        Route::get('/schedules', \App\Livewire\Tutor\Schedules::class)->name('schedules.index');
        Route::get('/schedules/create', function () {
            return view('pages.tutor.schedules.create');
        })->name('schedules.create');

        // Attendance
        Route::get('/attendance', \App\Livewire\Tutor\Attendance::class)->name('attendance.index');

        // Journals
        Route::get('/journals', function () {
            return view('pages.tutor.journals');
        })->name('journals.index');

        // Reports
        Route::get('/reports', function () {
            return view('pages.tutor.reports');
        })->name('reports.index');

        // Settings
        Route::get('/settings', \App\Livewire\Tutor\Settings::class)->name('settings');

        // Quiz (Coming Soon)
        Route::get('/quiz', function () {
            return view('pages.tutor.quiz');
        })->name('quiz.index');
    });

    // Student Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', \App\Livewire\StudentDashboard::class)->name('dashboard');

        Route::get('/materials', \App\Livewire\Student\Materials::class)->name('materials.index');

        Route::get('/schedules', \App\Livewire\Student\Schedules::class)->name('schedules.index');

        Route::get('/attendances', function () {
            $frontendUrl = env('NEXT_PUBLIC_APP_URL', 'http://localhost:3002');
            return redirect($frontendUrl . '/attendance');
        })->name('attendances.index');

        Route::get('/tasks', function () {
            return view('pages.student.tasks');
        })->name('tasks.index');

        Route::get('/achievements', \App\Livewire\Student\Achievements::class)->name('achievements.index');

        Route::get('/transcript', function () {
            return view('pages.student.transcript');
        })->name('transcript.index');

        Route::get('/settings', \App\Livewire\Student\Settings::class)->name('settings.index');

        Route::get('/quiz', \App\Livewire\Student\Quiz::class)->name('quiz.index');
    });
});

// Sanctum CSRF Cookie Route (needed for API authentication)
Route::get('/sanctum/csrf-cookie', [\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show'])
    ->middleware(['web']);

// Public Blog Routes (Sahabat RA)
Route::get('/sahabat-ra', [PostController::class, 'index'])->name('posts.index');
Route::get('/sahabat-ra/{slug}', [PostController::class, 'show'])->name('posts.show');

// Program route
Route::get('/program/{slug}', [ProgramController::class, 'show'])->name('program.show');

// Public Pages Routes
Route::get('/produk', function () {
    return view('pages.products');
})->name('produk');

Route::get('/tentang-kami', function () {
    return view('pages.about');
})->name('about');

Route::get('/dokumentasi', function () {
    return view('pages.documentation');
})->name('documentation');

Route::get('/testimoni', function () {
    return view('pages.testimonials');
})->name('testimonials');

Route::get('/kontak', function () {
    return view('pages.contact');
})->name('contact');

// Chatbot API Routes (kept for backward compatibility, but should use /api/v1/chatbot)
Route::prefix('api/chatbot')->group(function () {
    Route::post('/query', [ChatbotController::class, 'query'])->name('chatbot.query');
    Route::get('/faqs', [ChatbotController::class, 'getAll'])->name('chatbot.faqs');
    Route::get('/faq/{id}', [ChatbotController::class, 'getById'])->name('chatbot.faq');
    Route::get('/suggested', [ChatbotController::class, 'getSuggested'])->name('chatbot.suggested');
});

// Storage proxy route with CORS headers (for development with PHP built-in server)
// This route handles /storage/* requests and adds CORS headers
// IMPORTANT: This route must be registered BEFORE the symlink is checked
Route::get('/storage/{path}', function ($path) {
    \Log::info('[Storage Route] Route called', [
        'path' => $path,
        'request_uri' => request()->getRequestUri(),
        'origin' => request()->headers->get('Origin'),
    ]);

    $filePath = storage_path('app/public/' . $path);

    // Security: prevent directory traversal
    $filePath = realpath($filePath);
    $storagePath = realpath(storage_path('app/public'));

    // Check if realpath succeeded and filePath is within storagePath
    if (!$filePath || !$storagePath || !str_starts_with($filePath, $storagePath)) {
        \Log::warning('[Storage Route] Path traversal attempt or invalid path', [
            'path' => $path,
            'filePath' => $filePath,
            'storagePath' => $storagePath,
        ]);
        abort(404);
    }

    if (!file_exists($filePath) || !is_file($filePath)) {
        \Log::warning('[Storage Route] File not found', [
            'path' => $path,
            'filePath' => $filePath,
        ]);
        abort(404);
    }

    $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
    $fileContent = file_get_contents($filePath);

    $origin = request()->headers->get('Origin');
    $isProduction = env('APP_ENV') === 'production';

    // CORS: Allow all origins in development, specific in production
    $allowedOrigins = !$isProduction ? ['*'] : [
        env('APP_URL'),
        // Add other allowed origins if needed
    ];

    $headers = [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000, immutable',
    ];

    // Add CORS headers
    if (in_array('*', $allowedOrigins)) {
        $headers['Access-Control-Allow-Origin'] = '*';
    } elseif ($origin && in_array($origin, $allowedOrigins)) {
        $headers['Access-Control-Allow-Origin'] = $origin;
    }
    $headers['Access-Control-Allow-Methods'] = 'GET, OPTIONS';
    $headers['Access-Control-Allow-Headers'] = 'Content-Type';

    \Log::info('[Storage Route] File served successfully', [
        'path' => $path,
        'size' => strlen($fileContent),
        'mimeType' => $mimeType,
    ]);

    return response($fileContent, 200, $headers);
})->where('path', '.*')->name('storage.proxy');

// Handle OPTIONS request for CORS preflight
Route::options('/storage/{path}', function () {
    $origin = request()->headers->get('Origin');
    $isProduction = env('APP_ENV') === 'production';

    $allowedOrigins = !$isProduction ? ['*'] : [env('APP_URL')];

    $headers = [
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type',
        'Access-Control-Max-Age' => '86400',
    ];

    if (in_array('*', $allowedOrigins)) {
        $headers['Access-Control-Allow-Origin'] = '*';
    } elseif ($origin && in_array($origin, $allowedOrigins)) {
        $headers['Access-Control-Allow-Origin'] = $origin;
        $headers['Access-Control-Allow-Credentials'] = 'true';
    }

    return response('', 200, $headers);
})->where('path', '.*');

// Download App Route
Route::get('/download', function () {
    return view('pages.download');
})->name('download');
Route::get('/unduh', function () {
    return view('pages.download');
})->name('unduh');


