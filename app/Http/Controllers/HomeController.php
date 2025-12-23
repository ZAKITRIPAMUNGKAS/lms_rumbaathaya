<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __construct(
        private PostService $postService
    ) {}

    public function index()
    {
        // Redirect to Next.js frontend
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        return redirect($frontendUrl);
    }
}
