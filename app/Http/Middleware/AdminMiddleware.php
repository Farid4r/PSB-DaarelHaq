<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <--- INI KUNCI JAWABANNYA

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN rolenya adalah 'admin' ATAU 'super_admin'
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            return $next($request); // Silakan masuk pak boss!
        }

        // Jika bukan keduanya (berarti santri), tendang ke dashboard santri
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
    }
}