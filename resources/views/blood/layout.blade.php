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
            --bg: #f1f5f9;
            --card: #ffffff;
            --line: #e2e8f0;
            --primary: #0f766e;
            --primary-dark: #0d5c56;
            --primary-soft: #ccfbf1;
            --accent: #be123c;
            --accent-soft: #ffe4e6;
            --ok: #15803d;
            --ok-soft: #ecfdf5;
            --radius: 1rem;
            --font: "Outfit", system-ui, sans-serif;
            --display: "Fraunces", Georgia, serif;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: var(--font);
            background: var(--bg);
            color: var(--ink);
            line-height: 1.55;
            min-height: 100vh;
        }
        a { color: inherit; }

        .topbar {
            background: #0f172a;
            color: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 40;
            border-bottom: 1px solid rgba(148, 163, 184, 0.15);
        }
        .topbar-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0.9rem 1.25rem;
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
            letter-spacing: -0.02em;
            color: #f8fafc;
        }
        .brand-mark {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(20, 184, 166, 0.2);
            display: grid;
            place-items: center;
            font-size: 1rem;
        }
        .nav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .nav a {
            text-decoration: none;
            color: #cbd5e1;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            font-size: 0.92rem;
            font-weight: 500;
        }
        .nav a:hover,
        .nav a.active {
            background: rgba(148, 163, 184, 0.15);
            color: #fff;
        }
        .nav .btn-admin {
            background: var(--primary);
            color: #fff !important;
            font-weight: 600;
        }
        .nav .btn-admin:hover {
            background: var(--primary-dark);
        }

        .wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 1.75rem 1.25rem 3.5rem;
        }

        .alert {
            background: var(--ok-soft);
            color: var(--ok);
            border: 1px solid #bbf7d0;
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.25rem;
        }
        .alert-error {
            background: #fef2f2;
            color: #9f1239;
            border-color: #fecdd3;
        }

        .hero {
            background: linear-gradient(145deg, #0f766e 0%, #134e4a 55%, #1e293b 120%);
            color: #f8fafc;
            border-radius: 1.35rem;
            padding: 2.5rem 2rem;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        .hero::after {
            content: "";
            position: absolute;
            right: -40px;
            bottom: -40px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }
        .hero-kicker {
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 0.75rem;
            font-weight: 600;
            opacity: 0.85;
            color: #99f6e4;
            margin-bottom: 0.6rem;
        }
        .hero h1 {
            font-family: var(--display);
            font-size: clamp(2rem, 5vw, 3.1rem);
            line-height: 1.1;
            margin: 0 0 0.85rem;
            max-width: 14ch;
            color: #fff;
        }
        .hero p {
            max-width: 36rem;
            opacity: 0.9;
            margin: 0 0 1.5rem;
            color: #e2e8f0;
        }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            position: relative;
            z-index: 1;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.7rem 1.2rem;
            border-radius: 999px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 0.95rem;
        }
        .btn-light {
            background: #fff;
            color: var(--primary-dark);
        }
        .btn-light:hover {
            background: #f0fdfa;
        }
        .btn-outline {
            background: transparent;
            color: #fff;
            box-shadow: inset 0 0 0 1.5px rgba(255, 255, 255, 0.55);
        }
        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .btn-primary {
            background: var(--primary);
            color: #fff;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        .btn-ghost {
            background: #fff;
            color: var(--ink);
            box-shadow: inset 0 0 0 1px var(--line);
        }
        .btn-ghost:hover {
            background: #f8fafc;
        }

        .section-title {
            font-family: var(--display);
            font-size: 1.65rem;
            margin: 2.25rem 0 0.35rem;
            color: var(--ink);
        }
        .section-sub {
            color: var(--muted);
            margin: 0 0 1.25rem;
        }

        .grid-3 {
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr;
        }
        .grid-2 {
            display: grid;
            gap: 1.25rem;
        }
        @media (min-width: 720px) {
            .grid-3 { grid-template-columns: repeat(3, 1fr); }
            .grid-2 { grid-template-columns: 1.1fr 0.9fr; }
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 1.25rem 1.3rem;
            box-shadow: var(--shadow);
        }
        .card h3 {
            margin: 0 0 0.4rem;
            font-size: 1.05rem;
            color: var(--ink);
        }
        .card p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .stat {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.03em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.92rem;
        }
        th, td {
            text-align: left;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid var(--line);
            color: var(--ink);
        }
        th {
            color: var(--muted);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .badge {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            background: var(--accent-soft);
            color: #9f1239;
            font-size: 0.78rem;
            font-weight: 600;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.88rem;
            margin: 0.85rem 0 0.35rem;
            color: var(--ink);
        }
        input, select, textarea {
            width: 100%;
            padding: 0.65rem 0.75rem;
            border-radius: 0.65rem;
            border: 1px solid var(--line);
            background: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--ink);
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.18);
        }

        .form-actions {
            margin-top: 1.25rem;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .errors {
            color: #9f1239;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        footer {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.25rem 2rem;
            color: var(--muted);
            font-size: 0.85rem;
        }

        code {
            font-size: 0.88em;
            background: #e2e8f0;
            color: var(--ink);
            padding: 0.1em 0.35em;
            border-radius: 0.3em;
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ route('blood.home') }}">
                <span class="brand-mark">🩸</span>
                <span>BloodLink</span>
            </a>
            <ul class="nav">
                <li><a href="{{ route('blood.home') }}" class="{{ request()->routeIs('blood.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('blood.donors') }}" class="{{ request()->routeIs('blood.donors*') ? 'active' : '' }}">Donors</a></li>
                <li><a href="{{ route('blood.requests') }}" class="{{ request()->routeIs('blood.requests*') ? 'active' : '' }}">Blood Requests</a></li>
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
        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0;padding-left:1.1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <footer>BloodLink · connected to tblblooddonors, tblrequirer, tblcontactusquery, tblpages, tbladmin</footer>
</body>
</html>
