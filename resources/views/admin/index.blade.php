@extends('layouts.blood')
@section('title', 'Admin')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Admin dashboard</h1>
        <p class="section-sub">Overview of donors, requests, and recent activity.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.admin.create') }}">+ Register admin</a>
</div>

<div class="grid-3">
    <div class="card">
        <div class="stat">{{ $donors ?? 0 }}</div>
        <div class="stat-label">Donors</div>
    </div>
    <div class="card">
        <div class="stat">{{ $requests ?? 0 }}</div>
        <div class="stat-label">Blood requests</div>
    </div>
    <div class="card">
        <div class="stat">{{ $messages ?? 0 }}</div>
        <div class="stat-label">Messages</div>
    </div>
</div>
<div class="grid-2" style="margin-top:1rem;">
    <div class="card">
        <div class="stat">{{ $pages ?? 0 }}</div>
        <div class="stat-label">Info pages</div>
    </div>
    <div class="card">
        <div class="stat">{{ $admins ?? 0 }}</div>
        <div class="stat-label">Admin accounts</div>
    </div>
</div>

{{-- Quick actions --}}
<div style="margin-top:1.5rem;">
    <h3 style="margin:0 0 0.75rem;font-size:1rem;">Quick actions</h3>
    <div class="grid-2">
        <a class="card quick-link" href="{{ route('blood.donors') }}">
            <div class="feature-icon blood">D</div>
            <div>
                <strong>View all donors</strong>
                <span>List and filter registered donors</span>
            </div>
        </a>
        <a class="card quick-link" href="{{ route('blood.requests') }}">
            <div class="feature-icon blood">R</div>
            <div>
                <strong>View all requests</strong>
                <span>Blood requests by type and date</span>
            </div>
        </a>
        <a class="card quick-link" href="{{ route('blood.contact-queries') }}">
            <div class="feature-icon">M</div>
            <div>
                <strong>Contact messages</strong>
                <span>Messages sent from the contact form</span>
            </div>
        </a>
        <a class="card quick-link" href="{{ route('blood.pages') }}">
            <div class="feature-icon">P</div>
            <div>
                <strong>Info pages</strong>
                <span>View or create content pages</span>
            </div>
        </a>
        <a class="card quick-link" href="{{ route('blood.donor.create') }}">
            <div class="feature-icon blood">+</div>
            <div>
                <strong>Add a donor</strong>
                <span>Register a new blood donor</span>
            </div>
        </a>
        <a class="card quick-link" href="{{ route('blood.request.create') }}">
            <div class="feature-icon blood">+</div>
            <div>
                <strong>Add a request</strong>
                <span>Submit a new blood request</span>
            </div>
        </a>
    </div>
</div>

<div class="grid-2" style="margin-top:1.5rem;">
    <div class="card">
        <h3 style="margin-bottom:0.75rem;">Recent donors</h3>
        @forelse($recentDonors ?? [] as $d)
            <div class="list-item">
                <span class="name">{{ $d->first_name }} {{ $d->last_name }}</span>
                <span class="badge">{{ $d->blood_type }}</span>
            </div>
        @empty
            <p style="margin:0;color:var(--muted);">No donors yet.</p>
        @endforelse
    </div>
    <div class="card">
        <h3 style="margin-bottom:0.75rem;">Recent requests</h3>
        @forelse($recentRequests ?? [] as $r)
            <div class="list-item">
                <span class="name">{{ $r->first_name }} {{ $r->last_name }} · {{ $r->units_needed }}u</span>
                <span class="badge">{{ $r->blood_type }}</span>
            </div>
        @empty
            <p style="margin:0;color:var(--muted);">No requests yet.</p>
        @endforelse
    </div>
</div>

@if(isset($recentMessages) && count($recentMessages))
<div class="card" style="margin-top:1.25rem;">
    <h3 style="margin-bottom:0.75rem;">Recent messages</h3>
    @foreach($recentMessages as $m)
        <div class="list-item" style="flex-direction:column;align-items:flex-start;">
            <span class="name">{{ $m->name }} <span style="font-weight:400;color:var(--muted);">&lt;{{ $m->email }}&gt;</span></span>
            <span style="color:var(--muted);font-size:0.88rem;">{{ \Illuminate\Support\Str::limit($m->message, 100) }}</span>
        </div>
    @endforeach
</div>
@endif
@endsection
