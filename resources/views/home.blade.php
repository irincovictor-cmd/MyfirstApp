@extends('layouts.blood')

@section('title', 'Home')

@section('content')
<div class="hero">
    <div class="hero-kicker">🩸 Community blood network</div>
    <h1>Give blood. Save lives.</h1>
    <p>Register as a donor or request blood for someone in need. Every registration helps match donors with hospitals and patients faster.</p>
    <div class="hero-actions">
        <a class="btn btn-light" href="{{ route('blood.donor.create') }}">Become a donor</a>
        <a class="btn btn-outline" href="{{ route('blood.request.create') }}">Request blood</a>
    </div>
</div>

{{-- Live stats --}}
<div class="grid-3" style="margin-top:1.5rem;">
    <div class="card">
        <div class="stat">{{ $donorCount ?? 0 }}</div>
        <div class="stat-label">Registered donors</div>
    </div>
    <div class="card">
        <div class="stat">{{ $requestCount ?? 0 }}</div>
        <div class="stat-label">Blood requests</div>
    </div>
    <div class="card">
        <div class="stat">{{ $pageCount ?? 0 }}</div>
        <div class="stat-label">Info pages</div>
    </div>
</div>

{{-- How it works --}}
<h2 class="section-title" style="margin-top:2.25rem;">How it works</h2>
<p class="section-sub">Three simple steps from form to database.</p>
<div class="grid-3">
    <div class="card feature">
        <div class="feature-icon blood">1</div>
        <div>
            <h3>Register</h3>
            <p>Donors and requesters fill out a short form with blood type and contact details.</p>
        </div>
    </div>
    <div class="card feature">
        <div class="feature-icon">2</div>
        <div>
            <h3>We store it</h3>
            <p>Your data is validated and saved securely so staff can find matches quickly.</p>
        </div>
    </div>
    <div class="card feature">
        <div class="feature-icon">3</div>
        <div>
            <h3>Review & match</h3>
            <p>Admins review lists and connect donors with open blood requests.</p>
        </div>
    </div>
</div>

{{-- Quick actions --}}
<h2 class="section-title" style="margin-top:2.25rem;">Quick actions</h2>
<p class="section-sub">Jump to the task you need.</p>
<div class="grid-2">
    <a class="card quick-link" href="{{ route('blood.donors') }}">
        <div class="feature-icon blood">🩸</div>
        <div>
            <strong>Browse donors</strong>
            <span>See who is registered and their blood types</span>
        </div>
    </a>
    <a class="card quick-link" href="{{ route('blood.requests') }}">
        <div class="feature-icon">📋</div>
        <div>
            <strong>View requests</strong>
            <span>Open blood needs from hospitals and patients</span>
        </div>
    </a>
    <a class="card quick-link" href="{{ route('blood.contact') }}">
        <div class="feature-icon">✉️</div>
        <div>
            <strong>Contact us</strong>
            <span>Send a question or message to the team</span>
        </div>
    </a>
    <a class="card quick-link" href="{{ route('blood.admin.dashboard') }}">
        <div class="feature-icon">⚙️</div>
        <div>
            <strong>Admin dashboard</strong>
            <span>Counts, recent activity, and management</span>
        </div>
    </a>
</div>
@endsection
