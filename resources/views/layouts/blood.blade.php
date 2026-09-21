<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BloodLink') — Blood Donation</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #1a1214; --muted: #6b5a5e; --cream: #faf6f3; --card: #fff;
            --line: #eadfdc; --blood: #b91c1c; --blood-dark: #7f1d1d;
            --ok: #15803d; --radius: 1rem;
            --font: "Outfit", system-ui, sans-serif;
            --display: "Fraunces", Georgia, serif;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: var(--font); background: var(--cream); color: var(--ink); line-height: 1.55; }
        .topbar { background: linear-gradient(120deg, var(--blood-dark), var(--blood)); color: #fff; position: sticky; top: 0; z-index: 40; }
        .topbar-inner { max-width: 1100px; margin: 0 auto; padding: .9rem 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
        .brand { display: flex; align-items: center; gap: .5rem; font-weight: 700; text-decoration: none; color: #fff; }
        .nav { list-style: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap; gap: .25rem; }
        .nav a { text-decoration: none; color: rgba(255,255,255,.9); padding: .4rem .75rem; border-radius: 999px; font-size: .9rem; font-weight: 500; }
        .nav a:hover, .nav a.active { background: rgba(255,255,255,.15); }
        .nav .btn-admin { background: #fff; color: var(--blood-dark) !important; font-weight: 600; }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 1.75rem 1.25rem 3rem; }
        .alert { background: #ecfdf5; color: var(--ok); border: 1px solid #bbf7d0; padding: .85rem 1rem; border-radius: .75rem; margin-bottom: 1.25rem; }
        .alert-error { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
        .hero { background: linear-gradient(145deg, #9f1239, #dc2626 50%, #f97316); color: #fff; border-radius: 1.35rem; padding: 2.4rem 2rem; }
        .hero-kicker { text-transform: uppercase; letter-spacing: .14em; font-size: .75rem; font-weight: 600; opacity: .85; }
        .hero h1 { font-family: var(--display); font-size: clamp(2rem, 5vw, 3rem); margin: .5rem 0 .85rem; line-height: 1.1; }
        .hero p { max-width: 36rem; opacity: .92; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: .65rem; margin-top: 1.25rem; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: .7rem 1.15rem; border-radius: 999px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; font-family: inherit; font-size: .95rem; }
        .btn-light { background: #fff; color: var(--blood-dark); }
        .btn-outline { background: transparent; color: #fff; box-shadow: inset 0 0 0 1.5px rgba(255,255,255,.65); }
        .btn-primary { background: var(--blood); color: #fff; }
        .btn-ghost { background: #fff; color: var(--ink); box-shadow: inset 0 0 0 1px var(--line); }
        .section-title { font-family: var(--display); font-size: 1.65rem; margin: 0 0 .35rem; }
        .section-sub { color: var(--muted); margin: 0 0 1.25rem; }
        .grid-3 { display: grid; gap: 1rem; grid-template-columns: 1fr; }
        @media (min-width: 720px) { .grid-3 { grid-template-columns: repeat(3, 1fr); } .grid-2 { grid-template-columns: 1fr 1fr; } }
        .grid-2 { display: grid; gap: 1.25rem; }
        .card { background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 1.25rem; }
        .stat { font-size: 1.75rem; font-weight: 700; color: var(--blood); }
        table { width: 100%; border-collapse: collapse; font-size: .92rem; }
        th, td { text-align: left; padding: .75rem .5rem; border-bottom: 1px solid var(--line); }
        th { color: var(--muted); font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; }
        .badge { display: inline-block; padding: .2rem .55rem; border-radius: 999px; background: #fff1f2; color: var(--blood); font-size: .78rem; font-weight: 600; }
        label { display: block; font-weight: 600; font-size: .88rem; margin: .85rem 0 .35rem; }
        input, select, textarea { width: 100%; padding: .65rem .75rem; border-radius: .65rem; border: 1px solid var(--line); font-family: inherit; }
        .form-actions { margin-top: 1.25rem; display: flex; gap: .5rem; flex-wrap: wrap; }
        footer { max-width: 1100px; margin: 0 auto; padding: 0 1.25rem 2rem; color: var(--muted); font-size: .85rem; }
        .head-row { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: .5rem; }
    </style>
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="{{ route('blood.home') }}">🩸 BloodLink</a>
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
    @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
    @if(isset($errors) && $errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:1.1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
</div>
<footer>BloodLink · assignment folder structure: admin, blood-donors, blood-request, contact-info, contact-queries, requirers, pages + home.blade.php</footer>
</body>
</html>
