<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security Headers - International Standards
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Content Security Policy (CSP)
        // Allow CDN for Phosphor Icons, jQuery, Summernote and other external resources
        $csp = [
            "default-src 'self'",
            // Script sources: Allow Alpine.js, jQuery, CDN, and Vite dev server
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://cdn.jsdelivr.net https://code.jquery.com http://localhost:5173 http://[::1]:5173",
            "script-src-elem 'self' 'unsafe-inline' https://unpkg.com https://cdn.jsdelivr.net https://code.jquery.com http://localhost:5173 http://[::1]:5173",
            // Style sources: Allow Google Fonts, CDN, inline styles, and Vite dev server
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net http://localhost:5173 http://[::1]:5173",
            "style-src-elem 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net http://localhost:5173 http://[::1]:5173",
            // Font sources: Allow Google Fonts and CDN
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net data:",
            // Image sources: Allow all HTTPS images (for storage and external images)
            "img-src 'self' data: https: blob:",
            // Connect sources: Allow API calls to CDN and Vite dev server
            "connect-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com https://cdn.jsdelivr.net http://localhost:5173 http://[::1]:5173 ws://localhost:5173 ws://[::1]:5173",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));

        // HSTS (if using HTTPS)
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }
}

