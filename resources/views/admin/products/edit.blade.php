@extends('layouts.main')

@section('content')

<h1>Edit Produk</h1>

<form action="{{ route('admin.products.update',$product->id) }}" method="POST">
@csrf @method('PUT')

<label>Nama Produk</label>
<input name="name" value="{{ $product->name }}" required>

<label>Harga</label>
<input name="price" value="{{ $product->price }}" required>

<label>Stok</label>
<input name="stock" value="{{ $product->stock }}" required>

<label>Link Gambar</label>
<input name="image" value="{{ $product->image }}">

<button class="btn-primary">Update</button>
</form>

@endsection
