<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KOPMA - Koperasi Mahasiswa')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* 1. CSS VARIABLES - Sistem Warna Premium */
        :root {
            --bg: #F8FAFC;
            --surface: #FFFFFF;
            --primary: #15803D;
            --primary-dark: #166534;
            --primary-soft: #DCFCE7;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --radius-lg: 20px;
            --radius-md: 12px;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        /* 2. RESET & BASE STYLES */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; transition: 0.2s; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* 3. NAVBAR OPTIMIZATION */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .navbar-inner {
            height: 72px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 20px;
            color: var(--primary);
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), #22C55E);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(21, 128, 61, 0.2);
        }

        .navbar-menu {
            display: flex;
            gap: 32px;
        }

        .nav-link {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            position: relative;
        }

        .nav-link:hover, .nav-link.active { color: var(--primary); }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -24px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary);
            border-radius: 10px 10px 0 0;
        }

        /* 4. BUTTONS */
        .btn {
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(21, 128, 61, 0.2);
        }

        /* 5. AUTH PAGE - SPLIT DESIGN */
        .auth-wrapper {
            min-height: calc(100vh - 72px);
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
        }

        .auth-left {
            background: #064E3B;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(34, 197, 94, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(21, 128, 61, 0.2) 0%, transparent 40%);
            color: white;
            padding: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-left h1 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            z-index: 2;
        }

        .auth-left p {
            font-size: 18px;
            opacity: 0.85;
            max-width: 480px;
            z-index: 2;
        }

        /* Floating Decoration Card */
        .floating-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 24px;
            border-radius: var(--radius-lg);
            margin-top: 48px;
            max-width: 320px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .auth-right {
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .auth-card {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 48px;
            border-radius: 24px;
            box-shadow: var(--shadow);
            animation: slideUp 0.6s ease-out forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* 6. FORM STYLES */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-muted);
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            background: #F9FAFB;
            transition: 0.2s;
            font-size: 15px;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        /* 7. FOOTER */
        footer {
            padding: 48px 0;
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            background: white;
        }

        /* 8. RESPONSIVE DESIGN */
        @media (max-width: 992px) {
            .auth-wrapper { grid-template-columns: 1fr; }
            .auth-left { display: none; }
            .navbar-menu { display: none; } /* Mobile menu logic needed here */
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container navbar-inner">
        <a href="/" class="navbar-brand">
            <div class="brand-logo">K</div>
            <span class="brand-text">KOPMA</span>
        </a>

        <div class="navbar-menu">
            <a href="#" class="nav-link active">Beranda</a>
            <a href="#" class="nav-link">Produk</a>
            <a href="#" class="nav-link">Layanan</a>
            <a href="#" class="nav-link">Tentang</a>
        </div>

        <div class="navbar-action">
            <a href="/login" class="btn btn-primary">Masuk Akun</a>
        </div>
    </div>
</nav>

<main>
    <div class="auth-wrapper">
        <div class="auth-left">
            <h1>Mulai Langkah <br>Ekonomi Mandiri.</h1>
            <p>Bergabung dengan Koperasi Mahasiswa untuk akses layanan finansial dan produk terbaik di kampus.</p>
            
            <div class="floating-card">
                <p style="font-weight: 700; font-size: 14px;">🚀 Update Terbaru</p>
                <p style="font-size: 13px; opacity: 0.8; margin-top: 8px;">Sekarang pembayaran simpanan bisa melalui QRIS & E-Wallet.</p>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-card">
                <h2 style="margin-bottom: 8px; font-size: 24px;">Selamat Datang</h2>
                <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 32px;">Silakan masukkan kredensial Anda untuk masuk.</p>

                <form>
                    <div class="form-group">
                        <label>Email Mahasiswa</label>
                        <input type="email" placeholder="nama@kampus.ac.id">
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <input type="password" placeholder="••••••••">
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Masuk ke Dashboard</button>
                    
                    <p style="text-align: center; font-size: 14px; margin-top: 24px; color: var(--text-muted);">
                        Belum punya akun? <a href="#" style="color: var(--primary); font-weight: 600;">Daftar Sekarang</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    
    {{-- @yield('content') --}}
</main>

<footer>
    <div class="container">
        <p>&copy; 2024 Koperasi Mahasiswa (KOPMA). Build with passion for students.</p>
    </div>
</footer>

</body>
</html>