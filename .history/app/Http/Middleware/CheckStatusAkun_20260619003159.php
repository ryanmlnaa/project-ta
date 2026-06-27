<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatusAkun
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status_akun === 'nonaktif') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['login' => 'Akun kamu telah dinonaktifkan. Hubungi RT kamu.']);
        }

        return $next($request);
    }
}
