@extends('layouts.blood')

@section('title', 'Home')

@section('content')
<section class="hero">
    <div class="hero-content">
        <div class="hero-kicker">Blood donation network</div>
        <h1>Give blood. Save lives.</h1>
        <p>Register as a donor, request blood when needed, and help your community stay prepared.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="{{ route('blood.donor.create') }}">Become a donor</a>
            <a class="btn btn-ghost" href="{{ route('blood.request.create') }}" style="background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.25)">Request blood</a>
        </div>
    </div>
</section>

<div class="grid-3" style="margin-top:1.5rem">
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

<div style="margin-top:1.75rem">
    <h2 class="section-title">Blood types we track</h2>
    <p class="section-sub">Compatible matching starts with knowing your type.</p>
    <div class="blood-types" style="display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem">
        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
            <div class="blood-type" style="background:#fff;border:1px solid var(--line);border-radius:14px;padding:1rem;text-align:center;font-weight:700;color:var(--blood)">{{ $type }}<small style="display:block;color:var(--muted);font-weight:500;margin-top:.25rem">Blood type</small></div>
        @endforeach
    </div>
</div>

<div class="grid-2" style="margin-top:1.75rem">
    <a class="card quick-link" href="{{ route('blood.donors') }}">
        <strong>Browse donors</strong>
        <span>See who is registered and filter by blood type</span>
    </a>
    <a class="card quick-link" href="{{ route('blood.requests') }}">
        <strong>View requests</strong>
        <span>Open blood needs sorted by date</span>
    </a>
    <a class="card quick-link" href="{{ route('blood.contact') }}">
        <strong>Contact us</strong>
        <span>Questions about donating or requesting</span>
    </a>
    <a class="card quick-link" href="{{ route('blood.pages') }}">
        <strong>Info pages</strong>
        <span>Guides and system notes</span>
    </a>
</div>
@endsection
