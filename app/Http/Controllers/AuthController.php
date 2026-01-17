<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil, silakan login sekarang');
    }

    // =====================
    // LOGIN
    // =====================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
        }

        return redirect()->route('products.index')->with('success', 'Berhasil masuk! Selamat belanja.');
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil keluar sistem');
    }
}