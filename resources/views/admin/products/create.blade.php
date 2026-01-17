@extends('layouts.main')

@section('content')

<h1>Tambah Produk</h1>

<form action="{{ route('admin.products.store') }}" method="POST">
@csrf

<label>Nama Produk</label>
<input name="name" required>

<label>Harga</label>
<input name="price" required>

<label>Stok</label>
<input name="stock" required>

<label>Link Gambar</label>
<input name="image">

<button class="btn-primary">Simpan</button>
</form>

@endsection
