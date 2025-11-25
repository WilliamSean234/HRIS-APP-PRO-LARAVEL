<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider; 

class AuthController extends Controller
{
    /**
     * Tampilkan form login (GET /login).
     */
    public function showLoginForm()
    {
        // Asumsi file login Anda ada di resources/views/pages/login.blade.php
        return view('pages.login');
    }

    /**
     * Proses pengiriman form login (POST /login).
     */
    public function authenticate(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            // Sekarang divalidasi sebagai field 'email'
            'email' => ['required', 'email'], 
            'password' => ['required'],
        ]);
        
        // 2. Coba Autentikasi
        if (Auth::attempt($credentials)) {
            
            // Re-generate session ID untuk mencegah session fixation
            $request->session()->regenerate();
            
            // 💥 PERUBAHAN KRUSIAL: REDIRECT LANGSUNG KE 'index' 💥
            // Mengabaikan 'intended' URL yang tersimpan di sesi dan selalu mengarahkan ke rute 'index' (yaitu '/index').
            return redirect()->route('index');

        } else {
            // Jika login gagal
            throw ValidationException::withMessages([
                // Pesan error diikat ke field 'email'
                'email' => ['Email atau password salah.'], 
            ])->redirectTo(route('login'));
        }
    }

    /**
     * Proses logout (POST /logout). ---TESTINGGG
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Hapus data sesi pengguna
        
        $request->session()->invalidate(); // Invalidasi sesi saat ini
        
        $request->session()->regenerateToken(); // Buat ulang token CSRF
        
        // Redirect ke halaman login setelah logout
        return redirect(route('login'));
    }
}