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
