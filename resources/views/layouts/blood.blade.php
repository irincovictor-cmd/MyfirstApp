<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#b91c1c">
    <title>@yield('title', 'BloodLink') — Blood Donation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <style>
        :root{
            --ink:#17202a; --muted:#667085; --bg:#f7f8fa; --card:#fff;
            --line:#e6e8ec; --blood:#c62828; --blood-dark:#9f1f1f;
            --blood-soft:#fff1f1; --rose:#ffe4e4; --nav:#151922;
            --ok:#15803d; --ok-soft:#ecfdf5; --warn:#a16207; --warn-soft:#fef9c3;
            --radius:16px; --font:"DM Sans",system-ui,sans-serif; --display:"Fraunces",Georgia,serif;
            --shadow:0 8px 24px rgba(23,32,42,.06); --shadow-lg:0 18px 50px rgba(23,32,42,.1);
        }
        *{box-sizing:border-box}body{margin:0;font-family:var(--font);background:var(--bg);color:var(--ink);line-height:1.55;min-height:100vh;display:flex;flex-direction:column}a{color:inherit}
        .topbar{background:var(--nav);color:#fff;position:sticky;top:0;z-index:50;box-shadow:0 4px 18px rgba(0,0,0,.12)}
        .topbar-inner{max-width:1160px;margin:0 auto;padding:.85rem 1.25rem;display:flex;align-items:center;gap:1rem}
        .brand{display:flex;align-items:center;gap:.7rem;text-decoration:none;font-weight:700;letter-spacing:-.025em;font-size:1.05rem;white-space:nowrap}
        .brand-mark{width:36px;height:36px;border-radius:12px;background:linear-gradient(145deg,#ef4444,#b91c1c);display:grid;place-items:center;box-shadow:0 6px 16px rgba(185,28,28,.35)}
        .nav{list-style:none;margin:0 0 0 auto;padding:0;display:flex;align-items:center;gap:.2rem}
        .nav a{display:block;text-decoration:none;color:#aeb5c2;padding:.55rem .75rem;border-radius:10px;font-size:.86rem;font-weight:600;transition:.18s}
        .nav a:hover{color:#fff;background:rgba(255,255,255,.07)}
        .nav a.active{color:#fff;background:rgba(239,68,68,.16)}
        .nav .btn-admin{background:var(--blood);color:#fff!important;margin-left:.35rem;padding:.58rem .9rem}
        .nav .btn-admin:hover{background:#df3030}
        .nav-toggle{display:none;margin-left:auto;background:transparent;border:1px solid #343a46;color:#fff;border-radius:10px;padding:.5rem .65rem;cursor:pointer}
        .wrap{max-width:1160px;width:100%;margin:0 auto;padding:2rem 1.25rem 4rem;flex:1}
        .alert{background:var(--ok-soft);color:var(--ok);border:1px solid #bbf7d0;padding:.9rem 1.1rem;border-radius:12px;margin-bottom:1.25rem;font-weight:500}
        .alert-error{background:#fef2f2;color:#9f1239;border-color:#fecdd3}
        .hero{position:relative;overflow:hidden;border-radius:26px;padding:3.4rem 3rem;background:linear-gradient(135deg,#151922 0%,#3f1219 48%,#c62828 100%);color:#fff;box-shadow:var(--shadow-lg)}
        .hero::before{content:"";position:absolute;width:420px;height:420px;border-radius:50%;background:rgba(255,255,255,.05);top:-140px;right:-100px}
        .hero::after{content:"";position:absolute;width:260px;height:260px;border:1px solid rgba(255,255,255,.08);border-radius:50%;right:-75px;bottom:-100px}
        .hero-content{position:relative;z-index:1;max-width:650px}
        .hero-kicker{display:inline-flex;align-items:center;gap:.45rem;color:#ffb4b4;text-transform:uppercase;letter-spacing:.13em;font-size:.7rem;font-weight:700;margin-bottom:.85rem}
        .hero h1{font-family:var(--display);font-size:clamp(2.2rem,6vw,4rem);line-height:1.03;letter-spacing:-.045em;margin:0 0 1rem;max-width:12ch}
        .hero p{color:#e2e5ea;max-width:610px;margin:0;font-size:1rem}
        .hero-actions{display:flex;flex-wrap:wrap;gap:.65rem;margin-top:1.7rem}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:.4rem;padding:.78rem 1.25rem;border-radius:999px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;font-size:.92rem;transition:.15s}
        .btn-light{background:#fff;color:var(--ink);box-shadow:0 8px 20px rgba(0,0,0,.12)}
        .btn-light:hover{transform:translateY(-1px)}
        .btn-outline{background:transparent;color:#fff;box-shadow:inset 0 0 0 1.5px rgba(255,255,255,.45)}
        .btn-outline:hover{background:rgba(255,255,255,.08)}
        .btn-primary{background:var(--blood);color:#fff;box-shadow:0 8px 22px rgba(198,40,40,.3)}
        .btn-primary:hover{background:var(--blood-dark);transform:translateY(-1px)}
        .btn-ghost{background:#fff;color:var(--ink);box-shadow:inset 0 0 0 1px var(--line)}
        .btn-ghost:hover{background:#f3f4f6}
        .section-title{font-family:var(--display);font-size:1.55rem;margin:0 0 .35rem;letter-spacing:-.02em}
        .section-sub{color:var(--muted);margin:0 0 1.25rem;font-size:.95rem}
        .eyebrow{display:inline-block;color:var(--blood);font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;margin-bottom:.55rem}
        .head-row{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.35rem}
        .head-row .section-title{margin-bottom:.2rem}.head-row .section-sub{margin-bottom:0}
        .grid-3,.grid-2{display:grid;gap:1rem}.grid-3{grid-template-columns:1fr}.grid-2{grid-template-columns:1fr}
        @media(min-width:700px){.grid-3{grid-template-columns:repeat(3,1fr)}.grid-2{grid-template-columns:1fr 1fr}}
        .card{background:var(--card);border:1px solid var(--line);border-radius:var(--radius);padding:1.25rem 1.3rem;box-shadow:var(--shadow)}
        .card h3{margin:0 0 .35rem;font-size:1.02rem}.card p{margin:0;color:var(--muted);font-size:.92rem}
        .stats{display:grid;gap:1rem;grid-template-columns:1fr;margin-top:1.5rem}
        @media(min-width:700px){.stats{grid-template-columns:repeat(3,1fr)}}
        .stat{font-size:2rem;font-weight:700;letter-spacing:-.03em;line-height:1.15}.stat-label{font-size:.85rem;color:var(--muted);font-weight:500;margin-top:.2rem}
        .stat-card{text-align:left}
        .spacer-top{margin-top:2rem}
        .blood-types{display:grid;grid-template-columns:repeat(2,1fr);gap:.75rem}
        @media(min-width:640px){.blood-types{grid-template-columns:repeat(4,1fr)}}
        .blood-type{background:#fff;border:1px solid var(--line);border-radius:14px;padding:1rem;text-align:center;font-weight:700;color:var(--blood);box-shadow:var(--shadow)}
        .blood-type small{display:block;color:var(--muted);font-weight:500;margin-top:.25rem;font-size:.75rem}
        .feature{display:flex;gap:1rem;align-items:flex-start}
        .feature-icon{width:42px;height:42px;border-radius:12px;background:var(--blood-soft);color:var(--blood);display:grid;place-items:center;font-weight:700;flex-shrink:0}
        .feature-icon.teal{background:#eef2ff;color:#4338ca}
        .table-wrap{overflow-x:auto;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:var(--shadow)}
        table{width:100%;border-collapse:collapse;font-size:.9rem}
        th,td{text-align:left;padding:.85rem 1rem;border-bottom:1px solid var(--line)}
        th{color:var(--muted);font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;font-weight:600;background:#f8fafc}
        tbody tr:last-child td{border-bottom:none}tbody tr:hover td{background:#fafafa}
        .badge{display:inline-block;padding:.22rem .6rem;border-radius:999px;background:var(--blood-soft);color:var(--blood);font-size:.78rem;font-weight:600}
        .status{display:inline-block;padding:.2rem .55rem;border-radius:999px;font-size:.75rem;font-weight:600;text-transform:capitalize}
        .status-pending{background:var(--warn-soft);color:var(--warn)}
        .status-approved,.status-active,.status-resolved{background:var(--ok-soft);color:var(--ok)}
        .status-rejected,.status-closed{background:#fef2f2;color:#9f1239}
        .filter-bar{display:flex;flex-wrap:wrap;align-items:flex-end;gap:.65rem;padding:.8rem;background:#fff;border:1px solid var(--line);border-radius:14px;margin-bottom:1rem;box-shadow:var(--shadow)}
        .filter-bar .field{margin-bottom:0;min-width:10rem}.filter-bar .field label{margin-bottom:.3rem}
        .pagination{display:flex;align-items:center;justify-content:center;gap:1rem;margin-top:1.25rem;flex-wrap:wrap}
        .pagination-info{color:var(--muted);font-size:.85rem}.btn-disabled{opacity:.45;cursor:default;pointer-events:none}
        .scroll-hint{display:none;font-size:.78rem;color:var(--muted);margin:-.5rem 0 .6rem}
        @media(max-width:640px){.scroll-hint{display:block}}
        .empty{text-align:center;padding:2.5rem 1.5rem;color:var(--muted)}.empty-icon{font-size:2.25rem;margin-bottom:.75rem;opacity:.7}
        .empty h3{margin:0 0 .4rem;color:var(--ink);font-size:1.1rem}.empty p{margin:0 0 1.25rem;font-size:.95rem}
        .form-page{max-width:32rem;margin:0 auto}.form-page .section-title,.form-page .section-sub{text-align:center}
        .form-card{margin-top:.75rem;background:var(--card);border:1px solid var(--line);border-radius:1.15rem;padding:1.65rem 1.6rem 1.75rem;box-shadow:var(--shadow-lg)}
        .field{margin-bottom:1rem}.field:last-of-type{margin-bottom:0}
        label{display:block;font-weight:600;font-size:.85rem;margin-bottom:.35rem}
        .hint{font-size:.8rem;color:var(--muted);font-weight:400;margin-top:.25rem}
        .row-2{display:grid;gap:.85rem;grid-template-columns:1fr}@media(min-width:480px){.row-2{grid-template-columns:1fr 1fr}}
        input,select,textarea{width:100%;padding:.72rem .9rem;border-radius:.7rem;border:1px solid var(--line);background:#fff;font-family:inherit;font-size:.95rem;color:var(--ink)}
        input:focus,select:focus,textarea:focus{outline:none;border-color:var(--blood);box-shadow:0 0 0 3px rgba(198,40,40,.15)}
        textarea{resize:vertical;min-height:110px}
        .form-actions{display:flex;gap:.55rem;flex-wrap:wrap;margin-top:1.35rem;padding-top:1.15rem;border-top:1px solid var(--line)}
        .form-actions .btn{min-width:7rem}
        .list-item{display:flex;justify-content:space-between;align-items:center;gap:.75rem;padding:.65rem 0;border-bottom:1px solid var(--line);font-size:.92rem}
        .list-item:last-child{border-bottom:none}.list-item .name{font-weight:600}
        .quick-link{display:flex;align-items:center;gap:.85rem;padding:1rem 1.15rem;text-decoration:none;transition:.15s}
        .quick-link:hover{border-color:#f0b4bc;box-shadow:0 6px 20px rgba(198,40,40,.12);transform:translateY(-1px)}
        .quick-link strong{display:block;font-size:.98rem}.quick-link span{display:block;color:var(--muted);font-size:.85rem;margin-top:.15rem}
        footer{max-width:1160px;margin:0 auto;padding:0 1.25rem 2rem;color:var(--muted);font-size:.82rem;width:100%}
        code{font-size:.85em;background:#eef0f3;padding:.1em .35em;border-radius:.3em}
        @media(max-width:700px){
            .nav-toggle{display:block}
            .topbar-inner{flex-wrap:wrap}
            .nav{display:none;width:100%;margin:0;padding-top:.5rem;border-top:1px solid #2b303a}
            .nav.open{display:grid;grid-template-columns:repeat(2,1fr)}
            .nav a{padding:.7rem .8rem}.nav .btn-admin{margin-left:0}
            .hero{padding:2.5rem 2rem}.blood-types{grid-template-columns:repeat(4,1fr)}
        }
        @media(max-width:480px){
            .wrap{padding:1.25rem .85rem 3rem}
            .hero{padding:2rem 1.35rem;border-radius:20px}
            .hero h1{font-size:2.35rem}
            .blood-types{grid-template-columns:repeat(2,1fr)}
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
        <button class="nav-toggle" type="button" aria-label="Toggle navigation" onclick="document.querySelector('.nav').classList.toggle('open')">☰</button>
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

<main class="wrap">
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if(isset($errors) && $errors->any())
        <div class="alert alert-error">
            <div><ul style="margin:0;padding-left:1.1rem;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul></div>
        </div>
    @endif
    @yield('content')
</main>

<footer>BloodLink · Blood donation management system</footer>
<script>
document.querySelectorAll('.nav a').forEach(function(link){
    link.addEventListener('click',function(){document.querySelector('.nav').classList.remove('open');});
});
</script>
</body>
</html>
