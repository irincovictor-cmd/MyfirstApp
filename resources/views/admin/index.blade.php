@extends('layouts.blood')
@section('title', 'Admin')
@section('content')

<div class="head-row">
    <div>
        <h1 class="section-title">⚙️ Admin</h1>
        <p class="section-sub">Dashboard</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.admin.create') }}">+ Admin</a>
</div>

{{-- Compact stats — one row on desktop --}}
<div class="grid-5">
    <div class="stat-card">
        <div class="stat">{{ $donors ?? 0 }}</div>
        <div class="stat-label">🩸 Donors</div>
    </div>
    <div class="stat-card tone-warn">
        <div class="stat">{{ $requests ?? 0 }}</div>
        <div class="stat-label">📋 Requests</div>
    </div>
    <div class="stat-card tone-blue">
        <div class="stat">{{ $messages ?? 0 }}</div>
        <div class="stat-label">✉️ Messages</div>
    </div>
    <div class="stat-card tone-ok">
        <div class="stat">{{ $pages ?? 0 }}</div>
        <div class="stat-label">📄 Pages</div>
    </div>
    <div class="stat-card tone-purple">
        <div class="stat">{{ $admins ?? 0 }}</div>
        <div class="stat-label">👤 Admins</div>
    </div>
</div>

{{-- Chip actions — no huge empty white boxes --}}
<p class="section-sub" style="margin:0.9rem 0 0.4rem;">Actions</p>
<div class="action-row">
    <a class="action-chip" href="{{ route('blood.donors') }}">🩸 Donors</a>
    <a class="action-chip" href="{{ route('blood.requests') }}">📋 Requests</a>
    <a class="action-chip" href="{{ route('blood.contact-queries') }}">✉️ Messages</a>
    <a class="action-chip" href="{{ route('blood.pages') }}">📄 Pages</a>
    <a class="action-chip" href="{{ route('blood.donor.create') }}">+ Donor</a>
    <a class="action-chip" href="{{ route('blood.request.create') }}">+ Request</a>
    <a class="action-chip" href="{{ route('blood.contact-info.index') }}">ℹ️ Contact info</a>
</div>

<div class="grid-2" style="margin-top:0.35rem;">
    <div class="panel">
        <h3>Recent donors</h3>
        @forelse($recentDonors ?? [] as $d)
            <div class="list-item">
                <span class="name">{{ $d->first_name }} {{ $d->last_name }}</span>
                <span class="badge">{{ $d->blood_type }}</span>
            </div>
        @empty
            <p style="margin:0;color:var(--muted);font-size:0.84rem;">None yet</p>
        @endforelse
    </div>
    <div class="panel">
        <h3>Recent requests</h3>
        @forelse($recentRequests ?? [] as $r)
            <div class="list-item">
                <span class="name">{{ $r->first_name }} {{ $r->last_name }}</span>
                <span class="badge">{{ $r->blood_type }}</span>
            </div>
        @empty
            <p style="margin:0;color:var(--muted);font-size:0.84rem;">None yet</p>
        @endforelse
    </div>
</div>

@if(isset($recentMessages) && count($recentMessages))
<div class="panel" style="margin-top:0.55rem;">
    <h3>Recent messages</h3>
    @foreach($recentMessages as $m)
        <div class="list-item" style="flex-direction:column;align-items:flex-start;">
            <span class="name">{{ $m->name }}</span>
            <span style="color:var(--muted);font-size:0.8rem;">{{ \Illuminate\Support\Str::limit($m->message, 90) }}</span>
        </div>
    @endforeach
</div>
@endif

@endsection
