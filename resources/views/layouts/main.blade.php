<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KOPMA')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 24px;
        }

        /* BUTTON */
        .btn {
            padding: 14px 26px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: .25s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(21,128,61,.25);
        }

        /* CARD */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--border);
            transition: .3s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,.08);
        }

        footer {
            margin-top: 120px;
            padding: 48px 0;
            text-align: center;
            font-size: 14px;
            color: var(--muted);
            border-top: 1px solid var(--border);
        }
        /* NAVBAR */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255,255,255,.85);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--border);
}

.navbar-inner {
    height: 80px;
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 800;
    font-size: 20px;
}

.brand-logo {
    width: 40px;
    height: 40px;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-weight: 800;
}

.brand-text {
    letter-spacing: .5px;
}

.navbar-menu {
    display: flex;
    justify-content: center;
    gap: 32px;
}

.nav-link {
    font-size: 14px;
    font-weight: 500;
    color: var(--muted);
    position: relative;
    padding: 6px 0;
    transition: .2s ease;
}

.nav-link:hover {
    color: var(--text);
}

.nav-link.active {
    color: var(--text);
}

.nav-link.active::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -10px;
    width: 100%;
    height: 3px;
    background: var(--primary);
    border-radius: 999px;
}

.navbar-action {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-login {
    font-size: 14px;
    font-weight: 500;
    color: var(--text);
}
/* AUTH PAGE */
.auth-wrapper {
    min-height: calc(100vh - 80px);
    display: grid;
    grid-template-columns: 1.1fr .9fr;
}

/* ===== AUTH LEFT (IMPROVED ONLY) ===== */
.auth-left {
    position: relative;
    background: linear-gradient(145deg, #15803D, #22C55E);
    color: white;
    padding: 96px 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    overflow: hidden;
}

/* dekorasi halus */
.auth-left::before {
    content: '';
    position: absolute;
    width: 320px;
    height: 320px;
    background: rgba(255,255,255,.08);
    border-radius: 50%;
    top: -120px;
    left: -120px;
}

.auth-left::after {
    content: '';
    position: absolute;
    width: 420px;
    height: 420px;
    background: rgba(255,255,255,.06);
    border-radius: 50%;
    bottom: -160px;
    right: -160px;
}

/* biar teks nyaman dibaca */
.auth-left h1 {
    font-size: 44px;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 20px;
}

.auth-left p {
    font-size: 17px;
    line-height: 1.7;
    opacity: .92;
    max-width: 420px;
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
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 30px 60px rgba(0,0,0,.08);
}

.auth-card h2 {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 8px;
}

.auth-card p {
    color: var(--muted);
    font-size: 14px;
    margin-bottom: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
}

.form-group input {
    padding: 14px;
    border-radius: 14px;
    border: 1px solid var(--border);
    font-size: 14px;
}

.form-group input:focus {
    outline: none;
    border-color: var(--primary);
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
}
/* ===== AUTH ANIMATION ===== */
@keyframes fadeSlideLeft {
    from {
        opacity: 0;
        transform: translateX(-40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeSlideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* apply animation */
.auth-left {
    animation: fadeSlideLeft .8s ease forwards;
}

.auth-card {
    animation: fadeSlideUp .8s ease forwards;
    animation-delay: .15s;
    opacity: 0;
}
/* ===== REMOVE FOOTER GAP ON AUTH PAGE ONLY ===== */
main:has(.auth-wrapper) + footer {
    margin-top: 0;
}




    </style>
</head>
<body>

@include('navfoo.navbar')

<main>
    @yield('content')
</main>

@include('navfoo.footer')

</body>
</html>
