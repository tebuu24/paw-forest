<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    public function handle(Request $request, Closure $next): Response
    {
        // If user is logged in AND their database field 'is_blocked' is true
        if (Auth::check() && Auth::user()->is_blocked) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('error', 'Jūsu profils ir ticis bloķēts. / Your account has been blocked.');
        }

        return $next($request);
    }
}