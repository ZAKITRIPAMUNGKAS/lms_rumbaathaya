<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TutorController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\DocumentationController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Health check endpoint (no rate limit, no auth)
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Backend server is running',
        'timestamp' => now()->toIso8601String(),
    ]);
})->name('api.health');

// Public API routes (no authentication required)
// Rate limiting: 60 requests per minute
Route::prefix('v1')->middleware(['throttle:60,1'])->group(function () {
    // Health check
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'message' => 'API is running',
            'timestamp' => now()->toIso8601String(),
        ]);
    })->name('api.v1.health');
    
    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('api.posts.index');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('api.posts.show');
    
    // Tutors
    Route::get('/tutors', [TutorController::class, 'index'])->name('api.tutors.index');
    Route::get('/tutors/{tutor}', [TutorController::class, 'show'])->name('api.tutors.show');
    
    // Materials
    Route::get('/materials', [MaterialController::class, 'index'])->name('api.materials.index');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('api.materials.show');
    
    // Programs
    Route::get('/programs', [ProgramController::class, 'index'])->name('api.programs.index');
    Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('api.programs.show');
    
    // Documentation
    Route::get('/documentation', [DocumentationController::class, 'index'])->name('api.documentation.index');
    
    // Testimonials (public - only published)
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('api.testimonials.index');
    
    // Authentication (no rate limit)
    // Note: Login endpoint needs session middleware for API authentication
    Route::middleware(['web'])->group(function () {
        Route::post('/auth/login', [AuthController::class, 'login'])->name('api.auth.login');
    });
    
    // Registration (separate rate limit: 5 per minute)
    Route::middleware(['throttle:5,1'])->group(function () {
        Route::post('/registration', [\App\Http\Controllers\Api\RegistrationController::class, 'store'])->name('api.registration.store');
    });
    
    // Chatbot (separate rate limit: 10 per minute)
    Route::middleware(['throttle:10,1'])->group(function () {
        Route::post('/chatbot/query', [ChatbotController::class, 'query'])->name('api.chatbot.query');
    });
    
    Route::get('/chatbot/faqs', [ChatbotController::class, 'getAll'])->name('api.chatbot.faqs');
    Route::get('/chatbot/faq/{id}', [ChatbotController::class, 'getById'])->name('api.chatbot.faq');
    Route::get('/chatbot/suggested', [ChatbotController::class, 'getSuggested'])->name('api.chatbot.suggested');
});

