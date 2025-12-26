<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard')</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    {{-- CSS Dashboard (DITAMBAHKAN) --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body style="background:linear-gradient(135deg,#667eea,#764ba2);">

<div class="d-flex min-vh-100">

    <!-- ========== SIDEBAR PAYSMAK (FINAL) ========== -->
    <!-- ========== SIDEBAR ========== -->
<aside class="p-4 border-end"
       style="width:260px; background:#ffffff; border-radius:0 18px 18px 0;">

    <h3 class="fw-bold mb-4 d-flex align-items-center gap-2" style="color:#667eea;">
        <span class="logo-icon">
            <svg width="28" height="28" viewBox="0 0 20 18" fill="none">
                <rect x="1" y="4" width="18" height="13" rx="2"
                      stroke="#667eea" stroke-width="2"/>
                <path d="M4 4V2H8L10 3H15V4"
                      stroke="#667eea" stroke-width="2"/>
            </svg>
        </span>
        PaySMK
    </h3>

    <nav class="d-flex flex-column gap-2">

        <a href="{{ route('siswa.dashboard') }}"
           class="btn btn-light text-start {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('siswa.tagihan') }}"
           class="btn btn-light text-start {{ request()->routeIs('siswa.tagihan') ? 'active' : '' }}">
            💰 Tagihan
        </a>

        <a href="{{ route('siswa.riwayat') }}"
           class="btn btn-light text-start {{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
            📜 Riwayat Pembayaran
        </a>

        <a href="{{ route('siswa.profil') }}"
           class="btn btn-light text-start {{ request()->routeIs('siswa.profil') ? 'active' : '' }}">
            👤 Profil
        </a>

    </nav>

    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-danger w-100">Logout</button>
    </form>

</aside>

    <!-- ========== END SIDEBAR ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <main class="flex-grow-1 p-4">
        @yield('content')
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
