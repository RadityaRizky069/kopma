@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        background-color: #f1f5f9;
    }
    .page-container {
        padding: 40px;
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
    }
    .swal2-container {
        z-index: 99999 !important;
    }
    .swal2-popup {
        font-size: 14px !important;
    }
    .header-title {
        color: #0f172a;
        font-size: 28px;
        font-weight: 800;
    }
    .header-subtitle {
        color: #64748b;
        font-size: 14px;
    }
    .data-badge {
        background: white;
        padding: 8px 16px;
        border-radius: 50px;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }
    .custom-table thead th {
        font-size: 12px;
        font-weight: 700;
        padding: 0 20px 10px;
    }
    .table-row {
        background: white;
    }
    .table-row td {
        padding: 20px;
    }
    .trans-code {
        font-weight: 700;
        font-size: 15px;
    }
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #64748b;
        margin-top: 5px;
    }
    .avatar-circle {
        width: 24px;
        height: 24px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
    }
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }
    .badge-waiting { background:#fffbeb; color:#b45309; }
    .badge-process { background:#eff6ff; color:#0369a1; }
    .badge-success { background:#f0fdf4; color:#15803d; }
    .badge-reject { background:#fef2f2; color:#b91c1c; }
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
    }
</style>

<div class="page-container">

    <div style="margin-bottom:30px;display:flex;justify-content:space-between;">
        <div>
            <h2 class="header-title">Kelola Pesanan</h2>
            <p class="header-subtitle">Pantau dan kelola transaksi masuk</p>
        </div>
        <div class="data-badge">
            <i class="fas fa-receipt"></i>
            {{ $transactions->count() }} Transaksi
        </div>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Detail Transaksi</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th style="text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $item)
            <tr class="table-row">
                <td>{{ $loop->iteration }}</td>

                <td>
                    <div class="trans-code">{{ $item->kode_transaksi }}</div>

                    <div class="user-info">
                        <div class="avatar-circle">
                            {{ substr($item->user->name ?? 'U',0,1) }}
                        </div>
                        {{ $item->user->name ?? 'User Terhapus' }}
                    </div>

                    {{-- ================= TAMBAHAN CICILAN (TIDAK UBAH KODE LAMA) ================= --}}
                    @if($item->metode_pembayaran === 'Cicilan' && $item->installment_days)
                        <div style="margin-top:6px;
                                    font-size:12px;
                                    background:#f0fdf4;
                                    color:#166534;
                                    padding:6px 10px;
                                    border-radius:6px;">
                            <i class="fas fa-calendar-alt"></i>
                            Cicilan {{ $item->installment_days }} hari
                        </div>
                    @endif
                    {{-- ========================================================================== --}}
                </td>

                <td>Rp {{ number_format($item->total_harga,0,',','.') }}</td>

                <td>
                    @if($item->status=='menunggu')
                        <span class="badge badge-waiting">Menunggu</span>
                    @elseif($item->status=='diproses')
                        <span class="badge badge-process">Diproses</span>
                    @elseif($item->status=='selesai')
                        <span class="badge badge-success">Selesai</span>
                    @else
                        <span class="badge badge-reject">Ditolak</span>
                    @endif
                </td>

                <td>{{ $item->created_at->format('d M Y H:i') }}</td>

                <td style="text-align:center;">
                    <form action="{{ route('admin.transactions.updateStatus',$item->id) }}" method="POST">
                        @csrf
                        <button class="btn-action">✔</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
