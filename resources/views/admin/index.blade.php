@extends('layouts.main')

@section('content')

<h1>Kelola Produk</h1>

<a href="{{ route('admin.products.create') }}" class="btn-primary">
    + Tambah Produk
</a>

<table style="width:100%; margin-top:20px; border-collapse:collapse;">
    <tr style="background:#f4f4f4;">
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

@foreach($products as $p)
    <tr>
        <td>{{ $p->name }}</td>
        <td>Rp {{ number_format($p->price) }}</td>
        <td>{{ $p->stock }}</td>
        <td>
            <a href="{{ route('admin.products.edit',$p->id) }}">Edit</a> |
            <form action="{{ route('admin.products.destroy',$p->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button>Hapus</button>
            </form>
        </td>
    </tr>
@endforeach

</table>

@endsection
