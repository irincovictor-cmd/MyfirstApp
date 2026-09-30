@extends('layouts.blood')
@section('title', 'Home')
@section('content')

<div class="hero">
    <div class="hero-kicker">BloodLink</div>
    <h1>Give blood. Save lives.</h1>
    <p>Register as a donor or request blood.</p>
    <div class="hero-actions">
        @auth
            <a class="btn btn-light" href="{{ route('blood.donor.create') }}">🩸 Donate</a>
            <a class="btn btn-outline" href="{{ route('blood.request.create') }}">📋 Request</a>
        @else
            <a class="btn btn-light" href="{{ route('blood.register') }}">Create account</a>
            <a class="btn btn-outline" href="{{ route('blood.login') }}">Login</a>
        @endauth
    </div>
</div>

<div class="grid-3" style="margin-top:1.25rem;">
    <div class="card">
        <div class="stat">{{ $donorCount ?? 0 }}</div>
        <div class="stat-label">Donors</div>
    </div>
    <div class="card">
        <div class="stat">{{ $requestCount ?? 0 }}</div>
        <div class="stat-label">Requests</div>
    </div>
    <div class="card">
        <div class="stat">{{ $pageCount ?? 0 }}</div>
        <div class="stat-label">Pages</div>
    </div>
</div>

<h2 class="section-title" style="margin-top:1.75rem;">Quick links</h2>
<p class="section-sub">Go where you need.</p>
<div class="grid-2">
    @auth
        <a class="card quick-link" href="{{ route('blood.donors') }}">
            <div class="feature-icon">🩸</div>
            <div>
                <strong>Donors</strong>
                <span>Browse list</span>
            </div>
        </a>
        <a class="card quick-link" href="{{ route('blood.requests') }}">
            <div class="feature-icon">📋</div>
            <div>
                <strong>Requests</strong>
                <span>Open needs</span>
            </div>
        </a>
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
    @auth
        @if(auth()->user()->isAdmin())
            <a class="card quick-link" href="{{ route('blood.admin.dashboard') }}">
                <div class="feature-icon">⚙️</div>
                <div>
                    <strong>Admin</strong>
                    <span>Dashboard</span>
                </div>
            </a>
        @endif
    @endauth
</div>

@endsection
