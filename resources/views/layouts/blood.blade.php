<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BloodLink') — Blood Donation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #1f1418;
            --muted: #5c4a52;
            --bg: #efe4e6;
            --card: #ffffff;
            --line: #d4b8be;
            --primary: #b3122d;
            --primary-dark: #8c0e23;
            --blood: #b3122d;
            --blood-soft: #fce4e8;
            --accent: #d98c2b;
            --accent-ink: #2b1b07;
            --ok: #1a7f4e;
            --ok-soft: #e6f6ed;
            --warn: #b7791f;
            --warn-soft: #fef3c7;
            --topbar: #ffffff;
            --font: "Manrope", system-ui, sans-serif;
            --shadow: 0 2px 8px rgba(36, 26, 29, 0.1);
        }
        * { box-sizing: border-box; margin: 0; }
        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--ink);
            line-height: 1.45;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        a { color: inherit; text-decoration: none; }

        .topbar {
            background: var(--topbar);
            color: var(--ink);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 1px 4px rgba(36, 26, 29, 0.06);
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .topbar-inner {
            max-width: 1040px;
            margin: 0 auto;
            padding: 0.85rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 800;
            font-size: 1.05rem;
            color: var(--ink);
        }
        .brand-mark {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: var(--blood);
            color: #fff;
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
        }
        .nav a, .nav button.linkish {
            display: inline-block;
            color: var(--muted);
            padding: 0.35rem 0.55rem;
            border-radius: 7px;
            font-size: 0.84rem;
            font-weight: 600;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }
        .nav a:hover, .nav button.linkish:hover { color: var(--ink); background: var(--bg); }
        .nav a.active { color: var(--blood); font-weight: 800; background: var(--blood-soft); }
        .nav .btn-admin {
            background: var(--blood) !important;
            color: #fff !important;
            font-weight: 700;
            padding: 0.35rem 0.7rem !important;
        }
        .nav .who { color: var(--muted); font-size: 0.78rem; padding: 0.3rem 0.4rem; }

        .wrap {
            max-width: 1040px;
            margin: 0 auto;
            padding: 1.1rem 1rem 1.75rem;
            width: 100%;
            flex: 1;
        }

        .alert {
            background: var(--ok-soft);
            color: var(--ok);
            border: 1px solid #86efac;
            padding: 0.55rem 0.85rem;
            border-radius: 8px;
            margin-bottom: 0.85rem;
            font-size: 0.86rem;
            font-weight: 600;
        }
        .alert-error { background: #fef2f2; color: #9f1239; border-color: #fecdd3; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.84rem;
            line-height: 1.2;
            border: none;
            cursor: pointer;
            font-family: inherit;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary { background: var(--blood); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-amber { background: var(--accent); color: var(--accent-ink); }
        .btn-amber:hover { background: #c17a1f; }
        .btn-light { background: #fff; color: var(--ink); }
        .btn-outline {
            background: transparent;
            color: #fff;
            box-shadow: inset 0 0 0 1.5px rgba(255,255,255,0.55);
        }
        .btn-ghost {
            background: #fff;
            color: var(--ink);
            box-shadow: inset 0 0 0 1.5px var(--line);
        }

        .hero {
            background: linear-gradient(135deg, #2a1218 0%, #6b1528 45%, #b3122d 100%);
            color: #fff8f7;
            border-radius: 16px;
            padding: 1.5rem 1.35rem;
            box-shadow: 0 4px 14px rgba(179, 18, 45, 0.25);
        }
        .hero-kicker {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #f9b4c0;
            margin-bottom: 0.4rem;
        }
        .hero h1 {
            font-size: clamp(1.45rem, 3.2vw, 1.95rem);
            font-weight: 800;
            margin: 0 0 0.4rem;
            color: #fff;
        }
        .hero p { max-width: 34rem; color: #f5e4e7; font-size: 0.92rem; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 0.45rem; margin-top: 1rem; }

        .section-title { font-size: 1.1rem; font-weight: 800; margin: 0 0 0.15rem; }
        .section-sub { color: var(--muted); font-size: 0.84rem; margin: 0 0 0.7rem; }
        .head-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 0.75rem;
        }
        .head-row .section-sub { margin-bottom: 0; }

        .grid-3, .grid-2, .grid-5 { display: grid; gap: 0.75rem; }
        .grid-3 { grid-template-columns: 1fr; }
        .grid-2 { grid-template-columns: 1fr; }
        .grid-5 { grid-template-columns: repeat(2, 1fr); }
        @media (min-width: 640px) {
            .grid-3 { grid-template-columns: repeat(3, 1fr); }
            .grid-2 { grid-template-columns: 1fr 1fr; }
            .grid-5 { grid-template-columns: repeat(5, 1fr); }
        }

        .card {
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 12px;
            padding: 0.9rem 1rem;
            box-shadow: var(--shadow);
        }
        .card h3 { font-size: 0.92rem; margin: 0 0 0.2rem; }
        .card p { color: var(--muted); font-size: 0.84rem; }

        .stat-card {
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 12px;
            padding: 0.85rem 0.95rem;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--blood);
        }
        .stat-card.tone-ok { border-left-color: #1a7f4e; }
        .stat-card.tone-warn { border-left-color: var(--accent); }
        .stat-card.tone-blue { border-left-color: #2563eb; }
        .stat-card.tone-purple { border-left-color: #7c3aed; }
        .stat { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.1; }
        .stat-label { font-size: 0.76rem; color: var(--muted); margin-top: 0.15rem; font-weight: 600; }

        .feature { display: flex; gap: 0.55rem; align-items: flex-start; }
        .feature-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--blood-soft);
            color: var(--blood);
            border: 1px solid #f0b4bc;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 0.82rem;
            flex-shrink: 0;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.75rem 0.85rem;
            transition: border-color 0.12s, background 0.12s, box-shadow 0.12s;
        }
        .quick-link:hover {
            border-color: #c45a6e;
            background: #fff5f6;
            box-shadow: 0 4px 12px rgba(179, 18, 45, 0.12);
        }
        .quick-link strong { display: block; font-size: 0.88rem; }
        .quick-link span { display: block; color: var(--muted); font-size: 0.76rem; }

        .action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-bottom: 0.85rem;
        }
        .action-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.75rem;
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            box-shadow: var(--shadow);
        }
        .action-chip:hover {
            border-color: #c45a6e;
            background: #fff5f6;
            color: var(--blood);
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 12px;
            border: 1.5px solid var(--line);
            background: var(--card);
            box-shadow: var(--shadow);
        }
        table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
        th, td { text-align: left; padding: 0.55rem 0.7rem; border-bottom: 1px solid var(--line); }
        th {
            color: var(--muted);
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            background: #f5e6e9;
            font-weight: 700;
        }
        tbody tr:hover td { background: #faf0f2; }
        tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-block;
            padding: 0.12rem 0.4rem;
            border-radius: 999px;
            background: var(--blood-soft);
            color: var(--blood);
            font-size: 0.72rem;
            font-weight: 700;
        }
        .status {
            display: inline-block;
            padding: 0.12rem 0.4rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: capitalize;
        }
        .status-pending { background: var(--warn-soft); color: var(--warn); }
        .status-approved, .status-active, .status-resolved, .status-fulfilled { background: var(--ok-soft); color: var(--ok); }
        .status-rejected, .status-closed { background: #fef2f2; color: #9f1239; }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        .filter-bar .field { margin-bottom: 0; min-width: 8rem; }

        .empty { text-align: center; padding: 1.25rem 1rem; }
        .empty-icon { font-size: 1.4rem; margin-bottom: 0.35rem; }
        .empty h3 { margin: 0 0 0.25rem; font-size: 0.98rem; }
        .empty p { color: var(--muted); margin: 0 0 0.75rem; font-size: 0.84rem; }

        .form-page { max-width: 26rem; margin: 0 auto; }
        .form-page .section-title, .form-page .section-sub { text-align: center; }
        .form-card {
            margin-top: 0.5rem;
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 12px;
            padding: 1rem 1.05rem;
            box-shadow: var(--shadow);
        }
        .field { margin-bottom: 0.7rem; }
        label { display: block; font-weight: 700; font-size: 0.8rem; margin-bottom: 0.25rem; }
        .hint { font-size: 0.75rem; color: var(--muted); margin-top: 0.15rem; }
        input, select, textarea {
            width: 100%;
            padding: 0.5rem 0.65rem;
            border-radius: 8px;
            border: 1.5px solid var(--line);
            background: #fff;
            font-family: inherit;
            font-size: 0.88rem;
            color: var(--ink);
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(179, 18, 45, 0.14);
        }
        textarea { resize: vertical; min-height: 80px; }
        .form-actions { margin-top: 0.9rem; display: flex; gap: 0.4rem; flex-wrap: wrap; }

        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0;
            border-bottom: 1px solid var(--line);
            font-size: 0.84rem;
        }
        .list-item:last-child { border-bottom: none; }
        .list-item .name { font-weight: 700; }

        .panel {
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 12px;
            padding: 0.85rem 0.95rem;
            box-shadow: var(--shadow);
        }
        .panel h3 {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--muted);
            margin: 0 0 0.5rem;
            font-weight: 700;
        }

        .scroll-hint { display: none; font-size: 0.75rem; color: var(--muted); margin-bottom: 0.4rem; }
        @media (max-width: 640px) {
            .scroll-hint { display: block; }
            .topbar-inner { flex-direction: column; align-items: flex-start; }
        }

        footer {
            max-width: 1040px;
            margin: 0 auto;
            padding: 0 1rem 1.1rem;
            color: var(--muted);
            font-size: 0.75rem;
            width: 100%;
        }
        code {
            font-size: 0.8em;
            background: #e8d0d5;
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
                {{-- Requests: admin only --}}
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('blood.requests') }}" class="{{ request()->routeIs('blood.requests*') ? 'active' : '' }}">Requests</a></li>
                @endif
            @endauth
            <li><a href="{{ route('blood.contact') }}" class="{{ request()->routeIs('blood.contact') ? 'active' : '' }}">Contact</a></li>
            <li><a href="{{ route('blood.pages') }}" class="{{ request()->routeIs('blood.pages*') ? 'active' : '' }}">Pages</a></li>
            @auth
                @if(auth()->user()->isAdmin())
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

<footer>BloodLink</footer>
</body>
</html>
