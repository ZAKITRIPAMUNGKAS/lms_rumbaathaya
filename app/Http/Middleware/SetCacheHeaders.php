<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Set cache headers for static assets
        if ($request->is('*.css') || $request->is('*.js') || $request->is('*.png') || 
            $request->is('*.jpg') || $request->is('*.jpeg') || $request->is('*.gif') || 
            $request->is('*.svg') || $request->is('*.woff') || $request->is('*.woff2') ||
            $request->is('*.ttf') || $request->is('*.otf') || $request->is('*.webp')) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        }

        return $response;
    }
}

