@extends('layouts.main')

@section('title', 'KOPMA')

@section('content')

<!-- HERO -->
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

@endsection
