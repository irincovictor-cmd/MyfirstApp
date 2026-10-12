@extends('layouts.blood')
@section('title', 'Employee Dashboard')
@section('content')

<div class="head-row">
    <div>
        <h1 class="section-title">👤 Employee Dashboard</h1>
        <p class="section-sub">Role: <strong>{{ $user->role }}</strong> · {{ $user->name }}</p>
    </div>
    <form method="POST" action="{{ route('staff.logout') }}">
        @csrf
        <button type="submit" class="btn btn-ghost">Logout</button>
    </form>
</div>

<div class="panel" style="max-width:36rem;margin:0 auto;">
    <h3 style="text-transform:none;letter-spacing:0;font-size:1rem;color:var(--ink);">What you can access</h3>
    <p style="margin:0.5rem 0 0;color:var(--muted);font-size:0.9rem;line-height:1.6;">
        As an <strong>Employee</strong> you only see this dashboard.
        You <strong>cannot</strong> open Manager or Supervisor pages.
    </p>
    <ul style="margin:0.75rem 0 0;padding-left:1.2rem;color:var(--ink);font-size:0.9rem;line-height:1.7;">
        <li>✅ Employee dashboard</li>
        <li>❌ Manager dashboard</li>
        <li>❌ Supervisor dashboard</li>
    </ul>
</div>

<div class="card" style="max-width:36rem;margin:1rem auto 0;text-align:center;">
    <p style="margin:0;color:var(--muted);font-size:0.88rem;">Logged in as</p>
    <p style="margin:0.25rem 0 0;font-weight:800;">{{ $user->email }}</p>
    <span class="badge" style="margin-top:0.5rem;">{{ $user->role }}</span>
</div>

@endsection
