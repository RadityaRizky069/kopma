@extends('layouts.main')

@section('title', 'Register KOPMA')

@section('content')

<!-- REGISTER FORM -->
<section style="padding:60px 0; max-width:400px; margin:auto;">
    <h1 style="font-size:28px; font-weight:700; margin-bottom:16px; text-align:center;">
        Daftar Akun KOPMA
    </h1>

    @if ($errors->any())
        <div style="color:red; margin-bottom:12px; text-align:center;">
            <ul style="padding-left:0; list-style:none;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST" style="display:flex; flex-direction:column; gap:12px;">
        @csrf

        <div>
            <label for="name" style="font-weight:600;">Nama</label>
            <input type="text" name="name" id="name" required
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

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

        <div>
            <label for="password_confirmation" style="font-weight:600;">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px
