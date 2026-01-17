@extends('layouts.main')

@section('title', 'Login - Koperasi Mahasiswa')

@section('content')
<section class="auth-wrapper">

    <div class="auth-left">
        <div style="z-index: 2; position: relative;">
            <h1 style="margin-bottom: 16px;">
                Selamat Datang 
                <br>Kembali 👋
            </h1>

            <p style="margin-bottom: 40px; color: rgba(255,255,255,0.8);">
                Masuk ke sistem Koperasi Mahasiswa untuk akses belanja, 
                pantau simpanan, dan nikmati layanan digital transparan 
                langsung dari genggaman Anda.
            </p>

            <div class="floating-card" style="max-width: 320px;">
                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 10px;">
                    <div style="width: 10px; height: 10px; background: #22C55E; border-radius: 50%;"></div>
                    <span style="font-weight: 700; font-size: 14px; letter-spacing: 0.5px;">SISTEM AKTIF</span>
                </div>
                <p style="font-size: 13px; line-height: 1.5; opacity: 0.9;">
                    Semua transaksi Anda kini tercatat secara real-time dan aman dalam sistem enkripsi terbaru.
                </p>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-card">
            <div style="margin-bottom: 32px;">
                <h2 style="font-size: 28px; color: var(--text-main); margin-bottom: 8px;">Login</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Gunakan akun mahasiswa terdaftar Anda.</p>
            </div>

            @if(session('error'))
                <div style="background: #FEF2F2; color: #DC2626; padding: 12px 16px; border-radius: 12px; font-size: 13px; margin-bottom: 20px; border: 1px solid #FEE2E2; display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 18px;">⚠️</span> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" style="display:flex; flex-direction:column; gap:20px;">
                @csrf

                <div class="form-group">
                    <label>Alamat Email</label>
                    <input type="email" name="email" placeholder="contoh@kampus.ac.id" required autofocus>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label style="margin-bottom: 0;">Kata Sandi</label>
                        <a href="#" style="font-size: 12px; color: var(--primary); font-weight: 600;">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <div style="display: flex; align-items: center; gap: 8px; margin-top: -5px;">
                    <input type="checkbox" id="remember" name="remember" style="width: 16px; height: 16px; cursor: pointer;">
                    <label for="remember" style="font-size: 13px; color: var(--text-muted); cursor: pointer; font-weight: 500;">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 15px; margin-top: 10px;">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="auth-footer" style="margin-top: 32px; padding-top: 24px; border-top: 1px dashed var(--border);">
                <span style="color: var(--text-muted);">Belum menjadi anggota?</span>
                <br>
                <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 700; display: inline-block; margin-top: 8px; font-size: 15px;">
                    Daftar Keanggotaan KOPMA
                </a>
            </div>

        </div>
    </div>

</section>
@endsection