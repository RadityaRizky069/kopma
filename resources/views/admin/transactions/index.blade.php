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

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
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
    }

    .trans-code { font-weight: 700; color: #334155; font-size: 15px; }
    .item-list { font-size: 12px; color: #94a3b8; margin-top: 4px; font-style: italic; }
    .user-info { display: flex; align-items: center; gap: 10px; margin-top: 8px; color: #64748b; font-size: 13px; }
    .price-text { font-family: 'Inter', sans-serif; font-weight: 700; color: #16a34a; font-size: 15px; }

    .badge { padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase; }
    .badge-waiting { background: #fffbeb; color: #b45309; border: 1px solid #fcd34d; }
    .badge-process { background: #eff6ff; color: #0369a1; border: 1px solid #bae6fd; }
    .badge-success { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
    .badge-reject  { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; }

    .btn-action { height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s; font-size: 13px; font-weight: 600; padding: 0 15px; gap: 8px; }
    .btn-accept { background: #dcfce7; color: #166534; }
    .btn-accept:hover { background: #22c55e; color: white; transform: translateY(-1px); }
    .btn-reject { background: #fee2e2; color: #991b1b; }
    .btn-reject:hover { background: #ef4444; color: white; transform: translateY(-1px); }
    .btn-finish { background: #e0f2fe; color: #0369a1; }
    .btn-finish:hover { background: #0ea5e9; color: white; transform: translateY(-1px); }

    .avatar-circle { width: 24px; height: 24px; background: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; color: white; font-weight: bold; }

    /* Notifikasi Animasi Animasi */
    .order-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #0f172a;
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 15px;
        z-index: 1000;
        animation: slideIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .order-notif-icon {
        background: #f59e0b;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        animation: pulse 2s infinite;
    }

    @keyframes slideIn {
        from { transform: translateX(100%) scale(0.5); opacity: 0; }
        to { transform: translateX(0) scale(1); opacity: 1; }
    }

    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }
</style>

<div class="page-container">
    {{-- ALERT PESAN --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}" });
        </script>
    @endif

    {{-- NOTIFIKASI PESANAN BARU --}}
    @php
        $pendingCount = $transactions->where('status', 'menunggu')->count();
    @endphp

    @if($pendingCount > 0)
    <div class="order-notification">
        <div class="order-notif-icon">
            <i class="fas fa-bell"></i>
        </div>
        <div>
            <div style="font-size: 14px; font-weight: 700;">Pesanan Baru!</div>
            <div style="font-size: 12px; opacity: 0.8;">Ada {{ $pendingCount }} pesanan menunggu konfirmasi.</div>
        </div>
        <button onclick="this.parentElement.style.display='none'" style="background:none; border:none; color:white; opacity: 0.5; cursor:pointer; padding: 5px;">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
        <div>
            <h2 class="header-title">Manajemen Pesanan</h2>
            <p class="header-subtitle">Validasi pembayaran dan proses pesanan customer.</p>
        </div>
        <div class="data-badge">
            <i class="fas fa-receipt" style="color: #f59e0b;"></i>
            <span>{{ $transactions->count() }} Total Transaksi</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th width="5%" style="text-align: center;">No</th>
                    <th width="35%">Informasi Transaksi</th>
                    <th width="20%">Total Bayar</th>
                    <th width="15%">Status</th>
                    <th width="15%">Waktu</th>
                    <th width="10%" style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $item)
                @php $status = strtolower($item->status); @endphp
                <tr class="table-row">
                    <td style="text-align: center; color: #94a3b8; font-weight: 600;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="trans-code">{{ $item->kode_transaksi }}</div>
                        <div class="item-list">
                            @if($item->items && $item->items->count() > 0)
                                <i class="fas fa-shopping-basket"></i> {{ $item->items->count() }} jenis produk
                            @else
                                <i class="fas fa-exclamation-triangle text-warning"></i> Detail produk tidak terbaca
                            @endif
                        </div>
                        <div class="user-info">
                            <div class="avatar-circle">{{ substr($item->user->name ?? 'G', 0, 1) }}</div>
                            <span>{{ $item->user->name ?? 'User Terhapus' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="price-text">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                        @if($item->discount > 0)
                            <div style="font-size: 11px; color: #ef4444; margin-top: 2px;">(Poin: -Rp {{ number_format($item->discount, 0, ',', '.') }})</div>
                        @endif
                    </td>
                    <td>
                        @if($status == 'menunggu')
                            <span class="badge badge-waiting"><i class="fas fa-clock"></i> Menunggu</span>
                        @elseif($status == 'diproses')
                            <span class="badge badge-process"><i class="fas fa-spinner fa-spin"></i> Diproses</span>
                        @elseif($status == 'selesai')
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @elseif($status == 'ditolak')
                            <span class="badge badge-reject"><i class="fas fa-times-circle"></i> Ditolak</span>
                        @endif
                    </td>
                    <td style="color: #64748b; font-size: 13px; font-weight: 500;">
                        <div style="color: #334155;">{{ $item->created_at->translatedFormat('d F Y') }}</div>
                        <div style="font-size: 11px; opacity: 0.8;">{{ $item->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td style="text-align: center;">
                        @if(in_array($status, ['menunggu', 'diproses']))
                        <form action="{{ route('admin.transactions.updateStatus', $item->id) }}" method="POST" id="form-status-{{ $item->id }}">
                            @csrf
                            <input type="hidden" name="status" id="input-status-{{ $item->id }}">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                @if($status == 'menunggu')
                                    <button type="button" class="btn-action btn-accept" onclick="confirmUpdate({{ $item->id }}, 'diproses')" title="Terima Pesanan">
                                        <i class="fas fa-check"></i> Terima
                                    </button>
                                    <button type="button" class="btn-action btn-reject" onclick="confirmUpdate({{ $item->id }}, 'ditolak')" title="Tolak Pesanan">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                @elseif($status == 'diproses')
                                    <button type="button" class="btn-action btn-finish" onclick="confirmUpdate({{ $item->id }}, 'selesai')" title="Selesaikan Pesanan">
                                        <i class="fas fa-flag-checkered"></i> Selesai
                                    </button>
                                    <button type="button" class="btn-action btn-reject" onclick="confirmUpdate({{ $item->id }}, 'ditolak')" title="Batalkan Pesanan">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                @endif
                            </div>
                        </form>
                        @else
                            <span style="color: #cbd5e1; font-size: 12px; font-weight: 500;"><i class="fas fa-lock"></i></span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px; color: #94a3b8;">Belum ada pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmUpdate(id, statusValue) {
        let titleText = 'Konfirmasi';
        let bodyText = 'Apakah Anda yakin?';
        let confirmColor = '#3b82f6';

        if (statusValue === 'diproses') {
            titleText = 'Terima Pesanan?';
            bodyText = 'Status akan berubah menjadi "Diproses".';
            confirmColor = '#22c55e'; 
        } else if (statusValue === 'ditolak') {
            titleText = 'Tolak Pesanan?';
            bodyText = 'Pesanan akan dibatalkan dan STOK AKAN DIKEMBALIKAN.';
            confirmColor = '#ef4444'; 
        } else if (statusValue === 'selesai') {
            titleText = 'Selesaikan Pesanan?';
            bodyText = 'Pastikan pesanan sudah sampai ke customer.';
            confirmColor = '#3b82f6'; 
        }

        Swal.fire({
            title: titleText,
            text: bodyText,
            icon: statusValue === 'ditolak' ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Set value ke input hidden yang spesifik untuk ID ini
                document.getElementById('input-status-' + id).value = statusValue;
                
                // Tampilkan loading
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                // Submit form yang spesifik untuk ID ini
                document.getElementById('form-status-' + id).submit();
            }
        });
    }
</script>
@endsection