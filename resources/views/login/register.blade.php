@extends('layouts.main')

@section('title', 'Register KOPMA')

@section('content')

<section class="auth-wrapper">

    <!-- LEFT -->
    <div class="auth-left">
        <h1>
            Gabung Bersama  
            <br>KOPMA 🚀
        </h1>

        <p>
            Daftarkan akunmu dan nikmati kemudahan
            belanja di koperasi mahasiswa yang lebih
            modern, cepat, dan transparan.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
        <div class="auth-card">

            <h2>Daftar Akun</h2>
            <p>Buat akun baru untuk mulai menggunakan KOPMA</p>

            @if ($errors->any())
                <div style="color:red; font-size:14px; margin-bottom:12px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
                @csrf

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Nama lengkap" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="email@kampus.ac.id" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <button class="btn btn-primary" style="margin-top:6px;">
                    Daftar
                </button>
            </form>

            <div class="auth-footer">
                Sudah punya akun?
                <a href="{{ route('login') }}" style="color:var(--primary); font-weight:600;">
                    Login
                </a>
            </div>

        </div>
    </div>

</section>

@endsection
