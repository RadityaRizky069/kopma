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
    .btn-checkout { background: #28a745; color: white; width: 100%; padding: 15px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; text-decoration: none; text-align: center; display: block; transition: 0.3s; }
    .btn-checkout:hover { background: #218838; }
    .payment-select { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; margin-top: 10px; margin-bottom: 20px; outline: none; }
    
    /* Qty Controls */
    .qty-control { display: flex; align-items: center; gap: 10px; margin-top: 10px; }
    .btn-qty { width: 32px; height: 32px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; color: #1e293b; font-weight: bold; cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; text-decoration: none; }
    .btn-qty:hover:not(:disabled) { background: #f1f5f9; border-color: #cbd5e1; }
    .btn-qty:disabled { opacity: 0.5; cursor: not-allowed; }
    
    /* Tombol Hapus: Ukuran font diperbesar jadi 22px */
    .btn-remove { 
        position: absolute; 
        top: 20px; 
        right: 20px; 
        color: #ef4444; 
        background: none; 
        border: none; 
        cursor: pointer; 
        font-size: 22px; /* Diperbesar */
        transition: 0.2s; 
        padding: 5px;
    }
    .btn-remove:hover { 
        color: #dc2626; 
        transform: scale(1.15); 
    }
</style>

<section class="cart-section">
    <div class="container">
        <h1 class="page-title">🛒 Keranjang Belanja</h1>

        @if(session('success'))
            <div style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 16px; border: 2px dashed #e2e8f0;">
                <h3 style="color: #64748b;">Keranjang masih kosong</h3>
                <a href="{{ route('products.index') }}" class="btn-checkout" style="display: inline-block; width: auto; padding: 12px 30px; margin-top: 20px;">Mulai Belanja</a>
            </div>
        @else
            <div class="cart-grid">
                <div class="cart-items">
                    @php $grandTotal = 0; @endphp
                    @foreach($cartItems as $item)
                        @if($item->product)
                            @php 
                                $harga = $item->product->harga ?? $item->product->price ?? 0;
                                $subtotal = $harga * $item->jumlah;
                                $grandTotal += $subtotal;
                                $stokTersedia = $item->product->stok;
                            @endphp
                            <div class="cart-item">
                                <img src="{{ $item->product->gambar ? asset('storage/' . $item->product->gambar) : 'https://via.placeholder.com/100' }}" class="item-img">
                                
                                <div class="item-details">
                                    <div style="font-weight: 700; color: #1e293b; font-size: 18px;">{{ $item->product->nama_produk }}</div>
                                    <div style="color: #28a745; font-weight: 600; margin-top: 4px;">Rp {{ number_format($harga, 0, ',', '.') }}</div>
                                    
                                    <div class="qty-control">
                                        {{-- Tombol Kurang --}}
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="jumlah" value="{{ $item->jumlah - 1 }}">
                                            <button type="submit" class="btn-qty" {{ $item->jumlah <= 1 ? 'disabled' : '' }}>-</button>
                                        </form>

                                        <span style="font-weight: 700; min-width: 20px; text-align: center;">{{ $item->jumlah }}</span>

                                        {{-- Tombol Tambah --}}
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="jumlah" value="{{ $item->jumlah + 1 }}">
                                            <button type="submit" class="btn-qty" {{ $item->jumlah >= $stokTersedia ? 'disabled' : '' }}>+</button>
                                        </form>
                                        
                                        <small style="color: #94a3b8; margin-left: 10px;">Stok: {{ $stokTersedia }}</small>
                                    </div>
                                </div>

                                <div style="text-align: right; padding-right: 40px;">
                                    <div style="color: #64748b; font-size: 12px;">Subtotal</div>
                                    <div style="font-weight: 800; color: #1e293b; font-size: 18px;">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                                </div>

                                {{-- Tombol Hapus (Hanya 1 Icon) --}}
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove" title="Hapus Barang">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="cart-summary">
                    <h3 style="margin-top: 0; color: #1e293b;">Ringkasan Belanja</h3>
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <label style="font-size: 14px; font-weight: 600; color: #475569;">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="payment-select" required>
                            <option value="" disabled selected>Pilih Pembayaran</option>
                            <option value="Transfer Bank (BCA)">Transfer BCA</option>
                            <option value="DANA/OVO">E-Wallet (DANA/OVO)</option>
                            <option value="Tunai">Bayar Tunai di Koperasi</option>
                        </select>

                        <div class="summary-total">
                            <span>Total Tagihan</span>
                            <span style="color: #28a745;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn-checkout" style="margin-top: 20px;">
                            Selesaikan Pesanan
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection