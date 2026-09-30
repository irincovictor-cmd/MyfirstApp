<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BloodLink') — Blood Donation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #1c1917;
            --muted: #78716c;
            --bg: #faf7f5;
            --card: #ffffff;
            --line: #e7e0dc;
            --primary: #c41e3a;
            --primary-dark: #9f1830;
            --blood: #c41e3a;
            --blood-soft: #fce8ec;
            --ok: #15803d;
            --ok-soft: #ecfdf5;
            --topbar: #1a1214;
            --radius: 1rem;
            --font: "Outfit", system-ui, sans-serif;
            --display: "Fraunces", Georgia, serif;
            --shadow: 0 4px 24px rgba(28, 25, 23, 0.06);
            --shadow-lg: 0 16px 40px rgba(28, 25, 23, 0.1);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: var(--font);
            background: var(--bg);
            color: var(--ink);
            line-height: 1.55;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        a { color: inherit; }
        .topbar {
            background: var(--topbar);
            color: #faf7f5;
            position: sticky;
            top: 0;
            z-index: 40;
            border-bottom: 1px solid rgba(196, 30, 58, 0.25);
        }
        .topbar-inner {
            max-width: 1080px;
            margin: 0 auto;
            padding: 0.85rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            font-weight: 700;
            text-decoration: none;
            color: #faf7f5;
        }
        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(145deg, #e11d48, #c41e3a);
            display: grid;
            place-items: center;
        }
        .nav {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 0.15rem;
            align-items: center;
        }
        .nav a, .nav button.linkish {
            text-decoration: none;
            color: #a8a29e;
            padding: 0.4rem 0.7rem;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 500;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }
        .nav a:hover, .nav button.linkish:hover { background: rgba(255,255,255,0.06); color: #faf7f5; }
        .nav a.active { background: rgba(196, 30, 58, 0.2); color: #fda4af; }
        .nav .btn-admin {
            background: var(--blood);
            color: #fff !important;
            font-weight: 600;
        }
        .nav .who { color: #d6d3d1; font-size: 0.8rem; padding: 0.35rem 0.5rem; }
        .wrap { max-width: 1080px; margin: 0 auto; padding: 1.75rem 1.25rem 3rem; width: 100%; flex: 1; }
        .alert { background: var(--ok-soft); color: var(--ok); border: 1px solid #bbf7d0; padding: 0.9rem 1.1rem; border-radius: 0.75rem; margin-bottom: 1.25rem; }
        .alert-error { background: #fef2f2; color: #9f1239; border-color: #fecdd3; }
        .hero {
            background: linear-gradient(145deg, #1a1214 0%, #3f1219 55%, #c41e3a 100%);
            color: #faf7f5;
            border-radius: 1.25rem;
            padding: 2.75rem 2rem;
            box-shadow: var(--shadow-lg);
        }
        .hero-kicker { text-transform: uppercase; letter-spacing: 0.12em; font-size: 0.72rem; font-weight: 600; color: #fda4af; margin-bottom: 0.75rem; }
        .hero h1 { font-family: var(--display); font-size: clamp(1.9rem, 4.5vw, 2.85rem); margin: 0 0 0.75rem; color: #fff; }
        .hero p { max-width: 34rem; margin: 0; color: #e7e0dc; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 0.65rem; margin-top: 1.5rem; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.7rem 1.2rem; border-radius: 999px; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer; font-family: inherit; font-size: 0.92rem;
        }
        .btn-light { background: #fff; color: var(--ink); }
        .btn-outline { background: transparent; color: #fff; box-shadow: inset 0 0 0 1.5px rgba(255,255,255,0.55); }
        .btn-primary { background: var(--blood); color: #fff; }
        .btn-ghost { background: #fff; color: var(--ink); box-shadow: inset 0 0 0 1px var(--line); }
        .section-title { font-family: var(--display); font-size: 1.5rem; margin: 0 0 0.3rem; }
        .section-sub { color: var(--muted); margin: 0 0 1.25rem; }
        .head-row { display: flex; justify-content: space-between; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
        .grid-3 { display: grid; gap: 1rem; grid-template-columns: 1fr; }
        .grid-2 { display: grid; gap: 1rem; }
        @media (min-width: 640px) {
            .grid-3 { grid-template-columns: repeat(3, 1fr); }
            .grid-2 { grid-template-columns: 1fr 1fr; }
        }
        .card { background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 1.25rem; box-shadow: var(--shadow); }
        .stat { font-size: 1.85rem; font-weight: 700; }
        .table-wrap { overflow-x: auto; border-radius: var(--radius); border: 1px solid var(--line); background: var(--card); }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th, td { text-align: left; padding: 0.85rem 1rem; border-bottom: 1px solid var(--line); }
        th { color: var(--muted); font-size: 0.72rem; text-transform: uppercase; background: #faf7f5; }
        .badge { display: inline-block; padding: 0.22rem 0.6rem; border-radius: 999px; background: var(--blood-soft); color: var(--blood); font-size: 0.78rem; font-weight: 600; }
        .form-page { max-width: 32rem; margin: 0 auto; }
        .form-page .section-title, .form-page .section-sub { text-align: center; }
        .form-card {
            margin-top: 0.75rem; background: var(--card); border: 1px solid var(--line);
            border-radius: 1.15rem; padding: 1.65rem 1.6rem; box-shadow: var(--shadow-lg);
        }
        .field { margin-bottom: 1rem; }
        label { display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem; }
        .hint { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; }
        input, select, textarea {
            width: 100%; padding: 0.72rem 0.9rem; border-radius: 0.7rem;
            border: 1px solid var(--line); background: #fff; font-family: inherit; font-size: 0.95rem;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(196, 30, 58, 0.18);
        }
        .form-actions { margin-top: 1.35rem; display: flex; gap: 0.55rem; flex-wrap: wrap; }
        footer { max-width: 1080px; margin: 0 auto; padding: 0 1.25rem 2rem; color: var(--muted); font-size: 0.82rem; width: 100%; }
        code { font-size: 0.85em; background: #e7e0dc; padding: 0.1em 0.35em; border-radius: 0.3em; }
        @media (max-width: 640px) {
            .topbar-inner { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="{{ route('blood.home') }}">
            <span class="brand-mark">🩸</span>
            BloodLink
        </a>
        <ul class="nav">
            <li><a href="{{ route('blood.home') }}" class="{{ request()->routeIs('blood.home') ? 'active' : '' }}">Home</a></li>

            @auth
                <li><a href="{{ route('blood.donors') }}" class="{{ request()->routeIs('blood.donors*') ? 'active' : '' }}">Donors</a></li>
                <li><a href="{{ route('blood.requests') }}" class="{{ request()->routeIs('blood.requests*') ? 'active' : '' }}">Requests</a></li>
            @endauth

            <li><a href="{{ route('blood.contact') }}" class="{{ request()->routeIs('blood.contact') ? 'active' : '' }}">Contact</a></li>
            <li><a href="{{ route('blood.pages') }}" class="{{ request()->routeIs('blood.pages*') ? 'active' : '' }}">Pages</a></li>

            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a class="btn-admin" href="{{ route('blood.admin.dashboard') }}">Admin</a></li>
                @endif
                <li><span class="who">{{ auth()->user()->role === 'admin' ? 'Admin' : 'User' }}: {{ auth()->user()->name }}</span></li>
                <li>
                    <form action="{{ route('blood.logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="linkish">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('blood.login') }}">Login</a></li>
                <li><a href="{{ route('blood.register') }}">Register</a></li>
            @endauth
        </ul>
    </div>
</header>

<div class="wrap">
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if(isset($errors) && $errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:1.1rem;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</div>

<footer>BloodLink · Laravel Auth + role middleware</footer>
</body>
</html>
