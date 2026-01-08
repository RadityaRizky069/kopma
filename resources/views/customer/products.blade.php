@extends('layouts.main')

@section('title','Belanja')

@section('content')

<section class="container" style="margin-top:80px;">
    <h1 style="font-size:32px; font-weight:800;">Belanja Produk</h1>
    <p style="color:#6B7280; margin-top:8px;">
        Pilih produk dan tambahkan ke keranjang
    </p>
</section>

<section class="container" style="margin-top:48px;">
    <div style="
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap:32px;
    ">
        @foreach($products as $product)
        <div class="card">
            <img src="{{ $product->image ?? 'https://via.placeholder.com/400x300' }}"
                 style="width:100%; border-radius:16px; margin-bottom:18px;">

            <h3 style="font-size:18px; font-weight:600;">
                {{ $product->name }}
            </h3>

            <p style="color:#6B7280; margin:6px 0 16px;">
                Rp {{ number_format($product->price,0,',','.') }}
            </p>

            <form action="{{ route('cart.add',$product->id) }}" method="POST">
                @csrf
                <button class="btn btn-primary" style="width:100%;">
                    Tambah ke Keranjang
                </button>
            </form>
        </div>
        @endforeach
    </div>
</section>

@endsection
