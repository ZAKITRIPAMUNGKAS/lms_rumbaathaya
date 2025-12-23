<?php

namespace App\Http\Controllers\Api;

use App\Exports\AttendanceExport;
use App\Exports\ScheduleExport;
use App\Exports\StudentExport;
use App\Exports\TutorExport;
use App\Exports\ClassLevelExport;
use App\Exports\SubjectExport;
use App\Exports\MaterialExport;
use App\Exports\PostExport;
use App\Exports\DocumentationExport;
use App\Exports\TestimonialExport;
use App\Exports\JournalExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class ExportController extends BaseApiController
{
    /**
     * Export attendance data to Excel
     * GET /api/v1/admin/export/attendances
     */
    public function exportAttendances(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2020|max:2100',
            'class_level_id' => 'nullable|exists:class_levels,id',
        ]);

        $month = $validated['month'] ?? now()->month;
        $year = $validated['year'] ?? now()->year;
        $classLevelId = $validated['class_level_id'] ?? null;

        $monthName = Carbon::create($year, $month, 1)->locale('id')->monthName;
        $filename = "Laporan_Absensi_{$monthName}_{$year}" . ($classLevelId ? "_Kelas" : "") . ".xlsx";

        return Excel::download(
            new AttendanceExport($month, $year, $classLevelId),
            $filename
        );
    }

    /**
     * Export schedule data to Excel
     * GET /api/v1/admin/export/schedules
     */
    public function exportSchedules(Request $request)
    {
        $this->requireAdmin();

        $filename = "Jadwal_Kelas_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new ScheduleExport(),
            $filename
        );
    }

    /**
     * Export students data to Excel
     * GET /api/v1/admin/export/students
     */
    public function exportStudents(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'class_level_id' => 'nullable|exists:class_levels,id',
        ]);

        $classLevelId = $validated['class_level_id'] ?? null;
        $filename = "Data_Siswa_" . now()->format('Y-m-d') . ($classLevelId ? "_Kelas" : "") . ".xlsx";

        return Excel::download(
            new StudentExport($classLevelId),
            $filename
        );
    }

    /**
     * Export tutors data to Excel
     * GET /api/v1/admin/export/tutors
     */
    public function exportTutors(Request $request)
    {
        $this->requireAdmin();

        $filename = "Data_Tutor_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new TutorExport(),
            $filename
        );
    }

    /**
     * Export class levels data to Excel
     * GET /api/v1/admin/export/class-levels
     */
    public function exportClassLevels(Request $request)
    {
        $this->requireAdmin();

        $filename = "Jenjang_Kelas_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new ClassLevelExport(),
            $filename
        );
    }

    /**
     * Export subjects data to Excel
     * GET /api/v1/admin/export/subjects
     */
    public function exportSubjects(Request $request)
    {
        $this->requireAdmin();

        $filename = "Mata_Pelajaran_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new SubjectExport(),
            $filename
        );
    }

    /**
     * Export materials data to Excel
     * GET /api/v1/admin/export/materials
     */
    public function exportMaterials(Request $request)
    {
        $this->requireAdmin();

        $filename = "Materi_Konten_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new MaterialExport(),
            $filename
        );
    }

    /**
     * Export posts data to Excel
     * GET /api/v1/admin/export/posts
     */
    public function exportPosts(Request $request)
    {
        $this->requireAdmin();

        $filename = "Sahabat_RA_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new PostExport(),
            $filename
        );
    }

    /**
     * Export documentations data to Excel
     * GET /api/v1/admin/export/documentations
     */
    public function exportDocumentations(Request $request)
    {
        $this->requireAdmin();

        $filename = "Dokumentasi_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new DocumentationExport(),
            $filename
        );
    }

    /**
     * Export testimonials data to Excel
     * GET /api/v1/admin/export/testimonials
     */
    public function exportTestimonials(Request $request)
    {
        $this->requireAdmin();

        $filename = "Testimoni_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new TestimonialExport(),
            $filename
        );
    }

    /**
     * Export journals data to Excel
     * GET /api/v1/admin/export/journals
     */
    public function exportJournals(Request $request)
    {
        $this->requireAdmin();

        $filename = "Jurnal_Bimbel_" . now()->format('Y-m-d') . ".xlsx";

        return Excel::download(
            new JournalExport(),
            $filename
        );
    }
}

