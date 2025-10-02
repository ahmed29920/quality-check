<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        
        $locale = Session::get('locale');


        if (! $locale && $request->has('locale')) {
            $locale = $request->get('locale');
        }


        if (! $locale && $request->hasHeader('Accept-Language')) {
            $headerLocale = $request->header('Accept-Language');
            $locale = substr($headerLocale, 0, 2);
        }


        if (! $locale) {
            $locale = config('app.locale');
        }


        if (in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
