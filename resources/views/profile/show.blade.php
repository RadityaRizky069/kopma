@extends('layouts.main')

@section('title', 'Profil Pengguna - ' . $user->name)

@section('content')
{{-- Load Font, Icons, & Animate.css --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary: #10b981; 
        --primary-dark: #059669;
        --text-dark: #0f172a;
        --text-gray: #64748b;
        --bg-soft: #f8fafc;
        --border: #e2e8f0;
    }

    body {
        background-color: var(--bg-soft);
        font-family: 'Inter', sans-serif;
    }

    .profile-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* CARD UTAMA */
    .profile-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        position: relative;
        transition: transform 0.3s ease;
    }

    /* BANNER HEADER (ANIMASI GIF-LIKE) */
    .profile-banner {
        height: 220px;
        /* Default: Animasi Gradient bergerak */
        background: linear-gradient(-45deg, #10b981, #34d399, #065f46, #047857);
        background-size: 400% 400%;
        animation: gradientBG 10s ease infinite;
        position: relative;
    }

    /* Keyframes untuk membuat background bergerak seperti GIF */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Overlay pattern (hanya hiasan jika tidak ada gambar) */
    .profile-banner.no-img::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    /* FOTO PROFIL */
    .profile-avatar-wrapper {
        position: absolute;
        top: 150px; /* Sesuaikan dengan tinggi banner */
        left: 50%;
        transform: translateX(-50%);
        width: 130px;
        height: 130px;
        border-radius: 50%;
        padding: 5px;
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 10;
        transition: transform 0.3s ease;
    }

    .profile-avatar-wrapper:hover {
        transform: translateX(-50%) scale(1.05);
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: var(--text-gray);
        overflow: hidden;
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .profile-avatar:hover img {
        transform: scale(1.1);
    }

    /* INFO USER */
    .profile-info {
        margin-top: 80px;
        text-align: center;
        padding-bottom: 40px;
    }

    .user-name {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 5px;
        animation: fadeInDown 0.8s ease;
    }

    .user-email {
        color: var(--text-gray);
        font-size: 0.95rem;
        animation: fadeIn 1s ease;
    }

    .user-role-badge {
        display: inline-block;
        background: #dcfce7;
        color: #166534;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 15px;
        letter-spacing: 0.5px;
        animation: fadeInUp 1s ease;
    }
    
    .user-role-badge.admin {
        background: #e0f2fe;
        color: #0369a1;
    }

    /* STATISTIK */
    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid var(--border);
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        animation: fadeIn 1.2s ease;
    }

    .stat-item {
        text-align: center;
        transition: transform 0.2s;
    }
    
    .stat-item:hover {
        transform: translateY(-3px);
    }

    .stat-value {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
        display: block;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* TOMBOL AKSI */
    .action-buttons {
        margin-top: 40px;
        display: flex;
        justify-content: center;
        gap: 15px;
        animation: fadeInUp 1.4s ease;
    }

    .btn-back {
        text-decoration: none;
        color: var(--text-gray);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 12px;
        transition: 0.3s;
        background: #f1f5f9;
    }

    .btn-back:hover {
        background: #e2e8f0;
        color: var(--text-dark);
        transform: translateX(-3px);
    }
    
    .btn-edit {
        text-decoration: none;
        background: var(--primary);
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-edit:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.4);
    }
</style>

<div class="profile-container">
    {{-- Animasi Card Profil muncul dari bawah --}}
    <div class="profile-card animate__animated animate__fadeInUp">
        
        <!-- BANNER HEADER -->
        <!-- Jika user upload gambar (JPG/PNG/GIF), animasi CSS dimatikan dan gambar ditampilkan -->
        <div class="profile-banner {{ !$user->banner ? 'no-img' : '' }}" 
             style="{{ $user->banner ? 'background-image: url(' . asset('storage/' . $user->banner) . '); animation: none; background-size: cover;' : '' }}">
        </div>

        <!-- FOTO PROFIL -->
        <div class="profile-avatar-wrapper animate__animated animate__zoomIn animate__delay-1s">
            <div class="profile-avatar">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
        </div>

        <!-- INFORMASI USER -->
        <div class="profile-info">
            <h1 class="user-name">{{ $user->name }}</h1>
            <p class="user-email">{{ $user->email }}</p>
            
            <span class="user-role-badge {{ $user->role == 'admin' ? 'admin' : '' }}">
                {{ $user->role == 'admin' ? 'Administrator' : 'Member KOPMA' }}
            </span>

            <!-- STATISTIK -->
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $user->created_at->format('d M Y') }}</span>
                    <span class="stat-label">Bergabung Sejak</span>
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="action-buttons">
                <!-- Tombol Kembali menggunakan history.back() -->
                <a href="javascript:history.back()" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                {{-- Tombol Edit hanya muncul jika melihat profil sendiri --}}
                @if(auth()->check() && auth()->id() == $user->id)
                    <a href="{{ route('profile.edit') }}" class="btn-edit">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </a>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection