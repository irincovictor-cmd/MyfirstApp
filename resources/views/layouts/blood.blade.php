<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BloodLink') — Blood Donation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #1c1917;
            --muted: #78716c;
            --bg: #faf7f5;
            --card: #ffffff;
            --line: #e7e0dc;
            --primary: #b91c1c;
            --primary-dark: #991b1b;
            --blood: #b91c1c;
            --blood-soft: #fef2f2;
            --ok: #15803d;
            --ok-soft: #ecfdf5;
            --warn: #a16207;
            --warn-soft: #fef9c3;
            --topbar: #1c1917;
            --font: "Outfit", system-ui, sans-serif;
            --shadow: 0 2px 12px rgba(28, 25, 23, 0.06);
        }
        * { box-sizing: border-box; margin: 0; }
        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--ink);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        a { color: inherit; text-decoration: none; }

        /* —— Top bar —— */
        .topbar {
            background: var(--topbar);
            color: #fafaf9;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .topbar-inner {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0.7rem 1.15rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            font-weight: 700;
            font-size: 1.05rem;
            color: #fafaf9;
            flex-shrink: 0;
        }
        .brand-mark {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--blood);
            display: grid;
            place-items: center;
            font-size: 0.85rem;
        }
        .nav {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 0.15rem;
            align-items: center;
            justify-content: flex-end;
        }
        .nav a,
        .nav button.linkish {
            display: inline-block;
            color: #a8a29e;
            padding: 0.35rem 0.6rem;
            border-radius: 6px;
            font-size: 0.84rem;
            font-weight: 500;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }
        .nav a:hover,
        .nav button.linkish:hover { color: #fafaf9; background: rgba(255,255,255,0.06); }
        .nav a.active { color: #fecaca; background: rgba(185, 28, 28, 0.25); }
        .nav .btn-admin {
            background: var(--blood) !important;
            color: #fff !important;
            font-weight: 600;
            padding: 0.35rem 0.7rem !important;
            border-radius: 6px;
        }
        .nav .who { color: #d6d3d1; font-size: 0.78rem; padding: 0.25rem 0.4rem; }

        .wrap {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem 1.15rem 2.5rem;
            width: 100%;
            flex: 1;
        }

        .alert {
            background: var(--ok-soft);
            color: var(--ok);
            border: 1px solid #bbf7d0;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .alert-error {
            background: #fef2f2;
            color: #9f1239;
            border-color: #fecdd3;
        }

        /* —— Buttons: fixed compact size (no giant pills) —— */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            padding: 0.45rem 0.9rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            line-height: 1.25;
            border: none;
            cursor: pointer;
            font-family: inherit;
            text-decoration: none;
            white-space: nowrap;
            max-width: max-content;
        }
        .btn-primary { background: var(--blood); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-light { background: #fff; color: var(--ink); }
        .btn-outline {
            background: transparent;
            color: #fff;
            box-shadow: inset 0 0 0 1.5px rgba(255,255,255,0.55);
        }
        .btn-ghost {
            background: #fff;
            color: var(--ink);
            box-shadow: inset 0 0 0 1px var(--line);
        }
        .btn-ghost:hover { background: #f5f5f4; }

        /* —— Hero —— */
        .hero {
            background: linear-gradient(145deg, #1c1917 0%, #44403c 50%, #b91c1c 100%);
            color: #fafaf9;
            border-radius: 14px;
            padding: 1.75rem 1.5rem;
            box-shadow: var(--shadow);
        }
        .hero-kicker {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #fecaca;
            margin-bottom: 0.5rem;
        }
        .hero h1 {
            font-size: clamp(1.5rem, 3.5vw, 2rem);
            font-weight: 700;
            margin: 0 0 0.5rem;
            color: #fff;
            line-height: 1.2;
        }
        .hero p { max-width: 36rem; color: #e7e5e4; font-size: 0.95rem; }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1.15rem;
        }

        .section-title { font-size: 1.25rem; font-weight: 700; margin: 0 0 0.2rem; }
        .section-sub { color: var(--muted); font-size: 0.9rem; margin: 0 0 1rem; }
        .head-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        .head-row .section-sub { margin-bottom: 0; }

        .grid-3, .grid-2 { display: grid; gap: 0.85rem; }
        .grid-3 { grid-template-columns: 1fr; }
        .grid-2 { grid-template-columns: 1fr; }
        @media (min-width: 640px) {
            .grid-3 { grid-template-columns: repeat(3, 1fr); }
            .grid-2 { grid-template-columns: 1fr 1fr; }
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 1rem 1.1rem;
            box-shadow: var(--shadow);
        }
        .card h3 { font-size: 0.98rem; margin: 0 0 0.25rem; }
        .card p { color: var(--muted); font-size: 0.88rem; }
        .stat { font-size: 1.6rem; font-weight: 700; letter-spacing: -0.02em; }
        .stat-label { font-size: 0.82rem; color: var(--muted); margin-top: 0.1rem; }

        .feature { display: flex; gap: 0.75rem; align-items: flex-start; }
        .feature-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--blood-soft);
            color: var(--blood);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .feature-icon.blood { background: var(--blood-soft); color: var(--blood); }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .quick-link:hover {
            border-color: #f0b4bc;
            box-shadow: 0 4px 14px rgba(185, 28, 28, 0.1);
        }
        .quick-link strong { display: block; font-size: 0.92rem; }
        .quick-link span { display: block; color: var(--muted); font-size: 0.8rem; margin-top: 0.1rem; }

        .table-wrap {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: var(--card);
        }
        table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
        th, td { text-align: left; padding: 0.7rem 0.9rem; border-bottom: 1px solid var(--line); }
        th {
            color: var(--muted);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            background: #faf7f5;
            font-weight: 600;
        }
        tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 999px;
            background: var(--blood-soft);
            color: var(--blood);
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status {
            display: inline-block;
            padding: 0.15rem 0.45rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-pending { background: var(--warn-soft); color: var(--warn); }
        .status-approved, .status-active, .status-resolved { background: var(--ok-soft); color: var(--ok); }
        .status-rejected, .status-closed { background: #fef2f2; color: #9f1239; }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 0.65rem;
            margin-bottom: 1rem;
        }
        .filter-bar .field { margin-bottom: 0; min-width: 9rem; }

        .empty { text-align: center; padding: 2rem 1.25rem; }
        .empty-icon { font-size: 1.75rem; margin-bottom: 0.5rem; }
        .empty h3 { margin: 0 0 0.35rem; font-size: 1.05rem; }
        .empty p { color: var(--muted); margin: 0 0 1rem; font-size: 0.9rem; }

        .form-page { max-width: 28rem; margin: 0 auto; }
        .form-page .section-title,
        .form-page .section-sub { text-align: center; }
        .form-card {
            margin-top: 0.65rem;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 1.25rem 1.2rem;
            box-shadow: var(--shadow);
        }
        .field { margin-bottom: 0.85rem; }
        label {
            display: block;
            font-weight: 600;
            font-size: 0.82rem;
            margin-bottom: 0.3rem;
        }
        .hint { font-size: 0.78rem; color: var(--muted); margin-top: 0.2rem; }
        input, select, textarea {
            width: 100%;
            padding: 0.55rem 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: #fff;
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--ink);
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.15);
        }
        textarea { resize: vertical; min-height: 90px; }
        .form-actions {
            margin-top: 1.1rem;
            display: flex;
            gap: 0.45rem;
            flex-wrap: wrap;
        }

        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--line);
            font-size: 0.88rem;
        }
        .list-item:last-child { border-bottom: none; }
        .list-item .name { font-weight: 600; }

        .scroll-hint { display: none; font-size: 0.78rem; color: var(--muted); margin-bottom: 0.5rem; }
        @media (max-width: 640px) {
            .scroll-hint { display: block; }
            .topbar-inner { flex-direction: column; align-items: flex-start; }
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        .pagination-info { color: var(--muted); font-size: 0.82rem; }

        footer {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1.15rem 1.5rem;
            color: var(--muted);
            font-size: 0.78rem;
            width: 100%;
        }
        code {
            font-size: 0.8em;
            background: #e7e5e4;
            padding: 0.1em 0.3em;
            border-radius: 4px;
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
                <li><span class="who">{{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}: {{ auth()->user()->name }}</span></li>
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

<footer>BloodLink · compact UI · Laravel Auth</footer>
</body>
</html>
