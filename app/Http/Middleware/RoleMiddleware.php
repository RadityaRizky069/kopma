<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. CEK: Apakah user BELUM login? (Guest)
        // Ini menggantikan tugas middleware 'auth' bawaan
        if (!auth()->check()) {
            return redirect()->route('login')->with('failed', 'Silakan login terlebih dahulu untuk mengakses fitur ini.');
        }

        // 2. CEK: Apakah user SUDAH login tapi ROLE-nya tidak sesuai?
        if (auth()->user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}