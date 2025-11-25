<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 

// =========================================================
// 1. RUTE GUEST (Hanya untuk pengguna yang BELUM login)
// Jika sudah login, akan dialihkan ke rute HOME ('/index').
// =========================================================
Route::middleware('guest')->group(function () {
    
    // Tampilkan Form Login (GET /login)
    // Middleware 'guest' akan redirect ke HOME jika sudah login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Proses Submit Login (POST /login)
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
    
    // Rute utama '/' akan menampilkan login jika belum terautentikasi
    Route::get('/', function () {
        return view('pages.login');
    })->name('home.guest');
});


// =========================================================
// 2. RUTE TERPROTEKSI (Hanya bisa diakses setelah login)
// Semua rute di dalam grup ini membutuhkan middleware 'auth'
// =========================================================
Route::middleware('auth')->group(function () {
    
    // RUTE UTAMA TERAUTENTIKASI (Pencocokan dengan RouteServiceProvider::HOME)
    // Route ini diakses setelah login berhasil (redirect ke '/index')
    Route::get('/index', function () {
        // Ini akan menampilkan views/pages/index.blade.php
        return view('pages.index'); 
    })->name('index'); 

    // Opsi: Jika user mengetik http://localhost:8000/, arahkan ke /index
    Route::get('/', function () {
        return redirect()->route('index');
    })->name('redirect.to.index');
    
    // Rute untuk memuat konten dinamis (AJAX content loading)
    Route::get('/content/{page}', function ($page) {
        // Memeriksa apakah file view ada di resources/views/pages/{$page}.blade.php
        if (view()->exists("pages.{$page}")) {
            // Jika ada, kirim konten view tersebut
            return view("pages.{$page}");
        }
        // Jika tidak ada, kembalikan response 404 (Not Found)
        abort(404, "Page view not found: {$page}");
    })->where('page', '[a-zA-Z0-9_-]+')->name('content.load');

    // Proses Logout (POST /logout) - Harus di dalam 'auth'
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});