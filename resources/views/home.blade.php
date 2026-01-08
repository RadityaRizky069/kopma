@extends('layouts.main')

@section('title', Auth::check() ? 'Dashboard - KOPMA' : 'Selamat Datang di KOPMA')

@section('content')

{{-- ========================================================= --}}
{{-- TAMPILAN MEMBER (SUDAH LOGIN)                             --}}
{{-- ========================================================= --}}
@auth
<section class="container" style="margin-top:40px;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px; align-items: center;">
        <div>
            <h1 style="font-size:28px; font-weight:800; margin-bottom:12px;">
                Halo, {{ Auth::user()->name }}! 👋
            </h1>
            <p style="color:#6B7280; margin-bottom:24px;">Mau cari kebutuhan apa hari ini?</p>
            
            <form action="" style="display:flex; gap:12px;">
                <input type="text" placeholder="Cari barang..." style="flex:1; padding:14px 20px; border-radius:14px; border:1px solid #E5E7EB; background:#F9FAFB; outline:none;">
                <button class="btn btn-primary">Cari</button>
            </form>
        </div>

        <div class="card" style="background: linear-gradient(135deg, #15803D, #166534); color: white; border: none; box-shadow: 0 20px 40px rgba(21, 128, 61, 0.2);">
            <div style="font-size:13px; opacity:0.9; margin-bottom:8px;">Saldo Simpanan</div>
            <div style="font-size:32px; font-weight:800; margin-bottom:20px;">Rp 150.000</div>
            <div style="display:flex; gap:12px;">
                <button style="background: rgba(255,255,255,0.2); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size:12px; font-weight:600; cursor:pointer;">+ Topup</button>
            </div>
        </div>
    </div>
</section>

<section class="container" style="margin-top:60px;">
    <h3 style="font-size:20px; font-weight:700; margin-bottom:24px;">Kategori</h3>
    <div style="display:flex; gap:24px; overflow-x:auto; padding-bottom:10px;">
        @foreach(['Makanan', 'Minuman', 'ATK', 'Merchandise'] as $cat)
        <a href="#" style="display:flex; flex-direction:column; align-items:center; gap:10px; min-width:80px;">
            <div style="width:60px; height:60px; background: white; border-radius: 16px; border: 1px solid #E5E7EB; display:flex; align-items:center; justify-content:center; font-size:24px;">📦</div>
            <span style="font-size:13px; font-weight:600; color:#4B5563;">{{ $cat }}</span>
        </a>
        @endforeach
    </div>
</section>

<section class="container" style="margin-top:50px; margin-bottom:100px;">
    <h3 style="font-size:20px; font-weight:700; margin-bottom:24px;">Rekomendasi Hari Ini</h3>
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:24px;">
        @for($i = 1; $i <= 4; $i++)
        <div class="card" style="padding:16px;">
            <img src="https://via.placeholder.com/300x300" style="width:100%; border-radius:12px; margin-bottom:12px;">
            <h4 style="font-size:16px; font-weight:700; margin:0 0 4px 0;">Roti Bakar Premium</h4>
            <p style="font-size:12px; color:#6B7280; margin:0 0 12px 0;">Rp 12.000</p>
            <button class="btn btn-primary" style="width:100%; padding: 8px;">+ Keranjang</button>
        </div>
        @endfor
    </div>
</section>
@endauth


{{-- ========================================================= --}}
{{-- TAMPILAN TAMU (BELUM LOGIN) - Ini Kode Asli Kamu          --}}
{{-- ========================================================= --}}
@guest
<section class="container" style="margin-top:80px;">
    <div style="display:grid; grid-template-columns: 1.1fr .9fr; gap:64px; align-items:center;">
        <div>
            <span style="background:#DCFCE7; color:#166534; padding:6px 14px; border-radius:999px; font-size:13px; font-weight:600;">
                Platform Koperasi Digital
            </span>

            <h1 style="font-size:48px; font-weight:800; line-height:1.2; margin:20px 0;">
                Belanja di Koperasi <br>Jadi Lebih Mudah
            </h1>

            <p style="font-size:18px; color:#6B7280; max-width:520px; line-height:1.7;">
                KOPMA menghadirkan pengalaman koperasi mahasiswa yang modern, cepat, transparan, dan mudah diakses kapan saja.
            </p>

            <div style="margin-top:36px;">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Mulai Belanja
                </a>
            </div>
        </div>

        <div style="background:#F0FDF4; border-radius:32px; height:380px; display:flex; align-items:center; justify-content:center; font-size:22px; font-weight:600; color:#166534;">
            Preview Aplikasi
        </div>
    </div>
</section>

<section class="container" style="margin-top:120px; margin-bottom:80px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
        <h2 style="font-size:28px; font-weight:700;">Produk Populer</h2>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap:32px;">
        <div class="card">
            <img src="https://via.placeholder.com/400x300" style="width:100%; border-radius:16px; margin-bottom:18px;">
            <h3 style="font-size:18px; font-weight:600;">Es Teh Manis</h3>
            <p style="color:#6B7280; margin:6px 0 16px;">Rp 3.000</p>
            <a href="{{ route('login') }}" class="btn btn-primary" style="width:100%; text-align:center; display:block;">
                Login untuk Membeli
            </a>
        </div>
    </div>
</section>
@endguest

@endsection