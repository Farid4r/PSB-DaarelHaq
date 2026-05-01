<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Jika user belum login atau rolenya tidak sesuai dengan yang diminta
        if (!$request->user() || $request->user()->role !== $role) {
            // Tendang kembali ke halaman dashboard santri atau tampilkan error 403
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin ke halaman ini.');
        }

        return $next($request);
    }
}