// Protected API routes (authentication required)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // User info
    Route::get('/auth/user', [AuthController::class, 'user'])->name('api.auth.user');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    
    // Sync session for API access (requires web middleware for session)
    Route::middleware(['web'])->group(function () {
        Route::post('/auth/sync-session', [AuthController::class, 'syncSession'])->name('api.auth.sync-session');
    });
    
    // Student Dashboard
    Route::get('/student/stats', [\App\Http\Controllers\Api\StudentDashboardController::class, 'stats'])->name('api.student.stats');
    Route::get('/student/schedules', [\App\Http\Controllers\Api\StudentDashboardController::class, 'schedules'])->name('api.student.schedules');
    Route::get('/student/activities', [\App\Http\Controllers\Api\StudentDashboardController::class, 'activities'])->name('api.student.activities');
    
    // Student Attendances
    Route::get('/student/attendances', [\App\Http\Controllers\Api\StudentAttendanceController::class, 'index'])->name('api.student.attendances.index');
    Route::get('/student/attendances/{id}', [\App\Http\Controllers\Api\StudentAttendanceController::class, 'show'])->name('api.student.attendances.show');
    
    // Admin Dashboard
    Route::get('/admin/stats', [\App\Http\Controllers\Api\AdminDashboardController::class, 'stats'])->name('api.admin.stats');
    Route::get('/admin/activities', [\App\Http\Controllers\Api\AdminDashboardController::class, 'activities'])->name('api.admin.activities');
    Route::get('/admin/charts', [\App\Http\Controllers\Api\AdminDashboardController::class, 'charts'])->name('api.admin.charts');
    
    // Admin CRUD Operations (only for admin role - check in controllers)
    Route::prefix('admin')->group(function () {
        // Students
        Route::get('/students', [\App\Http\Controllers\Api\AdminStudentController::class, 'index'])->name('api.admin.students.index');
        Route::get('/students/options', [\App\Http\Controllers\Api\AdminStudentController::class, 'options'])->name('api.admin.students.options');
        Route::get('/students/{id}', [\App\Http\Controllers\Api\AdminStudentController::class, 'show'])->name('api.admin.students.show');
        Route::post('/students', [\App\Http\Controllers\Api\AdminStudentController::class, 'store'])->name('api.admin.students.store');
        Route::put('/students/{id}', [\App\Http\Controllers\Api\AdminStudentController::class, 'update'])->name('api.admin.students.update');
        Route::delete('/students/{id}', [\App\Http\Controllers\Api\AdminStudentController::class, 'destroy'])->name('api.admin.students.destroy');
        
        // Tutors
        Route::get('/tutors', [\App\Http\Controllers\Api\AdminTutorController::class, 'index'])->name('api.admin.tutors.index');
        Route::get('/tutors/{id}', [\App\Http\Controllers\Api\AdminTutorController::class, 'show'])->name('api.admin.tutors.show');
        Route::post('/tutors', [\App\Http\Controllers\Api\AdminTutorController::class, 'store'])->name('api.admin.tutors.store');
        Route::put('/tutors/{id}', [\App\Http\Controllers\Api\AdminTutorController::class, 'update'])->name('api.admin.tutors.update');
        Route::delete('/tutors/{id}', [\App\Http\Controllers\Api\AdminTutorController::class, 'destroy'])->name('api.admin.tutors.destroy');
        
        // Materials
        Route::get('/materials', [\App\Http\Controllers\Api\AdminMaterialController::class, 'index'])->name('api.admin.materials.index');
        Route::get('/materials/options', [\App\Http\Controllers\Api\AdminMaterialController::class, 'options'])->name('api.admin.materials.options');
        Route::get('/materials/{id}', [\App\Http\Controllers\Api\AdminMaterialController::class, 'show'])->name('api.admin.materials.show');
        Route::post('/materials', [\App\Http\Controllers\Api\AdminMaterialController::class, 'store'])->name('api.admin.materials.store');
        Route::put('/materials/{id}', [\App\Http\Controllers\Api\AdminMaterialController::class, 'update'])->name('api.admin.materials.update');
        Route::delete('/materials/{id}', [\App\Http\Controllers\Api\AdminMaterialController::class, 'destroy'])->name('api.admin.materials.destroy');
        
        // Posts (Sahabat RA)
        Route::get('/posts', [\App\Http\Controllers\Api\AdminPostController::class, 'index'])->name('api.admin.posts.index');
        Route::get('/posts/{id}', [\App\Http\Controllers\Api\AdminPostController::class, 'show'])->name('api.admin.posts.show');
        Route::post('/posts', [\App\Http\Controllers\Api\AdminPostController::class, 'store'])->name('api.admin.posts.store');
        Route::put('/posts/{id}', [\App\Http\Controllers\Api\AdminPostController::class, 'update'])->name('api.admin.posts.update');
        Route::delete('/posts/{id}', [\App\Http\Controllers\Api\AdminPostController::class, 'destroy'])->name('api.admin.posts.destroy');
        
        // Documentation
        Route::get('/documentations', [\App\Http\Controllers\Api\AdminDocumentationController::class, 'index'])->name('api.admin.documentations.index');
        Route::get('/documentations/{id}', [\App\Http\Controllers\Api\AdminDocumentationController::class, 'show'])->name('api.admin.documentations.show');
        Route::post('/documentations', [\App\Http\Controllers\Api\AdminDocumentationController::class, 'store'])->name('api.admin.documentations.store');
        Route::put('/documentations/{id}', [\App\Http\Controllers\Api\AdminDocumentationController::class, 'update'])->name('api.admin.documentations.update');
        Route::delete('/documentations/{id}', [\App\Http\Controllers\Api\AdminDocumentationController::class, 'destroy'])->name('api.admin.documentations.destroy');
        
        // Testimonials
        Route::get('/testimonials', [\App\Http\Controllers\Api\AdminTestimonialController::class, 'index'])->name('api.admin.testimonials.index');
        Route::get('/testimonials/{id}', [\App\Http\Controllers\Api\AdminTestimonialController::class, 'show'])->name('api.admin.testimonials.show');
        Route::post('/testimonials', [\App\Http\Controllers\Api\AdminTestimonialController::class, 'store'])->name('api.admin.testimonials.store');
        Route::put('/testimonials/{id}', [\App\Http\Controllers\Api\AdminTestimonialController::class, 'update'])->name('api.admin.testimonials.update');
        Route::delete('/testimonials/{id}', [\App\Http\Controllers\Api\AdminTestimonialController::class, 'destroy'])->name('api.admin.testimonials.destroy');
        
        // Schedules
        Route::get('/schedules', [\App\Http\Controllers\Api\AdminScheduleController::class, 'index'])->name('api.admin.schedules.index');
        Route::get('/schedules/options', [\App\Http\Controllers\Api\AdminScheduleController::class, 'options'])->name('api.admin.schedules.options');
        Route::get('/schedules/{id}', [\App\Http\Controllers\Api\AdminScheduleController::class, 'show'])->name('api.admin.schedules.show');
        Route::post('/schedules', [\App\Http\Controllers\Api\AdminScheduleController::class, 'store'])->name('api.admin.schedules.store');
        Route::put('/schedules/{id}', [\App\Http\Controllers\Api\AdminScheduleController::class, 'update'])->name('api.admin.schedules.update');
        Route::delete('/schedules/{id}', [\App\Http\Controllers\Api\AdminScheduleController::class, 'destroy'])->name('api.admin.schedules.destroy');
        
        // Attendances
        Route::get('/attendances', [\App\Http\Controllers\Api\AdminAttendanceController::class, 'index'])->name('api.admin.attendances.index');
        Route::get('/attendances/{id}', [\App\Http\Controllers\Api\AdminAttendanceController::class, 'show'])->name('api.admin.attendances.show');
        
        // Exports
        Route::get('/export/attendances', [\App\Http\Controllers\Api\ExportController::class, 'exportAttendances'])->name('api.admin.export.attendances');
        Route::get('/export/schedules', [\App\Http\Controllers\Api\ExportController::class, 'exportSchedules'])->name('api.admin.export.schedules');
        Route::get('/export/students', [\App\Http\Controllers\Api\ExportController::class, 'exportStudents'])->name('api.admin.export.students');
        Route::get('/export/tutors', [\App\Http\Controllers\Api\ExportController::class, 'exportTutors'])->name('api.admin.export.tutors');
        Route::get('/export/class-levels', [\App\Http\Controllers\Api\ExportController::class, 'exportClassLevels'])->name('api.admin.export.class-levels');
        Route::get('/export/subjects', [\App\Http\Controllers\Api\ExportController::class, 'exportSubjects'])->name('api.admin.export.subjects');
        Route::get('/export/materials', [\App\Http\Controllers\Api\ExportController::class, 'exportMaterials'])->name('api.admin.export.materials');
        Route::get('/export/posts', [\App\Http\Controllers\Api\ExportController::class, 'exportPosts'])->name('api.admin.export.posts');
        Route::get('/export/documentations', [\App\Http\Controllers\Api\ExportController::class, 'exportDocumentations'])->name('api.admin.export.documentations');
        Route::get('/export/testimonials', [\App\Http\Controllers\Api\ExportController::class, 'exportTestimonials'])->name('api.admin.export.testimonials');
        Route::get('/export/journals', [\App\Http\Controllers\Api\ExportController::class, 'exportJournals'])->name('api.admin.export.journals');
        
        // Class Levels
        Route::get('/class-levels', [\App\Http\Controllers\Api\AdminClassLevelController::class, 'index'])->name('api.admin.class-levels.index');
        Route::get('/class-levels/{id}', [\App\Http\Controllers\Api\AdminClassLevelController::class, 'show'])->name('api.admin.class-levels.show');
        Route::post('/class-levels', [\App\Http\Controllers\Api\AdminClassLevelController::class, 'store'])->name('api.admin.class-levels.store');
        Route::put('/class-levels/{id}', [\App\Http\Controllers\Api\AdminClassLevelController::class, 'update'])->name('api.admin.class-levels.update');
        Route::delete('/class-levels/{id}', [\App\Http\Controllers\Api\AdminClassLevelController::class, 'destroy'])->name('api.admin.class-levels.destroy');
        
        // Subjects
        Route::get('/subjects', [\App\Http\Controllers\Api\AdminSubjectController::class, 'index'])->name('api.admin.subjects.index');
        Route::get('/subjects/{id}', [\App\Http\Controllers\Api\AdminSubjectController::class, 'show'])->name('api.admin.subjects.show');
        Route::post('/subjects', [\App\Http\Controllers\Api\AdminSubjectController::class, 'store'])->name('api.admin.subjects.store');
        Route::put('/subjects/{id}', [\App\Http\Controllers\Api\AdminSubjectController::class, 'update'])->name('api.admin.subjects.update');
        Route::delete('/subjects/{id}', [\App\Http\Controllers\Api\AdminSubjectController::class, 'destroy'])->name('api.admin.subjects.destroy');
        
        // Journals (Jurnal Bimbel) - Admin can only view
        Route::get('/journals', [\App\Http\Controllers\Api\AdminJournalController::class, 'index'])->name('api.admin.journals.index');
        Route::get('/journals/options', [\App\Http\Controllers\Api\AdminJournalController::class, 'options'])->name('api.admin.journals.options');
        Route::get('/journals/{id}', [\App\Http\Controllers\Api\AdminJournalController::class, 'show'])->name('api.admin.journals.show');
    });
    
    // Tutor Dashboard
    Route::get('/tutor/stats', [\App\Http\Controllers\Api\TutorDashboardController::class, 'stats'])->name('api.tutor.stats');
    Route::get('/tutor/schedules', [\App\Http\Controllers\Api\TutorDashboardController::class, 'schedules'])->name('api.tutor.schedules');
    // Options route must come before {id} route to avoid route conflict
    Route::get('/tutor/schedules/options', [\App\Http\Controllers\Api\TutorDashboardController::class, 'scheduleOptions'])->name('api.tutor.schedules.options');
    Route::post('/tutor/schedules', [\App\Http\Controllers\Api\TutorDashboardController::class, 'store'])->name('api.tutor.schedules.store');
    Route::put('/tutor/schedules/{id}', [\App\Http\Controllers\Api\TutorDashboardController::class, 'update'])->name('api.tutor.schedules.update');
    Route::delete('/tutor/schedules/{id}', [\App\Http\Controllers\Api\TutorDashboardController::class, 'destroy'])->name('api.tutor.schedules.destroy');
    Route::get('/tutor/schedules/{id}/students', [\App\Http\Controllers\Api\TutorDashboardController::class, 'scheduleStudents'])->name('api.tutor.schedules.students');
    Route::get('/tutor/activity', [\App\Http\Controllers\Api\TutorDashboardController::class, 'activity'])->name('api.tutor.activity');
    Route::get('/tutor/reports', [\App\Http\Controllers\Api\TutorDashboardController::class, 'reports'])->name('api.tutor.reports');
    
    // Backward compatibility routes
    Route::get('/tutor/upcoming-classes', [\App\Http\Controllers\Api\TutorDashboardController::class, 'upcomingClasses'])->name('api.tutor.upcoming-classes');
    Route::get('/tutor/weekly-activity', [\App\Http\Controllers\Api\TutorDashboardController::class, 'weeklyActivity'])->name('api.tutor.weekly-activity');
    
    // Tutor Materials
    Route::get('/tutor/materials', [\App\Http\Controllers\Api\TutorMaterialController::class, 'index'])->name('api.tutor.materials.index');
    Route::get('/tutor/materials/options', [\App\Http\Controllers\Api\TutorMaterialController::class, 'options'])->name('api.tutor.materials.options');
    Route::get('/tutor/materials/{id}', [\App\Http\Controllers\Api\TutorMaterialController::class, 'show'])->name('api.tutor.materials.show');
    Route::post('/tutor/materials', [\App\Http\Controllers\Api\TutorMaterialController::class, 'store'])->name('api.tutor.materials.store');
    Route::put('/tutor/materials/{id}', [\App\Http\Controllers\Api\TutorMaterialController::class, 'update'])->name('api.tutor.materials.update');
    Route::delete('/tutor/materials/{id}', [\App\Http\Controllers\Api\TutorMaterialController::class, 'destroy'])->name('api.tutor.materials.destroy');
    
    // Tutor Attendances
    Route::post('/tutor/attendances', [\App\Http\Controllers\Api\TutorAttendanceController::class, 'store'])->name('api.tutor.attendances.store');
    
    // Student Materials
    Route::get('/student/materials', [\App\Http\Controllers\Api\StudentMaterialController::class, 'index'])->name('api.student.materials.index');
    Route::get('/student/materials/{id}', [\App\Http\Controllers\Api\StudentMaterialController::class, 'show'])->name('api.student.materials.show');
    Route::get('/student/materials/{id}/download', [\App\Http\Controllers\Api\StudentMaterialController::class, 'download'])->name('api.student.materials.download');
    
    // Tutor Journals (Tutors manage their own journals)
    Route::prefix('tutor')->group(function () {
        Route::get('/journals', [\App\Http\Controllers\Api\TutorJournalController::class, 'index'])->name('api.tutor.journals.index');
        Route::get('/journals/{id}', [\App\Http\Controllers\Api\TutorJournalController::class, 'show'])->name('api.tutor.journals.show');
        Route::post('/journals', [\App\Http\Controllers\Api\TutorJournalController::class, 'store'])->name('api.tutor.journals.store');
        Route::put('/journals/{id}', [\App\Http\Controllers\Api\TutorJournalController::class, 'update'])->name('api.tutor.journals.update');
        Route::delete('/journals/{id}', [\App\Http\Controllers\Api\TutorJournalController::class, 'destroy'])->name('api.tutor.journals.destroy');
    });
});
