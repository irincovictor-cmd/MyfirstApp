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
            --ink: #1e293b;
            --muted: #64748b;
            --bg: #f8fafc;
            --card: #ffffff;
            --line: #e2e8f0;
            --primary: #0f766e;
            --primary-dark: #0d5c56;
            --primary-soft: #ccfbf1;
            --blood: #b91c1c;
            --blood-soft: #fff1f2;
            --ok: #15803d;
            --ok-soft: #ecfdf5;
            --warn: #a16207;
            --warn-soft: #fef9c3;
            --radius: 1rem;
            --font: "Outfit", system-ui, sans-serif;
            --display: "Fraunces", Georgia, serif;
            --shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
            --shadow-lg: 0 16px 40px rgba(15, 23, 42, 0.1);
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
            background: #0f172a;
            color: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 40;
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
            color: #f8fafc;
            letter-spacing: -0.02em;
            flex-shrink: 0;
        }
        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #be123c, #b91c1c);
            display: grid;
            place-items: center;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(185, 28, 28, 0.35);
        }
        .nav {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 0.15rem;
            justify-content: flex-end;
        }
        .nav a {
            text-decoration: none;
            color: #94a3b8;
            padding: 0.4rem 0.7rem;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
        }
        .nav a:hover { background: rgba(148, 163, 184, 0.12); color: #f1f5f9; }
        .nav a.active { background: rgba(20, 184, 166, 0.15); color: #5eead4; }
        .nav .btn-admin {
            background: var(--blood);
            color: #fff !important;
            font-weight: 600;
            margin-left: 0.25rem;
        }
        .nav .btn-admin:hover { background: #991b1b; }

        .wrap {
            max-width: 1080px;
            margin: 0 auto;
            padding: 1.75rem 1.25rem 3rem;
            width: 100%;
            flex: 1;
        }

        .alert {
            background: var(--ok-soft);
            color: var(--ok);
            border: 1px solid #bbf7d0;
            padding: 0.9rem 1.1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.25rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }
        .alert::before { content: "✓"; font-weight: 700; }
        .alert-error {
            background: #fef2f2;
            color: #9f1239;
            border-color: #fecdd3;
        }
        .alert-error::before { content: "!"; }

        .hero {
            background: linear-gradient(145deg, #0f172a 0%, #134e4a 70%, #0f766e 100%);
            color: #f8fafc;
            border-radius: 1.25rem;
            padding: 2.75rem 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(185, 28, 28, 0.12);
            top: -80px;
            right: -60px;
        }
        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-size: 0.72rem;
            font-weight: 600;
            color: #fca5a5;
            margin-bottom: 0.75rem;
        }
        .hero h1 {
            font-family: var(--display);
            font-size: clamp(1.9rem, 4.5vw, 2.85rem);
            margin: 0 0 0.75rem;
            line-height: 1.15;
            color: #fff;
            max-width: 16ch;
            position: relative;
        }
        .hero p {
            max-width: 34rem;
            margin: 0;
            color: #cbd5e1;
            font-size: 1.02rem;
            position: relative;
        }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin-top: 1.5rem;
            position: relative;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.7rem 1.2rem;
            border-radius: 999px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 0.92rem;
            transition: transform 0.12s, background 0.15s, box-shadow 0.15s;
        }
        .btn:active { transform: scale(0.98); }
        .btn-light {
            background: #fff;
            color: var(--ink);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .btn-light:hover { background: #f8fafc; }
        .btn-outline {
            background: transparent;
            color: #fff;
            box-shadow: inset 0 0 0 1.5px rgba(255,255,255,0.5);
        }
        .btn-outline:hover { background: rgba(255,255,255,0.08); }
        .btn-primary {
            background: var(--blood);
            color: #fff;
            box-shadow: 0 4px 14px rgba(185, 28, 28, 0.25);
        }
        .btn-primary:hover { background: #991b1b; }
        .btn-teal {
            background: var(--primary);
            color: #fff;
        }
        .btn-teal:hover { background: var(--primary-dark); }
        .btn-ghost {
            background: #fff;
            color: var(--ink);
            box-shadow: inset 0 0 0 1px var(--line);
        }
        .btn-ghost:hover { background: #f8fafc; }

        .section-title {
            font-family: var(--display);
            font-size: 1.5rem;
            margin: 0 0 0.3rem;
            color: var(--ink);
            letter-spacing: -0.02em;
        }
        .section-sub {
            color: var(--muted);
            margin: 0 0 1.25rem;
            font-size: 0.95rem;
        }
        .head-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }
        .head-row .section-title { margin-bottom: 0.2rem; }
        .head-row .section-sub { margin-bottom: 0; }

        .grid-3 {
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr;
        }
        .grid-2 {
            display: grid;
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .grid-3 { grid-template-columns: repeat(3, 1fr); }
            .grid-2 { grid-template-columns: 1fr 1fr; }
        }
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 1.25rem 1.3rem;
            box-shadow: var(--shadow);
        }
        .card h3 {
            margin: 0 0 0.35rem;
            font-size: 1.02rem;
            color: var(--ink);
        }
        .card p {
            margin: 0;
            color: var(--muted);
            font-size: 0.92rem;
        }
        .stat {
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.03em;
            line-height: 1.2;
        }
        .stat-label {
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 500;
            margin-top: 0.15rem;
        }

        .feature {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }
        .feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
        }
        .feature-icon.blood {
            background: var(--blood-soft);
            color: var(--blood);
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--line);
            background: var(--card);
            box-shadow: var(--shadow);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        th, td {
            text-align: left;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--line);
            color: var(--ink);
        }
        th {
            color: var(--muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            background: #f8fafc;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #f8fafc; }

        .badge {
            display: inline-block;
            padding: 0.22rem 0.6rem;
            border-radius: 999px;
            background: var(--blood-soft);
            color: var(--blood);
            font-size: 0.78rem;
            font-weight: 600;
        }
        .status {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-pending { background: var(--warn-soft); color: var(--warn); }
        .status-approved, .status-active, .status-resolved {
            background: var(--ok-soft); color: var(--ok);
        }
        .status-rejected, .status-closed {
            background: #fef2f2; color: #9f1239;
        }
        .status-urgent {
            background: #b91c1c; color: #fff;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        .filter-bar .field { margin-bottom: 0; min-width: 10rem; }
        .filter-bar .field label { margin-bottom: 0.3rem; }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.25rem;
            flex-wrap: wrap;
        }
        .pagination-info {
            color: var(--muted);
            font-size: 0.85rem;
        }
        .btn-disabled {
            opacity: 0.45;
            cursor: default;
            pointer-events: none;
        }

        .scroll-hint {
            display: none;
            font-size: 0.78rem;
            color: var(--muted);
            margin: -0.5rem 0 0.6rem;
        }
        @media (max-width: 640px) {
            .scroll-hint { display: block; }
        }

        .empty {
            text-align: center;
            padding: 2.5rem 1.5rem;
            color: var(--muted);
        }
        .empty-icon {
            font-size: 2.25rem;
            margin-bottom: 0.75rem;
            opacity: 0.7;
        }
        .empty h3 {
            margin: 0 0 0.4rem;
            color: var(--ink);
            font-size: 1.1rem;
        }
        .empty p { margin: 0 0 1.25rem; font-size: 0.95rem; }

        .form-page {
            max-width: 32rem;
            margin: 0 auto;
        }
        .form-page .section-title,
        .form-page .section-sub { text-align: center; }
        .form-card {
            margin-top: 0.75rem;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 1.5rem 1.5rem 1.6rem;
            box-shadow: var(--shadow);
        }
        .field { margin-bottom: 1rem; }
        .field:last-of-type { margin-bottom: 0; }
        label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.35rem;
            color: var(--ink);
        }
        .hint {
            font-size: 0.8rem;
            color: var(--muted);
            font-weight: 400;
            margin-top: 0.25rem;
        }
        .row-2 {
            display: grid;
            gap: 0.85rem;
            grid-template-columns: 1fr;
        }
        @media (min-width: 480px) {
            .row-2 { grid-template-columns: 1fr 1fr; }
        }
        input, select, textarea {
            width: 100%;
            padding: 0.7rem 0.85rem;
            border-radius: 0.65rem;
            border: 1px solid var(--line);
            background: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--ink);
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }
        textarea { resize: vertical; min-height: 110px; }
        .form-actions {
            margin-top: 1.35rem;
            display: flex;
            gap: 0.55rem;
            flex-wrap: wrap;
        }
        .form-actions .btn { min-width: 7rem; }

        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0;
            border-bottom: 1px solid var(--line);
            font-size: 0.92rem;
        }
        .list-item:last-child { border-bottom: none; }
        .list-item .name { font-weight: 600; color: var(--ink); }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 1rem 1.15rem;
            text-decoration: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .quick-link:hover {
            border-color: #99f6e4;
            box-shadow: 0 4px 16px rgba(15, 118, 110, 0.1);
        }
        .quick-link strong {
            display: block;
            color: var(--ink);
            font-size: 0.98rem;
        }
        .quick-link span {
            display: block;
            color: var(--muted);
            font-size: 0.85rem;
            margin-top: 0.15rem;
        }

        footer {
            max-width: 1080px;
            margin: 0 auto;
            padding: 0 1.25rem 2rem;
            color: var(--muted);
            font-size: 0.82rem;
            width: 100%;
        }

        code {
            font-size: 0.85em;
            background: #e2e8f0;
            color: var(--ink);
            padding: 0.1em 0.35em;
            border-radius: 0.3em;
        }

        @media (max-width: 640px) {
            .topbar-inner { flex-direction: column; align-items: flex-start; }
            .nav { width: 100%; }
            .hero { padding: 2rem 1.35rem; }
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
            <li><a href="{{ route('blood.donors') }}" class="{{ request()->routeIs('blood.donors*') ? 'active' : '' }}">Donors</a></li>
            <li><a href="{{ route('blood.requests') }}" class="{{ request()->routeIs('blood.requests*') ? 'active' : '' }}">Requests</a></li>
            <li><a href="{{ route('blood.contact') }}" class="{{ request()->routeIs('blood.contact') ? 'active' : '' }}">Contact</a></li>
            <li><a href="{{ route('blood.pages') }}" class="{{ request()->routeIs('blood.pages*') ? 'active' : '' }}">Pages</a></li>
            <li><a class="btn-admin" href="{{ route('blood.admin.dashboard') }}">Admin</a></li>
        </ul>
    </div>
</header>

<div class="wrap">
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if(isset($errors) && $errors->any())
        <div class="alert alert-error">
            <div>
                <ul style="margin:0;padding-left:1.1rem;">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @yield('content')
</div>

<footer>BloodLink · blood donation management</footer>
</body>
</html>
