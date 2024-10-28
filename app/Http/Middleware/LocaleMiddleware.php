<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }

        // Apply language direction
        if (session()->has('direction')) {
            $direction = session()->get('direction');
            view()->share('direction', $direction);
        }

        return $next($request);
    }
}
