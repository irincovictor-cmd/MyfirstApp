@extends('layouts.blood')
@section('title', 'Home')
@section('content')

<div class="hero">
    <div class="hero-kicker">Blood donation system</div>
    <h1>Give blood. Save lives.</h1>
    <p>
        Register as a donor or submit a blood request.
        Personal records stay private — only staff can view the full lists.
    </p>
    <div class="hero-actions">
        @auth
            <a class="btn btn-amber" href="{{ route('blood.donor.create') }}">🩸 Donate</a>
            <a class="btn btn-outline" href="{{ route('blood.request.create') }}">📋 Request</a>
        @else
            <a class="btn btn-amber" href="{{ route('blood.register') }}">Create account</a>
            <a class="btn btn-outline" href="{{ route('blood.login') }}">Login</a>
        @endauth
    </div>
</div>

<div class="panel" style="margin-top:1rem;">
    <h3 style="text-transform:none;letter-spacing:0;font-size:1rem;color:var(--ink);">What is BloodLink?</h3>
    <p style="margin:0.4rem 0 0;color:var(--muted);font-size:0.9rem;line-height:1.55;">
        Users can submit donor or blood-request forms. They cannot see other people's data.
        Admins review submissions, approve or reject them, and manage contact messages.
    </p>
</div>

<div class="grid-3" style="margin-top:0.85rem;">
    <div class="stat-card">
        <div class="stat">{{ $donorCount ?? 0 }}</div>
        <div class="stat-label">🩸 Donors</div>
    </div>
    <div class="stat-card tone-warn">
        <div class="stat">{{ $requestCount ?? 0 }}</div>
        <div class="stat-label">📋 Requests</div>
    </div>
    <div class="stat-card tone-ok">
        <div class="stat">{{ $pageCount ?? 0 }}</div>
        <div class="stat-label">📄 Info pages</div>
    </div>
</div>

<h2 class="section-title" style="margin-top:1.35rem;">How it works</h2>
<p class="section-sub">Three steps from signup to review.</p>
<div class="grid-3">
    <div class="card feature">
        <div class="feature-icon">1</div>
        <div>
            <strong style="display:block;font-size:0.92rem;">Create an account</strong>
            <span style="color:var(--muted);font-size:0.82rem;">Register, then log in as User.</span>
        </div>
    </div>
    <div class="card feature">
        <div class="feature-icon">2</div>
        <div>
            <strong style="display:block;font-size:0.92rem;">Donate or request</strong>
            <span style="color:var(--muted);font-size:0.82rem;">Submit your own form only — no public lists.</span>
        </div>
    </div>
    <div class="card feature">
        <div class="feature-icon">3</div>
        <div>
            <strong style="display:block;font-size:0.92rem;">Admin reviews</strong>
            <span style="color:var(--muted);font-size:0.82rem;">Staff see all records and update status.</span>
        </div>
    </div>
</div>

<h2 class="section-title" style="margin-top:1.35rem;">Who is it for?</h2>
<div class="grid-2">
    <div class="card feature">
        <div class="feature-icon">👤</div>
        <div>
            <strong style="display:block;font-size:0.92rem;">Users</strong>
            <span style="color:var(--muted);font-size:0.82rem;">
                Submit a donor form or blood request. Cannot browse other people's info.
            </span>
        </div>
    </div>
    <div class="card feature">
        <div class="feature-icon">⚙️</div>
        <div>
            <strong style="display:block;font-size:0.92rem;">Admins</strong>
            <span style="color:var(--muted);font-size:0.82rem;">
                View full donor and request lists, approve or reject, and read messages.
            </span>
        </div>
    </div>
</div>

@guest
<div class="panel" style="margin-top:1rem;border-left:3px solid var(--blood);">
    <h3 style="text-transform:none;letter-spacing:0;font-size:0.95rem;color:var(--ink);">New here?</h3>
    <p style="margin:0.35rem 0 0.65rem;color:var(--muted);font-size:0.88rem;">
        You can read info pages and send a message without an account.
        To donate or request blood, create an account first.
    </p>
    <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
        <a class="btn btn-primary" href="{{ route('blood.register') }}">Create account</a>
        <a class="btn btn-ghost" href="{{ route('blood.pages') }}">📄 Info pages</a>
        <a class="btn btn-ghost" href="{{ route('blood.contact') }}">✉️ Contact</a>
    </div>
</div>
@endguest

<h2 class="section-title" style="margin-top:1.35rem;">Quick links</h2>
<p class="section-sub">Jump to a page.</p>
<div class="grid-2">
    @auth
        <a class="card quick-link" href="{{ route('blood.donor.create') }}">
            <div class="feature-icon">🩸</div>
            <div>
                <strong>Donate</strong>
                <span>Submit donor form</span>
            </div>
        </a>
        <a class="card quick-link" href="{{ route('blood.request.create') }}">
            <div class="feature-icon">📋</div>
            <div>
                <strong>Request</strong>
                <span>Submit blood request</span>
            </div>
        </a>
        @if(auth()->user()->isAdmin())
            <a class="card quick-link" href="{{ route('blood.donors') }}">
                <div class="feature-icon">👀</div>
                <div>
                    <strong>All donors</strong>
                    <span>Admin list</span>
                </div>
            </a>
            <a class="card quick-link" href="{{ route('blood.requests') }}">
                <div class="feature-icon">📋</div>
                <div>
                    <strong>All requests</strong>
                    <span>Admin list</span>
                </div>
            </a>
        @endif
    @endauth
    <a class="card quick-link" href="{{ route('blood.contact') }}">
        <div class="feature-icon">✉️</div>
        <div>
            <strong>Contact</strong>
            <span>Send a message</span>
        </div>
    </a>
    <a class="card quick-link" href="{{ route('blood.pages') }}">
        <div class="feature-icon">📄</div>
        <div>
            <strong>Pages</strong>
            <span>Info & FAQs</span>
        </div>
    </a>
</div>

@endsection
