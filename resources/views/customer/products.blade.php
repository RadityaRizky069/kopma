@extends('layouts.main')

@section('content')

<h2>Daftar Produk</h2>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
@foreach($products as $p)
    <div style="border:1px solid #eee; padding:15px; width:200px;">
        <h4>{{ $p->nama_produk }}</h4>
        <p>Rp {{ number_format($p->harga) }}</p>
        <p>Stok: {{ $p->stok }}</p>

        <form action="{{ route('cart.add',$p->id) }}" method="POST">
            @csrf
            <button class="btn-primary">Tambah ke Keranjang</button>
        </form>
    </div>
@endforeach
</div>

@endsection
