<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->wajib_ganti_password) {
            // Izinkan akses ke halaman ganti password itu sendiri + logout, supaya tidak infinite redirect
            if (!$request->routeIs('bendahara.ganti-password.*') && !$request->routeIs('logout')) {
                return redirect()->route('bendahara.ganti-password.form')
                    ->withErrors(['password' => 'Kamu wajib mengganti password sebelum melanjutkan.']);
            }
        }

        return $next($request);
    }
}
