<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        if (Auth::check() && Auth::user()->preferred_language) {
            $locale = Auth::user()->preferred_language;
        } elseif ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        } else {
            $locale = config('app.locale', 'en');
        }

        $supported = ['en', 'tl', 'ceb'];
        if (!in_array($locale, $supported)) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}