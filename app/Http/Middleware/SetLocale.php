<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lang = Auth::user()->language;

            app()->setLocale($lang);
            session()->put('locale', $lang);
        } elseif (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}
