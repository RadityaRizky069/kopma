@extends('layouts.app')
@section('content')
<h1>Dashboard Admin</h1>
<p>Total Produk: {{ $totalProducts }}</p>
<p>Total Customer: {{ $totalCustomers }}</p>
<p>Total Transaksi: {{ $totalTransactions }}</p>

<a href="{{ route('products.index') }}">Kelola Produk</a> |
<a href="{{ route('categories.index') }}">Kelola Kategori</a> |
<a href="{{ route('admin.customers') }}">Daftar Customer</a> |
<a href="{{ route('admin.transactions') }}">Kelola Transaksi</a> |
<a href="{{ route('admin.reports') }}">Laporan</a>
@endsection
