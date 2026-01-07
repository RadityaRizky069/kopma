<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KOPMA')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #F9FAFB;
            color: #111827;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* BUTTON */
        .btn-primary {
            background: #16A34A;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #15803D;
        }

        /* CARD */
        .card {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E5E7EB;
        }

        .text-muted {
            color: #6B7280;
        }

        footer {
            margin-top: 80px;
            padding: 24px 0;
            text-align: center;
            font-size: 14px;
            color: #6B7280;
        }
    </style>
</head>
<body>

@include('navfoo.navbar')

<main class="container">
    @yield('content')
</main>

@include('navfoo.footer')

</body>
</html>
