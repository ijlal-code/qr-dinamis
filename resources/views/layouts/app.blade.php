<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'QR Dinamis')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --text: #0f172a;
            --muted: #475569;
            --border: #e2e8f0;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Inter', system-ui, -apple-system, sans-serif; background: var(--bg); color: var(--text); }
        a { color: var(--primary); text-decoration: none; }
        header { position: sticky; top: 0; z-index: 10; background: rgba(248,250,252,0.98); backdrop-filter: blur(8px); border-bottom: 1px solid var(--border); }
        nav { max-width: 1080px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; gap: 16px; }
        .brand { font-weight: 800; letter-spacing: -0.02em; display: flex; align-items: center; gap: 10px; color: var(--text); }
        .brand span { display: inline-block; padding: 8px 10px; background: #e0e7ff; color: #1d4ed8; border-radius: 10px; font-size: 14px; }
        .nav-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .nav-links { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .nav-link { font-weight: 700; color: var(--text); padding: 8px 10px; border-radius: 10px; }
        .nav-link.active, .nav-link:hover { background: #e2e8f0; }
        .btn { border: none; border-radius: 12px; padding: 10px 14px; font-weight: 700; cursor: pointer; transition: transform 0.15s ease, box-shadow 0.15s ease; }
        .btn.primary { background: var(--primary); color: #fff; box-shadow: 0 8px 22px rgba(37,99,235,0.25); }
        .btn.primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .btn.ghost { background: #e2e8f0; color: var(--text); }
        .btn.danger { background: #ef4444; color: #fff; }
        main { max-width: 1080px; margin: 0 auto; padding: 18px; display: grid; gap: 16px; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 18px; box-shadow: var(--shadow); }
        .muted { color: var(--muted); }
        .badge { display: inline-flex; align-items: center; gap: 6px; background: #e0f2fe; color: #0c4a6e; border-radius: 10px; padding: 6px 10px; font-size: 13px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 12px 10px; border-bottom: 1px solid var(--border); text-align: left; }
        .table th { color: var(--muted); font-weight: 700; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .input { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid var(--border); background: #f8fafc; font-size: 15px; }
        .input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.15); background: #fff; }
        form { display: grid; gap: 14px; }
        .alert { padding: 12px 14px; border-radius: 12px; border: 1px solid var(--border); background: #ecfeff; color: #0ea5e9; }
        .empty { text-align: center; color: var(--muted); padding: 12px 6px; }
        footer { text-align: center; color: var(--muted); padding: 16px; font-size: 14px; }
        .chip { background: #eef2ff; color: #3730a3; padding: 6px 10px; border-radius: 10px; font-size: 13px; }
        @media (max-width: 900px) { nav { flex-wrap: wrap; } }
        @media (max-width: 520px) { nav { padding: 12px 14px; } .card { padding: 16px; } }
    </style>
    @stack('styles')
</head>
<body>
<header>
    <nav>
        <a href="{{ route('home') }}" class="brand">QR Dinamis <span>ringan</span></a>
        <div class="nav-actions">
            @auth
                <div class="nav-links">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="nav-link {{ request()->routeIs('qr-links.*') ? 'active' : '' }}" href="{{ route('qr-links.create') }}">Buat QR</a>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn ghost" type="submit">Keluar</button>
                </form>
            @endauth
            @guest
                <a class="btn ghost" href="{{ route('login') }}">Masuk</a>
                <a class="btn primary" href="{{ route('register') }}">Daftar</a>
            @endguest
        </div>
    </nav>
</header>
<main>
    @yield('content')
</main>
<footer>Ringan, responsif, dan siap dibagikan.</footer>
@stack('scripts')
</body>
</html>
