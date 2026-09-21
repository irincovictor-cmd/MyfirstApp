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
            --ink: #1a1214;
            --muted: #6b5a5e;
            --cream: #faf6f3;
            --card: #ffffff;
            --line: #eadfdc;
            --blood: #b91c1c;
            --blood-dark: #7f1d1d;
            --rose: #fecaca;
            --ok: #15803d;
            --radius: 1rem;
            --font: "Outfit", system-ui, sans-serif;
            --display: "Fraunces", Georgia, serif;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: var(--font);
            background: var(--cream);
            color: var(--ink);
            line-height: 1.55;
            min-height: 100vh;
        }
        a { color: inherit; }
        .topbar {
            background: linear-gradient(120deg, var(--blood-dark), var(--blood));
            color: #fff;
            position: sticky; top: 0; z-index: 40;
            box-shadow: 0 8px 24px rgba(127, 29, 29, 0.25);
        }
        .topbar-inner {
            max-width: 1100px; margin: 0 auto;
            padding: 0.9rem 1.25rem;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        }
        .brand {
            display: flex; align-items: center; gap: 0.55rem;
            font-weight: 700; text-decoration: none; letter-spacing: -0.02em;
        }
        .brand-mark {
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: grid; place-items: center; font-size: 1rem;
        }
        .nav {
            display: flex; flex-wrap: wrap; gap: 0.25rem; align-items: center;
            list-style: none; margin: 0; padding: 0;
        }
        .nav a {
            text-decoration: none; color: rgba(255,255,255,0.88);
            padding: 0.4rem 0.75rem; border-radius: 999px; font-size: 0.92rem; font-weight: 500;
        }
        .nav a:hover, .nav a.active { background: rgba(255,255,255,0.15); color: #fff; }
        .nav .btn-admin {
            background: #fff; color: var(--blood-dark) !important; font-weight: 600;
        }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 1.75rem 1.25rem 3.5rem; }
        .alert {
            background: #ecfdf5; color: var(--ok); border: 1px solid #bbf7d0;
            padding: 0.85rem 1rem; border-radius: 0.75rem; margin-bottom: 1.25rem;
        }
        .alert-error { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
        .hero {
            background: linear-gradient(145deg, #9f1239 0%, #dc2626 45%, #f97316 120%);
            color: #fff; border-radius: 1.35rem; padding: 2.5rem 2rem;
            box-shadow: 0 20px 50px rgba(185, 28, 28, 0.28);
            position: relative; overflow: hidden;
        }
        .hero::after {
            content: ""; position: absolute; right: -40px; bottom: -40px;
            width: 220px; height: 220px; border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }
        .hero-kicker {
            text-transform: uppercase; letter-spacing: 0.14em; font-size: 0.75rem;
            font-weight: 600; opacity: 0.85; margin-bottom: 0.6rem;
        }
        .hero h1 {
            font-family: var(--display); font-size: clamp(2rem, 5vw, 3.1rem);
            line-height: 1.1; margin: 0 0 0.85rem; max-width: 14ch;
        }
        .hero p { max-width: 36rem; opacity: 0.92; margin: 0 0 1.5rem; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 0.65rem; position: relative; z-index: 1; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.7rem 1.2rem; border-radius: 999px; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer; font-family: inherit; font-size: 0.95rem;
        }
        .btn-light { background: #fff; color: var(--blood-dark); }
        .btn-outline {
            background: transparent; color: #fff;
            box-shadow: inset 0 0 0 1.5px rgba(255,255,255,0.65);
        }
        .btn-primary { background: var(--blood); color: #fff; }
        .btn-primary:hover { background: var(--blood-dark); }
        .btn-ghost {
            background: #fff; color: var(--ink);
            box-shadow: inset 0 0 0 1px var(--line);
        }
        .section-title {
            font-family: var(--display); font-size: 1.65rem; margin: 2.25rem 0 0.35rem;
        }
        .section-sub { color: var(--muted); margin: 0 0 1.25rem; }
        .grid-3 {
            display: grid; gap: 1rem;
            grid-template-columns: 1fr;
        }
        @media (min-width: 720px) {
            .grid-3 { grid-template-columns: repeat(3, 1fr); }
            .grid-2 { grid-template-columns: 1.1fr 0.9fr; }
        }
        .grid-2 { display: grid; gap: 1.25rem; }
        .card {
            background: var(--card); border: 1px solid var(--line);
            border-radius: var(--radius); padding: 1.25rem 1.3rem;
        }
        .card h3 { margin: 0 0 0.4rem; font-size: 1.05rem; }
        .card p { margin: 0; color: var(--muted); font-size: 0.95rem; }
        .stat {
            font-size: 1.75rem; font-weight: 700; color: var(--blood);
            letter-spacing: -0.03em;
        }
        table { width: 100%; border-collapse: collapse; font-size: 0.92rem; }
        th, td { text-align: left; padding: 0.75rem 0.5rem; border-bottom: 1px solid var(--line); }
        th { color: var(--muted); font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.04em; }
        .badge {
            display: inline-block; padding: 0.2rem 0.55rem; border-radius: 999px;
            background: #fff1f2; color: var(--blood); font-size: 0.78rem; font-weight: 600;
        }
        label { display: block; font-weight: 600; font-size: 0.88rem; margin: 0.85rem 0 0.35rem; }
        input, select, textarea {
            width: 100%; padding: 0.65rem 0.75rem; border-radius: 0.65rem;
            border: 1px solid var(--line); background: #fff; font-family: inherit; font-size: 0.95rem;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: #f87171; box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.2);
        }
        .form-actions { margin-top: 1.25rem; display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .errors { color: #b91c1c; font-size: 0.85rem; margin-top: 0.25rem; }
        footer {
            max-width: 1100px; margin: 0 auto; padding: 0 1.25rem 2rem;
            color: var(--muted); font-size: 0.85rem;
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
