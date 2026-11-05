<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Jika bukan superadmin, arahkan sesuai role
        if ($user->role === 'admin_racepack' || $user->role === 'racepack') {
            return redirect()->route('admin.racepack')
                ->with('error', 'Akses ditolak! Akun Anda adalah Petugas Racepack.');
        }

        if ($user->role === 'admin_doorprize' || $user->role === 'doorprize') {
            return redirect()->route('admin.doorprize')
                ->with('error', 'Akses ditolak! Akun Anda adalah Petugas Doorprize.');
        }

        return $next($request);
    }
}
