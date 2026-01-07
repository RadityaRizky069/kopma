@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <div class="text-center mb-4">
        <h3 class="fw-bold">Selamat Datang di KOPMA</h3>
        <p class="text-muted">
            Belanja makanan & minuman koperasi mahasiswa
        </p>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/300" class="card-img-top">
                <div class="card-body">
                    <h6 class="card-title">Es Teh</h6>
                    <p class="text-muted mb-1">Rp 3.000</p>
                    <button class="btn btn-sm btn-success w-100">
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
