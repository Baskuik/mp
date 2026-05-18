<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Whitelist of supported locales
        $supportedLocales = ['nl', 'de', 'en'];

        // Check if locale is set in session
        if (session()->has('locale')) {
            $locale = session('locale');
            // Validate locale against whitelist
            if (in_array($locale, $supportedLocales)) {
                app()->setLocale($locale);
            } else {
                // Use default locale if invalid
                app()->setLocale(config('app.locale'));
            }
        } else {
            // Use default locale from config
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
