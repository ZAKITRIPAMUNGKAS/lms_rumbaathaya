<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Mapping hash anchor ke slug program untuk redirect
     */
    private function getHashToSlugMap(): array
    {
        return [
            'calistung-tk' => 'calistung-tk',
            'calistung-sd' => 'sd-kelas-1-3',
            'sd-kelas-1-3' => 'sd-kelas-1-3',
            'kelas-4-6-sd' => 'sd-kelas-4-6',
            'sd-kelas-4-6' => 'sd-kelas-4-6',
            'kelas-7-9-smp' => 'smp-kelas-7-9',
            'smp-kelas-7-9' => 'smp-kelas-7-9',
            'tahfidz' => 'kelas-tahfidz',
            'kelas-tahfidz' => 'kelas-tahfidz',
        ];
    }

    public function index(Request $request)
    {
        // Redirect to Next.js frontend products page
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        return redirect($frontendUrl . '/produk');
    }
}

