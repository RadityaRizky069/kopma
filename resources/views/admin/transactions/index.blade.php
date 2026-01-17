@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        background-color: #f1f5f9; /* Slate 100 */
    }
    
    .page-container {
        padding: 40px;
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
    }

    /* Header Styling */
    .header-title {
        color: #0f172a;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.025em;
    }
    .header-subtitle {
        color: #64748b;
        font-size: 14px;
        margin-top: 5px;
    }
    .data-badge {
        background: white;
        padding: 8px 16px;
        border-radius: 50px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Table Styling */
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px; /* Jarak antar baris */
    }
    
    .custom-table thead th {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0 20px 10px 20px;
        border: none;
        text-align: left;
    }

    .table-row {
        background: white;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(148, 163, 184, 0.05);
    }
    
    .table-row td {
        padding: 20px;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }
    
    /* Rounded corners for the row */
    .table-row td:first-child {
        border-left: 1px solid #f1f5f9;
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
    }
    .table-row td:last-child {
        border-right: 1px solid #f1f5f9;
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    .table-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    /* Typography inside table */
    .trans-code {
        font-weight: 700;
        color: #334155;
        font-size: 15px;
    }
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 5px;
        color: #64748b;
        font-size: 13px;
    }
    .price-text {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        color: #0f172a;
        font-size: 15px;
    }

    /* Status Badges */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-waiting { background: #fffbeb; color: #b45309; border: 1px solid #fcd34d; }
    .badge-process { background: #eff6ff; color: #0369a1; border: 1px solid #bae6fd; }
    .badge-success { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
    .badge-reject  { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; }

    /* Action Buttons */
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
        position: relative;
    }
    .btn-accept { background: #dcfce7; color: #166534; }
    .btn-accept:hover { background: #22c55e; color: white; transform: scale(1.1); }
    
    .btn-reject { background: #fee2e2; color: #991b1b; }
    .btn-reject:hover { background: #ef4444; color: white; transform: scale(1.1); }

    .btn-finish { background: #e0f2fe; color: #0369a1; width: auto; padding: 0 15px; }
    .btn-finish:hover { background: #0ea5e9; color: white; }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 20px;
        padding: 60px;
        text-align: center;
        border: 2px dashed #e2e8f0;
    }

    /* Avatar Circle */
    .avatar-circle {
        width: 24px;
        height: 24px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #64748b;
        font-weight: bold;
    }
</style>

<div class="page-container">

    {{-- HEADER SECTION --}}
    <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end;" class="animate__animated animate__fadeIn">
        <div>
            <h2 class="header-title">Kelola Pesanan</h2>
            <p class="header-subtitle">Pantau dan kelola transaksi masuk dengan mudah.</p>
        </div>
        <div class="data-badge">
            <i class="fas fa-receipt" style="color: #f59e0b;"></i>
            <span>{{ $transactions->count() }} Transaksi</span>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
    <div class="animate__animated animate__bounceIn" style="margin-bottom: 20px; background: #ffffff; border-left: 5px solid #22c55e; padding: 15px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px;">
        <div style="background: #dcfce7; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #166534;">
            <i class="fas fa-check"></i>
        </div>
        <div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #1e293b;">Berhasil!</h4>
            <p style="margin: 0; font-size: 13px; color: #64748b;">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- TABLE SECTION --}}
    <div class="animate__animated animate__fadeInUp">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Detail Transaksi</th>
                        <th width="20%">Total Harga</th>
                        <th width="15%">Status</th>
                        <th width="15%">Tanggal</th>
                        <th width="15%" style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $item)
                    <tr class="table-row">
                        <td style="text-align: center; color: #94a3b8; font-weight: 600;">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <div class="trans-code">{{ $item->kode_transaksi ?? '#' . $item->id }}</div>
                            <div class="user-info">
                                {{-- Avatar inisial nama --}}
                                <div class="avatar-circle">
                                    {{ substr($item->user->name ?? 'U', 0, 1) }}
                                </div>
                                <span>{{ $item->user->name ?? 'User Terhapus' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="price-text">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            @if($item->status == 'menunggu')
                                <span class="badge badge-waiting">
                                    <i class="fas fa-clock"></i> Menunggu
                                </span>
                            @elseif($item->status == 'diproses')
                                <span class="badge badge-process">
                                    <i class="fas fa-cog fa-spin"></i> Diproses
                                </span>
                            @elseif($item->status == 'selesai')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Selesai
                                </span>
                            @elseif($item->status == 'ditolak')
                                <span class="badge badge-reject">
                                    <i class="fas fa-times-circle"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td style="color: #64748b; font-size: 13px; font-weight: 500;">
                            <div>{{ $item->created_at->format('d M Y') }}</div>
                            <div style="font-size: 11px; opacity: 0.7;">Pukul {{ $item->created_at->format('H:i') }}</div>
                        </td>
                        <td style="text-align: center;">
                            
                            {{-- LOGIKA TOMBOL ACC / REJECT DENGAN SWEETALERT --}}
                            @if($item->status == 'menunggu')
                                <form action="{{ route('admin.transactions.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        {{-- Tombol TERIMA --}}
                                        <button type="button" 
                                            class="btn-action btn-accept"
                                            onclick="confirmAction(this, 'diproses')"
                                            title="Terima (Proses)">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        {{-- Tombol TOLAK --}}
                                        <button type="button" 
                                            class="btn-action btn-reject"
                                            onclick="confirmAction(this, 'ditolak')"
                                            title="Tolak Pesanan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </form>

                            @elseif($item->status == 'diproses')
                                {{-- Tombol SELESAIKAN --}}
                                <form action="{{ route('admin.transactions.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    <div style="display: flex; justify-content: center;">
                                        <button type="button" 
                                            class="btn-action btn-finish"
                                            onclick="confirmAction(this, 'selesai')">
                                            Selesaikan <i class="fas fa-arrow-right" style="margin-left:5px;"></i>
                                        </button>
                                    </div>
                                </form>
                            @else
                                <span style="color: #cbd5e1;">
                                    <i class="fas fa-lock"></i>
                                </span>
                            @endif

                        </td>
                    </tr>
                    @empty
                        {{-- KONDISI KOSONG --}}
                    @endforelse
                </tbody>
            </table>

            {{-- Jika data kosong --}}
            @if($transactions->isEmpty())
            <div class="empty-state">
                <div style="background: #f1f5f9; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="fas fa-inbox" style="font-size: 32px; color: #94a3b8;"></i>
                </div>
                <h3 style="color: #334155; margin: 0 0 10px;">Belum ada pesanan masuk</h3>
                <p style="color: #64748b; margin: 0;">Saat ini belum ada transaksi baru yang perlu dikelola.</p>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
    function confirmAction(button, statusValue) {
        // Cari form terdekat dari tombol yang diklik
        const form = button.closest('form');

        // Tentukan teks dan warna berdasarkan status
        let titleText = '';
        let bodyText = '';
        let confirmColor = '';
        let iconType = '';
        let confirmButtonText = '';

        if (statusValue === 'diproses') {
            titleText = 'Terima Pesanan?';
            bodyText = 'Status transaksi akan berubah menjadi "Diproses".';
            confirmColor = '#22c55e'; // Hijau
            iconType = 'question';
            confirmButtonText = 'Ya, Terima!';
        } else if (statusValue === 'ditolak') {
            titleText = 'Tolak Pesanan?';
            bodyText = 'Transaksi ini akan ditolak secara permanen.';
            confirmColor = '#ef4444'; // Merah
            iconType = 'warning';
            confirmButtonText = 'Ya, Tolak!';
        } else if (statusValue === 'selesai') {
            titleText = 'Selesaikan Pesanan?';
            bodyText = 'Pastikan barang sudah diterima customer.';
            confirmColor = '#3b82f6'; // Biru
            iconType = 'info';
            confirmButtonText = 'Ya, Selesai!';
        }

        // Tampilkan SweetAlert
        Swal.fire({
            title: titleText,
            text: bodyText,
            icon: iconType,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#64748b',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Batal',
            reverseButtons: true, // Tombol batal di kiri, konfirmasi di kanan
            padding: '2em',
            borderRadius: '16px',
            customClass: {
                popup: 'animate__animated animate__fadeInDown' // Efek animasi muncul
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Trik: Tambahkan input hidden status ke dalam form sebelum submit
                // Karena tombol type="button" tidak mengirim value 'status'
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'status';
                input.value = statusValue;
                form.appendChild(input);

                // Submit form
                form.submit();
            }
        });
    }
</script>

@endsection