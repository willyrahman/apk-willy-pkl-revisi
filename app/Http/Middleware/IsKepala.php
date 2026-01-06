<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsKepala
{
    /**
     * Menangani permintaan yang masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role 'kepala'
        if (Auth::check() && Auth::user()->role === 'kepala') {
            return $next($request);
        }

        // Jika bukan kepala, arahkan ke dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Akses ditolak! Halaman ini hanya untuk Kepala Puskesmas.');
    }
}
