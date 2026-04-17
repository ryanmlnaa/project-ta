<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekStatusPenghuni
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    $penghuni = \App\Models\Penghuni::where('email', Auth::user()->emaill)->first();

    if ($penghuni && $penghuni->status == 'Tidak Aktif') {
        return redirect()->route('user.home')
            ->with('error', 'Kontrak Anda telah berakhir');
    }

    return $next($request);
}
}
