<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KOPMA')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg: #F9FAFB;
            --surface: #FFFFFF;
            --primary: #15803D;
            --primary-soft: #DCFCE7;
            --text: #111827;
            --muted: #6B7280;
            --border: #E5E7EB;
            --radius: 20px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            transition: background 0.3s, color 0.3s;
        }

        a { text-decoration: none; color: inherit; }

        .container { max-width: 1200px; margin: auto; padding: 0 24px; }

        /* BUTTON */
        .btn {
            padding: 14px 26px; border-radius: 14px; font-weight: 600; font-size: 14px;
            border: none; cursor: pointer; transition: .25s ease;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(21,128,61,.25); }

        /* CARD */
        .card {
            background: var(--surface); border-radius: var(--radius); padding: 20px;
            border: 1px solid var(--border); transition: .3s ease;
        }
        .card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.08); }

        footer {
            margin-top: 120px; padding: 48px 0; text-align: center;
            font-size: 14px; color: var(--muted); border-top: 1px solid var(--border);
        }

        /* --- DARK MODE STYLES --- */
        body.dark-mode {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
            --bg: #0f172a; --surface: #1e293b; --text: #f1f5f9; --muted: #94a3b8; --border: #334155;
        }
        
        /* Paksa elemen putih jadi gelap */
        body.dark-mode nav, body.dark-mode .card, body.dark-mode .cart-item, 
        body.dark-mode .cart-summary, body.dark-mode .auth-card,
        body.dark-mode div[style*="background: white"] {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5) !important;
        }

        body.dark-mode input, body.dark-mode select {
            background-color: #334155 !important; border-color: #475569 !important; color: white !important;
        }

        /* Warna Ikon & Teks di Navbar saat Dark Mode */
        body.dark-mode a[style*="color: #1e293b"], 
        body.dark-mode button[style*="color: #64748b"] {
            color: #f1f5f9 !important;
        }
        
        /* Hover tetap hijau */
        body.dark-mode a[style*="color: #1e293b"]:hover,
        body.dark-mode button[style*="color: #64748b"]:hover {
            color: #22c55e !important;
        }

        /* NAVBAR */
        .navbar {
            position: sticky; top: 0; z-index: 1000;
            background: rgba(255,255,255,.85); backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
        }
        
        /* AUTH CSS (Sesuai kode kamu) */
        .auth-wrapper { min-height: calc(100vh - 80px); display: grid; grid-template-columns: 1.1fr .9fr; }
        .auth-left { position: relative; background: linear-gradient(145deg, #15803D, #22C55E); color: white; padding: 96px 80px; display: flex; flex-direction: column; justify-content: center; overflow: hidden; }
        .auth-left::before { content: ''; position: absolute; width: 320px; height: 320px; background: rgba(255,255,255,.08); border-radius: 50%; top: -120px; left: -120px; }
        .auth-left::after { content: ''; position: absolute; width: 420px; height: 420px; background: rgba(255,255,255,.06); border-radius: 50%; bottom: -160px; right: -160px; }
        .auth-left h1 { font-size: 44px; font-weight: 800; line-height: 1.2; margin-bottom: 20px; }
        .auth-left p { font-size: 17px; line-height: 1.7; opacity: .92; max-width: 420px; }
        .auth-right { background: var(--bg); display: flex; align-items: center; justify-content: center; padding: 40px; }
        .auth-card { background: white; width: 100%; max-width: 420px; padding: 40px; border-radius: 24px; box-shadow: 0 30px 60px rgba(0,0,0,.08); }
        .auth-card h2 { font-size: 26px; font-weight: 700; margin-bottom: 8px; }
        .auth-card p { color: var(--muted); font-size: 14px; margin-bottom: 24px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: 600; }
        .form-group input { padding: 14px; border-radius: 14px; border: 1px solid var(--border); font-size: 14px; }
        .form-group input:focus { outline: none; border-color: var(--primary); }
        .auth-footer { text-align: center; margin-top: 20px; font-size: 14px; }
        
        @keyframes fadeSlideLeft { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        .auth-left { animation: fadeSlideLeft .8s ease forwards; }
        .auth-card { animation: fadeSlideUp .8s ease forwards; animation-delay: .15s; opacity: 0; }
        main:has(.auth-wrapper) + footer { margin-top: 0; }
    </style>
</head>
<body>

{{-- INCLUDE NAVBAR DI SINI --}}
@include('navfoo.navbar')

<main>
    @yield('content')
</main>

{{-- Pastikan ada file navfoo/footer.blade.php, atau pakai footer manual --}}
<footer>
    © 2026 KOPMA Mahasiswa. All rights reserved.
</footer>

<script>
    // --- LOGIKA DARK MODE ---
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
    }
    function toggleTheme() {
        document.body.classList.toggle('dark-mode');
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    }

    // --- SWEETALERT ---
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", showConfirmButton: false, timer: 3000 });
    @endif

    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}", confirmButtonColor: '#15803D' });
    @endif

    @if($errors->any())
        Swal.fire({ icon: 'warning', title: 'Perhatian', text: "{{ $errors->first() }}", confirmButtonColor: '#15803D' });
    @endif
</script>

</body>
</html>