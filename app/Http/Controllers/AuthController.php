<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        // Jika sudah login, arahkan sesuai role
        if (Auth::check()) {
            if (Auth::user()->isRacepackAdmin()) {
                return redirect()->route('admin.racepack');
            } elseif (Auth::user()->isDoorprizeAdmin()) {
                return redirect()->route('admin.doorprize');
            }
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        // 1. Validasi input menggunakan 'name'
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Auth::attempt akan otomatis mencocokkan 'name' dan 'password' di database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Jika berhasil, arahkan sesuai role
            if (Auth::user()->isRacepackAdmin()) {
                return redirect()->route('admin.racepack')->with('success', 'Selamat datang, ' . Auth::user()->name . '! (Petugas Racepack)');
            } elseif (Auth::user()->isDoorprizeAdmin()) {
                return redirect()->route('admin.doorprize')->with('success', 'Selamat datang, ' . Auth::user()->name . '! (Petugas Doorprize)');
            }

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . Auth::user()->name . '! (Superadmin)');
        }

        // 3. Jika gagal, kembalikan error
        return back()->withErrors([
            'name' => 'Username (Nama) atau password yang Anda masukkan salah.',
        ])->onlyInput('name');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}