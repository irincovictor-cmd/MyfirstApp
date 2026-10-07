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

<p class="section-sub" style="margin:0.9rem 0 0.4rem;">Actions</p>
<div class="action-row">
    <a class="action-chip" href="{{ route('blood.donors') }}">🩸 Manage donors</a>
    <a class="action-chip" href="{{ route('blood.requests') }}">📋 Manage requests</a>
    <a class="action-chip" href="{{ route('blood.contact-queries') }}">✉️ Messages</a>
    <a class="action-chip" href="{{ route('blood.pages') }}">📄 Pages</a>
    <a class="action-chip" href="{{ route('blood.donor.create') }}">+ Donor</a>
    <a class="action-chip" href="{{ route('blood.request.create') }}">+ Request</a>
</div>

<div class="grid-2" style="margin-top:0.35rem;">
    <div class="panel">
        <h3>Recent donors</h3>
        @forelse($recentDonors ?? [] as $d)
            <div class="list-item" style="flex-wrap:wrap;gap:0.35rem;">
                <span class="name">{{ $d->first_name }} {{ $d->last_name }}</span>
                <span class="badge">{{ $d->blood_type }}</span>
                <span class="status status-{{ strtolower($d->status ?? 'pending') }}">{{ $d->status ?? 'pending' }}</span>
                @if(($d->status ?? 'pending') === 'pending')
                    <form method="POST" action="{{ route('blood.donor.status', $d) }}" style="margin-left:auto;">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-primary" style="padding:0.2rem 0.4rem;font-size:0.7rem;">✓ Approve</button>
                    </form>
                @endif
            </div>
        @empty
            <p style="margin:0;color:var(--muted);font-size:0.84rem;">None yet</p>
        @endforelse
        <p style="margin:0.5rem 0 0;"><a href="{{ route('blood.donors') }}" style="font-size:0.8rem;color:var(--blood);font-weight:600;">All donors →</a></p>
    </div>
    <div class="panel">
        <h3>Recent requests</h3>
        @forelse($recentRequests ?? [] as $r)
            <div class="list-item" style="flex-wrap:wrap;gap:0.35rem;">
                <span class="name">{{ $r->first_name }} {{ $r->last_name }}</span>
                <span class="badge">{{ $r->blood_type }}</span>
                <span class="status status-{{ strtolower($r->status ?? 'pending') }}">{{ $r->status ?? 'pending' }}</span>
                @if(($r->status ?? 'pending') === 'pending')
                    <form method="POST" action="{{ route('blood.request.status', $r) }}" style="margin-left:auto;">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-primary" style="padding:0.2rem 0.4rem;font-size:0.7rem;">✓ Approve</button>
                    </form>
                @endif
            </div>
        @empty
            <p style="margin:0;color:var(--muted);font-size:0.84rem;">None yet</p>
        @endforelse
        <p style="margin:0.5rem 0 0;"><a href="{{ route('blood.requests') }}" style="font-size:0.8rem;color:var(--blood);font-weight:600;">All requests →</a></p>
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
