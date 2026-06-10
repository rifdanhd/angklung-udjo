<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
   public function handle(Request $request, Closure $next)
{
    // Prioritas: session -> config default
    $locale = session('locale', config('app.locale', 'id'));

    if (! in_array($locale, ['en', 'id'])) {
        $locale = 'id';
    }

    App::setLocale($locale);

    return $next($request);
}

}