@extends('layouts.main')

@section('title', 'Login KOPMA')

@section('content')

<!-- LOGIN FORM -->
<section style="padding:60px 0; max-width:400px; margin:auto;">
    <h1 style="font-size:28px; font-weight:700; margin-bottom:16px; text-align:center;">
        Login KOPMA
    </h1>

    @if(session('error'))
        <div style="color:red; margin-bottom:12px; text-align:center;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" style="display:flex; flex-direction:column; gap:12px;">
        @csrf

        <div>
            <label for="email" style="font-weight:600;">Email</label>
            <input type="email" name="email" id="email" required
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <div>
            <label for="password" style="font-weight:600;">Password</label>
            <input type="password" name="password" id="password" required
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <button type="submit" style="
            padding:10px;
            background-color:#007bff;
            color:white;
            font-weight:600;
            border:none;
            border-radius:4px;
            cursor:pointer;
        ">
            Login
        </button>
    </form>

    <p style="text-align:center; margin-top:12px; font-size:14px;">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </p>
</section>

@endsection
