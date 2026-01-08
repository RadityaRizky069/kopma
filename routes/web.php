<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 1. ROUTE UTAMA (Landing Page & Dashboard gabung disini)
Route::get('/', function () {
    // Pastikan file blade gabungan tadi namanya 'home.blade.php'
    // dan posisinya langsung di folder resources/views/
    return view('home'); 
})->name('home');


// 2. ROUTE LOGIN (MENAMPILKAN FORM)
Route::get('/login', function () {
    return view('login.login'); // Sesuaikan dengan lokasi file blade login kamu
})->name('login')->middleware('guest');


// 3. ROUTE PROSES LOGIN (MENANGKAP DATA INPUT)
// Ini yang kurang. Tanpa ini, tombol login tidak akan berfungsi.
Route::post('/login', function (Request $request) {
    // Validasi input
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Coba Login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // KUNCI: Redirect ke '/' supaya masuk ke Dashboard
        return redirect()->intended('/');
    }

    // Kalau gagal, balikin ke halaman login dengan error
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
});


// 4. ROUTE REGISTER (MENAMPILKAN FORM)
Route::get('/register', function () {
    return view('login.register');
})->name('register')->middleware('guest');

// (Opsional) Kamu juga butuh Route POST Register untuk menyimpan user baru
// Route::post('/register', ... ); 


// 5. ROUTE LOGOUT
// Wajib ada karena di Navbar tadi kita buat tombol Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');