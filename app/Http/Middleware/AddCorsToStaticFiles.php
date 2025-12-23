<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCorsToStaticFiles
{
    /**
     * Handle an incoming request.
     * Add CORS headers to static files (storage/*) to allow cross-origin access.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only add CORS headers for storage files
        if ($request->is('storage/*')) {
            $allowedOrigins = [
                'http://localhost:3000',
                'http://127.0.0.1:3000',
                'http://localhost:3001',
                'http://127.0.0.1:3001',
                env('FRONTEND_URL', 'http://localhost:3000'),
            ];

            $origin = $request->headers->get('Origin');
            
            if (in_array($origin, $allowedOrigins)) {
                $response->headers->set('Access-Control-Allow-Origin', $origin);
                $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
                $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
                $response->headers->set('Access-Control-Allow-Credentials', 'true');
                $response->headers->set('Access-Control-Max-Age', '86400');
            }
        }

        return $response;
    }
}

