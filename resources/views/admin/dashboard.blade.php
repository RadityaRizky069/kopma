@extends('layouts.main')

@section('content')

<h1>Dashboard Admin</h1>

<div style="display:flex; gap:20px; margin-top:20px;">
    <div style="padding:20px; background:#f4f4f4; border-radius:10px;">
        <h3>Total Produk</h3>
        <p>{{ $totalProducts }}</p>
    </div>

    <div style="padding:20px; background:#f4f4f4; border-radius:10px;">
        <h3>Total Customer</h3>
        <p>{{ $totalCustomers }}</p>
    </div>

    <div style="padding:20px; background:#f4f4f4; border-radius:10px;">
        <h3>Total Transaksi</h3>
        <p>{{ $totalTransactions }}</p>
    </div>
</div>

@endsection
