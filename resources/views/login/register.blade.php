@extends('layouts.main')

@section('title', 'Daftar Anggota - KOPMA')

@section('content')
<section class="auth-wrapper">

    <div class="auth-left">
        <div style="z-index: 2; position: relative;">
            <h1 style="margin-bottom: 16px;">
                Gabung Bersama 
                <br>KOPMA 🚀
            </h1>

            <p style="margin-bottom: 40px; color: rgba(255,255,255,0.8); max-width: 440px;">
                Mulai perjalanan ekonomi mandiri Anda. Daftarkan akunmu dan nikmati kemudahan akses layanan koperasi yang modern, cepat, dan transparan.
            </p>

            <div class="floating-card" style="max-width: 340px; background: rgba(255,255,255,0.15);">
                <p style="font-weight: 700; font-size: 15px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    ✨ Keuntungan Anggota:
                </p>
                <ul style="list-style: none; padding: 0; font-size: 13px; display: flex; flex-direction: column; gap: 8px; opacity: 0.9;">
                    <li style="display: flex; gap: 10px;">✅ Pantau simpanan secara real-time</li>
                    <li style="display: flex; gap: 10px;">✅ Promo belanja khusus anggota</li>
                    <li style="display: flex; gap: 10px;">✅ Akses laporan keuangan transparan</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-card" style="max-width: 460px; padding: 40px;">
            <div style="margin-bottom: 28px;">
                <h2 style="font-size: 26px; color: var(--text-main); margin-bottom: 6px;">Daftar Akun</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Lengkapi data diri untuk menjadi bagian dari KOPMA.</p>
            </div>

            @if ($errors->any())
                <div style="background: #FEF2F2; color: #DC2626; padding: 12px 16px; border-radius: 12px; font-size: 13px; margin-bottom: 20px; border: 1px solid #FEE2E2; display: flex; align-items: center; gap: 8px;">
                    <span>⚠️</span> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
                @csrf

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Masukkan nama sesuai KTM" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label>Email Mahasiswa</label>
                    <input type="email" name="email" placeholder="nama@kampus.ac.id" value="{{ old('email') }}" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 10px; margin-top: 4px;">
                    <input type="checkbox" id="terms" required style="margin-top: 4px; cursor: pointer;">
                    <label for="terms" style="font-size: 12px; color: var(--text-muted); line-height: 1.4; cursor: pointer;">
                        Saya setuju dengan <a href="#" style="color: var(--primary); font-weight: 600;">Syarat & Ketentuan</a> serta kebijakan privasi KOPMA.
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 15px; margin-top: 8px;">
                    Buat Akun Sekarang
                </button>
            </form>

            <div class="auth-footer" style="margin-top: 28px; padding-top: 20px; border-top: 1px dashed var(--border);">
                <span style="color: var(--text-muted); font-size: 14px;">Sudah memiliki akun?</span>
                <br>
                <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700; display: inline-block; margin-top: 8px; font-size: 15px;">
                    Masuk ke Akun Anda
                </a>
            </div>
        </div>
    </div>

</section>
@endsection