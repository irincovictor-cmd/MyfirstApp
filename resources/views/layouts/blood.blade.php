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
            --bg: #f5f0ee;
            --card: #ffffff;
            --line: #e4dcd7;
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
            --shadow: 0 1px 3px rgba(28, 25, 23, 0.08);
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
            color: #fafaf9;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .topbar-inner {
            max-width: 1040px;
            margin: 0 auto;
            padding: 0.55rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 700;
            font-size: 1rem;
            color: #fafaf9;
        }
        .brand-mark {
            width: 26px;
            height: 26px;
            border-radius: 7px;
            background: var(--blood);
            display: grid;
            place-items: center;
            font-size: 0.8rem;
        }
        .nav {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 0.1rem;
            align-items: center;
        }
        .nav a, .nav button.linkish {
            display: inline-block;
            color: #a8a29e;
            padding: 0.3rem 0.5rem;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 500;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }
        .nav a:hover, .nav button.linkish:hover { color: #fafaf9; background: rgba(255,255,255,0.06); }
        .nav a.active { color: #fecaca; background: rgba(185, 28, 28, 0.28); }
        .nav .btn-admin {
            background: var(--blood) !important;
            color: #fff !important;
            font-weight: 600;
            padding: 0.3rem 0.65rem !important;
        }
        .nav .who { color: #d6d3d1; font-size: 0.75rem; padding: 0.2rem 0.35rem; }

        .wrap {
            max-width: 1040px;
            margin: 0 auto;
            padding: 1rem 1rem 1.75rem;
            width: 100%;
            flex: 1;
        }

        .alert {
            background: var(--ok-soft);
            color: var(--ok);
            border: 1px solid #bbf7d0;
            padding: 0.55rem 0.85rem;
            border-radius: 8px;
            margin-bottom: 0.85rem;
            font-size: 0.86rem;
            font-weight: 500;
        }
        .alert-error { background: #fef2f2; color: #9f1239; border-color: #fecdd3; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            padding: 0.4rem 0.75rem;
            border-radius: 7px;
            font-weight: 600;
            font-size: 0.82rem;
            line-height: 1.2;
            border: none;
            cursor: pointer;
            font-family: inherit;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary { background: var(--blood); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-light { background: #fff; color: var(--ink); }
        .btn-outline {
            background: transparent;
            color: #fff;
            box-shadow: inset 0 0 0 1.5px rgba(255,255,255,0.5);
        }
        .btn-ghost {
            background: #fff;
            color: var(--ink);
            box-shadow: inset 0 0 0 1px var(--line);
        }

        .hero {
            background: linear-gradient(135deg, #1c1917 0%, #3f1a1a 45%, #b91c1c 100%);
            color: #fafaf9;
            border-radius: 12px;
            padding: 1.25rem 1.2rem;
        }
        .hero-kicker {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #fecaca;
            margin-bottom: 0.35rem;
        }
        .hero h1 {
            font-size: clamp(1.35rem, 3vw, 1.75rem);
            font-weight: 700;
            margin: 0 0 0.35rem;
            color: #fff;
        }
        .hero p { max-width: 32rem; color: #e7e5e4; font-size: 0.9rem; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-top: 0.85rem; }

        .section-title { font-size: 1.05rem; font-weight: 700; margin: 0 0 0.15rem; }
        .section-sub { color: var(--muted); font-size: 0.82rem; margin: 0 0 0.65rem; }
        .head-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 0.75rem;
        }
        .head-row .section-sub { margin-bottom: 0; }

        .grid-3, .grid-2, .grid-5 { display: grid; gap: 0.55rem; }
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
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 0.75rem 0.85rem;
            box-shadow: var(--shadow);
        }
        .card h3 { font-size: 0.9rem; margin: 0 0 0.2rem; }
        .card p { color: var(--muted); font-size: 0.82rem; }

        /* Stat tiles with color tint — less “dead white” */
        .stat-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 0.7rem 0.8rem;
            box-shadow: var(--shadow);
            border-left: 3px solid var(--blood);
        }
        .stat-card.tone-ok { border-left-color: #16a34a; }
        .stat-card.tone-warn { border-left-color: #ca8a04; }
        .stat-card.tone-blue { border-left-color: #2563eb; }
        .stat-card.tone-purple { border-left-color: #7c3aed; }
        .stat { font-size: 1.45rem; font-weight: 700; letter-spacing: -0.02em; line-height: 1.1; }
        .stat-label { font-size: 0.75rem; color: var(--muted); margin-top: 0.15rem; font-weight: 500; }

        .feature { display: flex; gap: 0.55rem; align-items: flex-start; }
        .feature-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--blood-soft);
            color: var(--blood);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.6rem 0.7rem;
            transition: border-color 0.12s, background 0.12s;
        }
        .quick-link:hover {
            border-color: #f0b4bc;
            background: #fffafa;
        }
        .quick-link strong { display: block; font-size: 0.86rem; }
        .quick-link span { display: block; color: var(--muted); font-size: 0.75rem; }

        /* Action chip row — denser than big empty cards */
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
            padding: 0.45rem 0.7rem;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            box-shadow: var(--shadow);
        }
        .action-chip:hover {
            border-color: #f0b4bc;
            background: #fffafa;
            color: var(--blood);
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--card);
        }
        table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
        th, td { text-align: left; padding: 0.55rem 0.7rem; border-bottom: 1px solid var(--line); }
        th {
            color: var(--muted);
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            background: #f0ebe8;
            font-weight: 600;
        }
        tbody tr:hover td { background: #faf7f5; }
        tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-block;
            padding: 0.12rem 0.4rem;
            border-radius: 999px;
            background: var(--blood-soft);
            color: var(--blood);
            font-size: 0.72rem;
            font-weight: 600;
        }
        .status {
            display: inline-block;
            padding: 0.12rem 0.4rem;
            border-radius: 999px;
            font-size: 0.7rem;
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
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 1rem 1.05rem;
            box-shadow: var(--shadow);
        }
        .field { margin-bottom: 0.7rem; }
        label { display: block; font-weight: 600; font-size: 0.8rem; margin-bottom: 0.25rem; }
        .hint { font-size: 0.75rem; color: var(--muted); margin-top: 0.15rem; }
        input, select, textarea {
            width: 100%;
            padding: 0.5rem 0.65rem;
            border-radius: 7px;
            border: 1px solid var(--line);
            background: #fff;
            font-family: inherit;
            font-size: 0.88rem;
            color: var(--ink);
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.12);
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
        .list-item .name { font-weight: 600; }

        .panel {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 0.75rem 0.85rem;
            box-shadow: var(--shadow);
        }
        .panel h3 {
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--muted);
            margin: 0 0 0.5rem;
            font-weight: 600;
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

<footer>BloodLink</footer>
</body>
</html>
