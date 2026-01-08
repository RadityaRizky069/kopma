@extends('layouts.main')

@section('title', 'KOPMA')

@section('content')

<!-- HERO -->
<section class="py-5 text-center text-white" style="background: linear-gradient(90deg, #16A34A, #10B981);">
    <div class="container">
        <h1 class="fw-bold mb-3" style="font-size:36px;">Selamat Datang di KOPMA</h1>
        <p class="mb-4" style="font-size:18px;">Belanja kebutuhan makanan dan minuman koperasi mahasiswa</p>
        <a href="{{ route('register') }}" class="btn btn-warning btn-lg fw-bold">Daftar Sekarang</a>
    </div>
</section>

<!-- SEARCH BAR -->
<section class="py-4" style="background-color:#f1f5f9;">
    <div class="container">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari produk..." aria-label="Cari produk">
            <button class="btn btn-primary" type="button">Cari</button>
<section class="container" style="margin-top:80px;">
    <div style="
        display:grid;
        grid-template-columns: 1.1fr .9fr;
        gap:64px;
        align-items:center;
    ">
        <div>
            <span style="
                background:#DCFCE7;
                color:#166534;
                padding:6px 14px;
                border-radius:999px;
                font-size:13px;
                font-weight:600;
            ">
                Platform Koperasi Digital
            </span>

            <h1 style="
                font-size:48px;
                font-weight:800;
                line-height:1.2;
                margin:20px 0;
            ">
                Belanja di Koperasi  
                <br>Jadi Lebih Mudah
            </h1>

            <p style="
                font-size:18px;
                color:#6B7280;
                max-width:520px;
                line-height:1.7;
            ">
                KOPMA menghadirkan pengalaman koperasi mahasiswa yang modern,
                cepat, transparan, dan mudah diakses kapan saja.
            </p>

            <div style="margin-top:36px;">
                <button class="btn btn-primary">
                    Mulai Belanja
                </button>
            </div>
        </div>

        <div style="
            background:#F0FDF4;
            border-radius:32px;
            height:380px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
            font-weight:600;
            color:#166534;
        ">
            Preview Aplikasi
        </div>
    </div>
</section>

<!-- PRODUK -->
<section class="container" style="margin-top:120px;">
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:32px;
    ">
        <h2 style="font-size:28px; font-weight:700;">
            Produk Populer
        </h2>
    </div>

    <div style="
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap:32px;
    ">
        <div class="card">
            <img src="https://via.placeholder.com/400x300"
                 style="width:100%; border-radius:16px; margin-bottom:18px;">

            <h3 style="font-size:18px; font-weight:600;">
                Es Teh Manis
            </h3>

            <p style="color:#6B7280; margin:6px 0 16px;">
                Rp 3.000
            </p>

            <button class="btn btn-primary" style="width:100%;">
                Tambah ke Keranjang
            </button>
        </div>
    </div>
</section>

<!-- PRODUK -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4" style="font-size:24px;">Produk Tersedia</h2>
        <div class="row g-4">
            <!-- Produk Es Teh -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Es Teh">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">Es Teh</h5>
                        <p class="text-muted mb-3">Rp 3.000</p>
                        <button class="btn btn-success mt-auto fw-bold">Tambah ke Keranjang</button>
                    </div>
                </div>
            </div>

            <!-- Produk Roti -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Roti">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">Roti</h5>
                        <p class="text-muted mb-3">Rp 2.500</p>
                        <button class="btn btn-success mt-auto fw-bold">Tambah ke Keranjang</button>
                    </div>
                </div>
            </div>

            <!-- Produk Susu -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Susu">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">Susu</h5>
                        <p class="text-muted mb-3">Rp 4.000</p>
                        <button class="btn btn-success mt-auto fw-bold">Tambah ke Keranjang</button>
                    </div>
                </div>
            </div>

            <!-- Tambahkan produk lain -->
        </div>
    </div>
</section>

<!-- PROMO -->
<section class="py-5 text-center text-white" style="background: linear-gradient(90deg, #F59E0B, #FBBF24);">
    <div class="container">
        <h3 class="fw-bold mb-3">Promo Mingguan</h3>
        <p class="mb-0">Nikmati diskon spesial untuk mahasiswa koperasi!</p>
    </div>
</section>

@endsection
