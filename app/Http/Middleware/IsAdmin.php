<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN rolenya sama dengan 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika tidak lolos pengecekan di atas, baru munculkan error 403
        abort(403, 'ANDA TIDAK PUNYA AKSES KE HALAMAN INI.');
    }
}