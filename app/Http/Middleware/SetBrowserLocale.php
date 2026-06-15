<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetBrowserLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        } else {
            $browserLang = $request->getPreferredLanguage(['en', 'lv']);
            
            if ($browserLang) {
                app()->setLocale($browserLang);
                session()->put('locale', $browserLang);
            }
        }

        return $next($request);
    }
}