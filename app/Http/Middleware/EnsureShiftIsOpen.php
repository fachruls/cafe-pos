<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureShiftIsOpen
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah user punya shift yang sedang "open"
        // Kita pakai fungsi activeShift() yang sudah dibuat di Model User tadi
        if (!Auth::user()->activeShift()->exists()) {
            // Kalau belum buka shift, tendang ke halaman Buka Shift
            return redirect()->route('shift.open');
        }

        return $next($request);
    }
}