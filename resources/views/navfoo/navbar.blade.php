<nav style="
    background:#FFFFFF;
    border-bottom:1px solid #E5E7EB;
">
    <div class="container" style="
        height:64px;
        display:flex;
        align-items:center;
        justify-content:space-between;
    ">
        <div style="font-weight:600; font-size:18px;">
            KOPMA
        </div>

        <div style="display:flex; gap:16px; align-items:center;">
            <a href="{{ route('login') }}" class="text-muted">Login</a>
            <a href="{{ route('register') }}" class="btn-primary">Register</a>
        </div>
    </div>

    <!-- accent strip -->
    <div style="height:3px; background:#16A34A;"></div>
</nav>
