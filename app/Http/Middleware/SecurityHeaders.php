<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        header_remove('X-Powered-By');
        $response->headers->set(
            'Strict-Transport-Security',
            'max-age=31536000; includeSubDomains; preload'
        );
        $response->headers->set(
            'X-Frame-Options',
            'SAMEORIGIN'
        );
        $response->headers->set(
            'X-Content-Type-Options',
            'nosniff'
        );
        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );
        $response->headers->set(
            'Permissions-Policy',
            'geolocation=(), microphone=(), camera=()'
        );
     $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' " .
            "cdnjs.cloudflare.com cdn.jsdelivr.net " .
            "cdn.tailwindcss.com unpkg.com " .
            "www.googletagmanager.com www.google-analytics.com; " .
            "style-src 'self' 'unsafe-inline' fonts.googleapis.com cdn.tailwindcss.com cdn.jsdelivr.net; " . // <-- TAMBAHKAN cdn.jsdelivr.net DI SINI
            "font-src 'self' fonts.gstatic.com; " .
            "img-src 'self' data: https:; " .
            "frame-src 'self' www.google.com www.youtube.com; " .
            "connect-src 'self' www.google-analytics.com;"
        );
        return $response;
    }
}