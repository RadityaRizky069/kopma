@extends('layouts.main')

@section('title', 'KOPMA')

@section('content')

<!-- HERO -->
<section style="padding:60px 0;">
    <h1 style="font-size:32px; font-weight:700; margin-bottom:8px;">
        Selamat Datang di KOPMA
    </h1>
    <p class="text-muted" style="font-size:16px;">
        Belanja kebutuhan makanan dan minuman koperasi mahasiswa
    </p>
</section>

<!-- PRODUK -->
<section>
    <h2 style="font-size:20px; font-weight:600; margin-bottom:16px;">
        Produk Tersedia
    </h2>

    <div style="
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap:20px;
    ">
        <div class="card">
            <img src="https://via.placeholder.com/300"
                 style="width:100%; border-radius:8px; margin-bottom:12px;">

            <h3 style="font-size:16px; margin:0 0 4px;">Es Teh</h3>
            <p class="text-muted" style="font-size:14px; margin-bottom:12px;">
                Rp 3.000
            </p>

            <button class="btn-primary" style="width:100%;">
                Tambah ke Keranjang
            </button>
        </div>
    </div>
</section>

@endsection
