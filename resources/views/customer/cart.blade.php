@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')

<style>
    .cart-section { padding: 60px 0; min-height: 80vh; background: #f8fafc; }
    .page-title { font-size: 28px; font-weight: 800; margin-bottom: 30px; color: #1e293b; }
    .cart-grid { display: grid; grid-template-columns: 1fr 380px; gap: 40px; }
    .cart-item { display: flex; align-items: center; gap: 20px; background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 15px; position: relative; }
    .item-img { width: 100px; height: 100px; border-radius: 12px; object-fit: cover; }
    .item-details { flex: 1; }
    .cart-summary { background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; height: fit-content; position: sticky; top: 100px; }
    .summary-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 2px dashed #e2e8f0; font-weight: 800; font-size: 18px; }
    .btn-checkout { background: #28a745; color: white; width: 100%; padding: 15px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; }
    .btn-checkout:hover { background: #218838; }
    .payment-select { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 10px; margin-bottom: 20px; }

    .qty-control { display: flex; align-items: center; gap: 10px; margin-top: 10px; }
    .btn-qty { width: 32px; height: 32px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; font-weight: bold; cursor: pointer; }
    .btn-qty:disabled { opacity: .5; }

    .btn-remove {
        position: absolute; top: 20px; right: 20px;
        background: none; border: none; color: #ef4444;
        font-size: 22px; cursor: pointer;
    }
</style>

<section class="cart-section">
<div class="container">
<h1 class="page-title">🛒 Keranjang Belanja</h1>

@if($cartItems->isEmpty())
    <div style="text-align:center; padding:80px; background:white; border-radius:16px;">
        <h3>Keranjang masih kosong</h3>
        <a href="{{ route('products.index') }}" class="btn-checkout" style="display:inline-block;width:auto;">Mulai Belanja</a>
    </div>
@else
<div class="cart-grid">

{{-- ================= LIST ITEM ================= --}}
<div class="cart-items">
@php $grandTotal = 0; @endphp
@foreach($cartItems as $item)
@if($item->product)
@php
    $harga = $item->product->harga ?? 0;
    $subtotal = $harga * $item->jumlah;
    $grandTotal += $subtotal;
@endphp

<div class="cart-item">
    <img class="item-img" src="{{ asset('storage/'.$item->product->gambar) }}">

    <div class="item-details">
        <b>{{ $item->product->nama_produk }}</b>
        <div style="color:#28a745;">Rp {{ number_format($harga,0,',','.') }}</div>

        <div class="qty-control">
            <form method="POST" action="{{ route('cart.update',$item->id) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="jumlah" value="{{ $item->jumlah-1 }}">
                <button class="btn-qty" {{ $item->jumlah<=1?'disabled':'' }}>-</button>
            </form>

            <b>{{ $item->jumlah }}</b>

            <form method="POST" action="{{ route('cart.update',$item->id) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="jumlah" value="{{ $item->jumlah+1 }}">
                <button class="btn-qty">+</button>
            </form>
        </div>
    </div>

    <div>
        <small>Subtotal</small><br>
        <b>Rp {{ number_format($subtotal,0,',','.') }}</b>
    </div>

    <form method="POST" action="{{ route('cart.remove',$item->id) }}">
        @csrf @method('DELETE')
        <button class="btn-remove">🗑</button>
    </form>
</div>
@endif
@endforeach
</div>

{{-- ================= SUMMARY ================= --}}
<div class="cart-summary">
<form method="POST" action="{{ route('checkout') }}">
@csrf

<label>Metode Pembayaran</label>
<select name="metode_pembayaran" class="payment-select" required>
    <option disabled selected>Pilih</option>
    <option value="Transfer">Transfer</option>
    <option value="E-Wallet">E-Wallet</option>
    <option value="Tunai">Tunai</option>
</select>

{{-- ================== POIN ================== --}}
@auth
@if(auth()->user()->is_member && auth()->user()->points > 0)
<div style="background:#f0fdf4;padding:15px;border-radius:10px;border:1px solid #86efac;margin-bottom:15px;">
    <b>🎯 Gunakan Poin</b><br>
    Poin tersedia: <b>{{ auth()->user()->points }}</b><br>
    <small>1 poin = Rp 100</small>

    <input type="number"
           name="use_points"
           min="0"
           max="{{ auth()->user()->points }}"
           placeholder="Jumlah poin"
           style="width:100%;padding:8px;margin-top:8px;">
</div>
@endif
@endauth
{{-- ========================================== --}}

<div class="summary-total">
    <span>Total</span>
    <span id="totalDisplay"
          data-total="{{ $grandTotal }}">
        Rp {{ number_format($grandTotal,0,',','.') }}
    </span>
</div>

<button class="btn-checkout">Selesaikan Pesanan</button>
</form>
</div>

</div>
@endif
</div>
</section>

{{-- ================= JS HITUNG POIN LIVE ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pointInput = document.querySelector('input[name="use_points"]');
    const totalDisplay = document.getElementById('totalDisplay');

    if (!pointInput || !totalDisplay) return;

    const originalTotal = parseInt(totalDisplay.dataset.total);

    pointInput.addEventListener('input', function () {
        let points = parseInt(this.value) || 0;
        let discount = points * 100;

        if (discount > originalTotal) {
            discount = originalTotal;
            this.value = Math.floor(originalTotal / 100);
        }

        const newTotal = originalTotal - discount;
        totalDisplay.innerText =
            'Rp ' + newTotal.toLocaleString('id-ID');
    });
});
</script>

@endsection
