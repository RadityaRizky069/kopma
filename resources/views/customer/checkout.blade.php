@extends('layouts.main')

@section('content')
<div class="container" style="max-width:600px;margin-top:40px">
    <h3>Checkout</h3>

    <p><strong>{{ $product->nama_produk }}</strong></p>
    <p>Harga: Rp {{ number_format($product->harga,0,',','.') }}</p>

    <form method="POST" action="{{ route('checkout.process', $product->id) }}">
        @csrf

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="quantity" value="1" min="1" class="form-control">
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="payment_method" class="form-control" required>
                <option value="">-- Pilih Metode --</option>
                <option value="cash">Cash</option>
                <option value="transfer_bca">Transfer BCA</option>
                <option value="transfer_bri">Transfer BRI</option>
                <option value="ewallet">E-Wallet</option>
            </select>
        </div>

        <button class="btn btn-success w-100">
            Bayar Sekarang
        </button>
    </form>
</div>
@endsection
