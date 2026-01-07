<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KOPMA')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #F8F9FA;
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    @include('navfoo.navbar')

    {{-- CONTENT --}}
    <main class="container my-4">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('navfoo.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
