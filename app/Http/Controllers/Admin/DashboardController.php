<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache stats untuk 10 menit untuk performa lebih baik
        $stats = Cache::remember('admin_dashboard_stats_controller', 600, function () {
            return [
                'total_students' => Student::count(),
                'total_tutors' => User::where('role', 'tutor')->count(),
                'total_materials' => Material::count(),
                'total_users' => User::count(),
            ];
        });
        
        // Redirect to Filament admin panel
        return redirect('/admin');
    }
}

