<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // =====================
    // FORM LOGIN
    // =====================
    public function showLogin()
    {
        return view('login.login');
    }

    // =====================
    // FORM REGISTER
    // =====================
    public function showRegister()
    {
        return view('login.register');
    }

    // =====================
    // REGISTER CUSTOMER
    // =====================
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
        ]);

        // Simpan password TANPA HASH
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // plain text
            'role'     => 'customer',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }

    // =====================
    // LOGIN MANUAL
    // =====================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Cari user
        $user = User::where('email', $request->email)->first();

        // Cek email dan password manual
        if (!$user || $user->password !== $request->password) {
            return back()->with('error', 'Email atau password salah');
        }

        // Login manual Laravel
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('products.index');
        }
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}