<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Menangani permintaan yang masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Ambil role dari user yang sedang login
        $userRole = Auth::user()->role;

        // 3. Jika rolenya adalah 'admin' ATAU 'super_admin', persilakan masuk
        if ($userRole === 'admin' || $userRole === 'super_admin') {
            return $next($request); // Lanjutkan ke halaman yang dituju
        }

        // 4. Jika role bukan keduanya (berarti 'santri'), kembalikan ke dashboard
        return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda bukan Admin.');
    }
}