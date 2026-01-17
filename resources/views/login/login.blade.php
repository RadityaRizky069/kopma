@extends('layouts.main')

@section('title', 'Login KOPMA')

@section('content')

<section class="auth-wrapper">

    <div class="auth-left">
        <h1>
            Selamat Datang  
            <br>Kembali 👋
        </h1>

        <p>
            Masuk ke sistem Koperasi Mahasiswa dan nikmati
            pengalaman belanja koperasi yang lebih modern,
            cepat, dan transparan.
        </p>
    </div>

    <div class="auth-right">
        <div class="auth-card">

            <h2>Login KOPMA</h2>
            <p>Masuk menggunakan akun terdaftar</p>

            <form action="{{ route('login') }}" method="POST" style="display:flex; flex-direction:column; gap:18px;">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="email@kampus.ac.id" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Masuk
                </button>
            </form>

            <div class="auth-footer">
                Belum punya akun?
                <a href="{{ route('register') }}" style="color:var(--primary); font-weight:600;">
                    Daftar sekarang
                </a>
            </div>

        </div>
    </div>

</section>

{{-- === BAGIAN SCRIPT NOTIFIKASI === --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- 1. Menangkap pesan jika dipaksa login dari Middleware (session 'failed') --}}
@if(session('failed'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Akses Dibatasi',
            text: '{{ session('failed') }}',
            confirmButtonText: 'OK, Siap Login',
            confirmButtonColor: '#28a745'
        });
    </script>
@endif

{{-- 2. Menangkap pesan jika Email/Password Salah (session 'error') --}}
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Masuk',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
    </script>
@endif

@endsection