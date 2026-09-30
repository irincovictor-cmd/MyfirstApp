@extends('layouts.blood')
@section('title', 'Admin')
@section('content')

<div class="head-row">
    <div>
        <h1 class="section-title">⚙️ Admin</h1>
        <p class="section-sub">Overview</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.admin.create') }}">+ Admin</a>
</div>

<div class="grid-3">
    <div class="card">
        <div class="stat">{{ $donors ?? 0 }}</div>
        <div class="stat-label">🩸 Donors</div>
    </div>
    <div class="card">
        <div class="stat">{{ $requests ?? 0 }}</div>
        <div class="stat-label">📋 Requests</div>
    </div>
    <div class="card">
        <div class="stat">{{ $messages ?? 0 }}</div>
        <div class="stat-label">✉️ Messages</div>
    </div>
</div>
<div class="grid-2" style="margin-top:0.85rem;">
    <div class="card">
        <div class="stat">{{ $pages ?? 0 }}</div>
        <div class="stat-label">📄 Pages</div>
    </div>
    <div class="card">
        <div class="stat">{{ $admins ?? 0 }}</div>
        <div class="stat-label">👤 Admins</div>
    </div>
</div>

<h3 class="section-title" style="margin-top:1.5rem;font-size:1.05rem;">Actions</h3>
<div class="grid-2" style="margin-top:0.65rem;">
    <a class="card quick-link" href="{{ route('blood.donors') }}">
        <div class="feature-icon">🩸</div>
        <div><strong>Donors</strong><span>View list</span></div>
    </a>
    <a class="card quick-link" href="{{ route('blood.requests') }}">
        <div class="feature-icon">📋</div>
        <div><strong>Requests</strong><span>View list</span></div>
    </a>
    <a class="card quick-link" href="{{ route('blood.contact-queries') }}">
        <div class="feature-icon">✉️</div>
        <div><strong>Messages</strong><span>Inbox</span></div>
    </a>
    <a class="card quick-link" href="{{ route('blood.pages') }}">
        <div class="feature-icon">📄</div>
        <div><strong>Pages</strong><span>Manage</span></div>
    </a>
    <a class="card quick-link" href="{{ route('blood.donor.create') }}">
        <div class="feature-icon">+</div>
        <div><strong>Add donor</strong><span>New record</span></div>
    </a>
    <a class="card quick-link" href="{{ route('blood.request.create') }}">
        <div class="feature-icon">+</div>
        <div><strong>Add request</strong><span>New record</span></div>
    </a>
</div>

<div class="grid-2" style="margin-top:1.25rem;">
    <div class="card">
        <h3 style="margin-bottom:0.6rem;">Recent donors</h3>
        @forelse($recentDonors ?? [] as $d)
            <div class="list-item">
                <span class="name">{{ $d->first_name }} {{ $d->last_name }}</span>
                <span class="badge">{{ $d->blood_type }}</span>
            </div>
        @empty
            <p style="margin:0;color:var(--muted);font-size:0.88rem;">None yet</p>
        @endforelse
    </div>
    <div class="card">
        <h3 style="margin-bottom:0.6rem;">Recent requests</h3>
        @forelse($recentRequests ?? [] as $r)
            <div class="list-item">
                <span class="name">{{ $r->first_name }} {{ $r->last_name }}</span>
                <span class="badge">{{ $r->blood_type }}</span>
            </div>
        @empty
            <p style="margin:0;color:var(--muted);font-size:0.88rem;">None yet</p>
        @endforelse
    </div>
</div>

@if(isset($recentMessages) && count($recentMessages))
<div class="card" style="margin-top:1rem;">
    <h3 style="margin-bottom:0.6rem;">Recent messages</h3>
    @foreach($recentMessages as $m)
        <div class="list-item" style="flex-direction:column;align-items:flex-start;">
            <span class="name">{{ $m->name }}</span>
            <span style="color:var(--muted);font-size:0.85rem;">{{ \Illuminate\Support\Str::limit($m->message, 80) }}</span>
        </div>
    @endforeach
</div>
@endif

@endsection
