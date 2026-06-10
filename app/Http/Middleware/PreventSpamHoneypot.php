<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PreventSpamHoneypot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $fieldName
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $fieldName = 'company_name_verification')
    {
        if ($request->filled($fieldName)) {
            Log::warning('Spam bot detected via honeypot field: ' . $fieldName, [
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url'        => $request->fullUrl(),
                'input'      => $request->except([$fieldName, 'password', 'password_confirmation']),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors'  => [$fieldName => ['Spam detected. Submission rejected.']],
                    'message' => 'Spam detected.'
                ], 422);
            }

            return abort(400, 'Bad Request - Spam Detected');
        }

        return $next($request);
    }
}
