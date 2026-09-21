@extends('layouts.blood')
@section('title', 'Admin')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Admin dashboard</h1>
        <p class="section-sub">admin/index.blade.php · blood donation tables</p>
    </div>
    <a class="btn btn-ghost" href="{{ route('blood.admin.create') }}">+ Register admin</a>
</div>
<div class="grid-3">
    <div class="card"><div class="stat">{{ $donors ?? 0 }}</div><h3>Donors</h3></div>
    <div class="card"><div class="stat">{{ $requests ?? 0 }}</div><h3>Requests</h3></div>
    <div class="card"><div class="stat">{{ $messages ?? 0 }}</div><h3>Messages</h3></div>
</div>
<div class="grid-3" style="margin-top:1rem;">
    <div class="card"><div class="stat">{{ $pages ?? 0 }}</div><h3>Pages</h3></div>
    <div class="card"><div class="stat">{{ $admins ?? 0 }}</div><h3>Admins</h3></div>
</div>
<div class="grid-2" style="margin-top:1.25rem;">
    <div class="card">
        <h3>Recent donors</h3>
        @forelse($recentDonors ?? [] as $d)
            <p style="margin:.4rem 0;">{{ $d->first_name }} {{ $d->last_name }} — <span class="badge">{{ $d->blood_type }}</span></p>
        @empty
            <p style="color:#6b5a5e;margin:0;">None yet.</p>
        @endforelse
    </div>
    <div class="card">
        <h3>Recent requests</h3>
        @forelse($recentRequests ?? [] as $r)
            <p style="margin:.4rem 0;">{{ $r->first_name }} {{ $r->last_name }} — <span class="badge">{{ $r->blood_type }}</span></p>
        @empty
            <p style="color:#6b5a5e;margin:0;">None yet.</p>
        @endforelse
    </div>
</div>
@endsection
