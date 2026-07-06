<?php

// Middleware визначення поточної мови сайту.
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', 'ua');
        if (!in_array($locale, ['ua', 'en'])) {
            $locale = 'ua';
        }
        App::setLocale($locale);

        return $next($request);
    }
}
