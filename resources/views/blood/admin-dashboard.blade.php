@extends('blood.layout')

@section('title', 'Admin')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 class="section-title" style="margin-top:0;">Admin dashboard</h1>
        <p class="section-sub">Live counts from the blood donation tables.</p>
    </div>
    <a class="btn btn-ghost" href="{{ route('blood.admin.create') }}">+ Register admin</a>
</div>

<div class="grid-3">
    <div class="card"><div class="stat">{{ $donors }}</div><h3>Donors</h3></div>
    <div class="card"><div class="stat">{{ $requests }}</div><h3>Requests</h3></div>
    <div class="card"><div class="stat">{{ $messages }}</div><h3>Messages</h3></div>
</div>
<div class="grid-3" style="margin-top:1rem;">
    <div class="card"><div class="stat">{{ $pages }}</div><h3>Pages</h3></div>
    <div class="card"><div class="stat">{{ $admins }}</div><h3>Admins</h3></div>
</div>

<div class="grid-2" style="margin-top:1.5rem;">
    <div class="card">
        <h3>Recent donors</h3>
        @forelse($recentDonors as $d)
            <p style="margin:0.4rem 0;">{{ $d->first_name }} {{ $d->last_name }} — <span class="badge">{{ $d->blood_type }}</span></p>
        @empty
            <p style="color:#6b5a5e;margin:0;">None yet.</p>
        @endforelse
    </div>
    <div class="card">
        <h3>Recent requests</h3>
        @forelse($recentRequests as $r)
            <p style="margin:0.4rem 0;">{{ $r->first_name }} {{ $r->last_name }} — <span class="badge">{{ $r->blood_type }}</span> ({{ $r->units_needed }} u)</p>
        @empty
            <p style="color:#6b5a5e;margin:0;">None yet.</p>
        @endforelse
    </div>
</div>

<div class="card" style="margin-top:1.25rem;">
    <h3>Recent contact messages</h3>
    @forelse($recentMessages as $m)
        <p style="margin:0.5rem 0;"><strong>{{ $m->name }}</strong> ({{ $m->email }}) — {{ \Illuminate\Support\Str::limit($m->message, 80) }}</p>
    @empty
        <p style="color:#6b5a5e;margin:0;">No messages.</p>
    @endforelse
</div>
@endsection
