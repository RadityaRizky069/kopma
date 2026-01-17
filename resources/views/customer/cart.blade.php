@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')

<style>
    .cart-section { padding: 60px 0; min-height: 80vh; }
    .page-title { font-size: 28px; font-weight: 800; margin-bottom: 30px; display: flex; align-items: center; gap: 10px; color: #1e293b; }
    .cart-grid { display: grid; grid-template-columns: 1fr 350px; gap: 40px; }
    .cart-items { display: flex; flex-direction: column; gap: 20px; }
    .cart-item { display: flex; align-items: center; gap: 20px; background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; }
    .item-img { width: 80px; height: 80px; border-radius: 12px; object-fit: cover; background: #f1f1f1; }
    .item-details { flex: 1; }
    .item-name { font-weight: 700; font-size: 16px; color: #1e293b; }
    .item-price { color: #64748b; font-size: 14px; }
    .subtotal-text { color: #28a745; font-weight: 700; font-size: 16px; }
    .cart-summary { background: white; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; height: fit-content; position: sticky; top: 100px; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; color: #64748b; }
    .summary-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 2px dashed #e2e8f0; font-weight: 800; font-size: 18px; }
    .btn-checkout { background: #28a745; color: white; width: 100%; padding: 15px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: 0.2s; }
    .btn-qty { width: 30px; height: 30px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; cursor: pointer; font-weight: bold; transition: 0.2s; }
    .btn-qty:hover { background: #f1f5f9; }
    .btn-plus { background: #28a745 !important; color: white !important; border: none !important; }
    .btn-plus:disabled { background: #cbd5e1 !important; cursor: not-allowed !important; }

    @media (max-width: 768px) { .cart-grid { grid-template-columns: 1fr; } }
</style>

<section class="cart-section">
    <div class="container">
        <h1 class="page-title">🛒 Keranjang Belanja</h1>

        @if($cartItems->isEmpty())
            <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 16px; border: 2px dashed #e2e8f0;">
                <i class="fas fa-shopping-cart" style="font-size: 60px; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h3>Keranjang masih kosong</h3>
                <a href="/products" class="btn-checkout" style="display: inline-block; width: auto; padding: 12px 30px; text-decoration: none; margin-top: 20px;">Mulai Belanja</a>
            </div>
        @else
            <div class="cart-grid">
                <div class="cart-items">
                    @php $grandTotal = 0; @endphp
                    @foreach($cartItems as $item)
                        @php 
                            $harga = $item->product->harga ?? 0;
                            $subtotal = $harga * $item->jumlah;
                            $grandTotal += $subtotal;
                        @endphp

                        <div class="cart-item">
                            <img src="{{ $item->product->gambar ? asset('storage/' . $item->product->gambar) : 'https://via.placeholder.com/80' }}" class="item-img">
                            
                            <div class="item-details">
                                <span class="item-name">{{ $item->product->nama_produk }}</span>
                                <span class="item-price">@ Rp {{ number_format($harga, 0, ',', '.') }}</span>
                                <div style="margin-top: 5px;"><small style="color: #94a3b8;">Stok: {{ $item->product->stok }}</small></div>
                            </div>

                            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px;">
                                {{-- KONTROL JUMLAH --}}
                                <div style="display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 5px; border-radius: 10px; border: 1px solid #e2e8f0;">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="type" value="minus">
                                        <button type="submit" class="btn-qty">-</button>
                                    </form>

                                    <span style="font-weight: 800; min-width: 20px; text-align: center;">{{ $item->jumlah }}</span>

                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="type" value="plus">
                                        <button type="submit" class="btn-qty btn-plus" {{ $item->jumlah >= $item->product->stok ? 'disabled' : '' }}>+</button>
                                    </form>
                                </div>
                                <span class="subtotal-text">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                @if($item->jumlah >= $item->product->stok)
                                    <small style="color: #ef4444; font-size: 10px; font-weight: 700;">Maks Stok Tercapai</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <h3 style="margin-top: 0;">Ringkasan</h3>
                    <div class="summary-row">
                        <span>Total Item</span>
                        <span style="font-weight: 700;">{{ $cartItems->sum('jumlah') }} Pcs</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Tagihan</span>
                        <span style="color: #28a745;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
{{-- Form Checkout --}}
<form action="{{ route('checkout') }}" method="POST">
    @csrf

    {{-- METODE PEMBAYARAN --}}
    <div style="margin-top:20px">
        <label style="font-weight:600;color:#1e293b;margin-bottom:8px;display:block;">
            Metode Pembayaran
        </label>

        <select name="payment_method"
                required
                style="width:100%;
                       padding:12px;
                       border-radius:10px;
                       border:1px solid #e2e8f0;">
            <option value="">-- Pilih Metode --</option>
            <option value="cash">Cash</option>
            <option value="transfer_bca">Transfer BCA</option>
            <option value="transfer_bri">Transfer BRI</option>
            <option value="ewallet">E-Wallet</option>
        </select>
    </div>

    <button type="submit" class="btn-checkout">
        Checkout Sekarang <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
    </button>
</form>

                </div>
            </div>
        @endif
    </div>
</section>

@endsection