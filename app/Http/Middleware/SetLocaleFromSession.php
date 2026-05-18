<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocaleFromSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Pegue o locale da sessão, ou use o padrão
        $locale = session('locale', config('app.locale'));

        // Valide o locale
        if (in_array($locale, ['nl', 'de', 'en'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
