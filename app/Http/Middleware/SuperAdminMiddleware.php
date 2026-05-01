<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya izinkan masuk jika rolenya benar-benar 'super_admin'
        if (Auth::check() && Auth::user()->role === 'super_admin') {
            return $next($request);
        }

        // Jika dia cuma admin biasa atau santri, kembalikan ke halaman sebelumnya
        return redirect()->back()->with('error', 'Halaman ini khusus untuk Super Admin.');
    }
}