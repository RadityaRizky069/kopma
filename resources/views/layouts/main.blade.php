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
