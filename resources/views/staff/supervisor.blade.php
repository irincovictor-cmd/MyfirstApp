@extends('layouts.blood')
@section('title', 'Supervisor Dashboard')
@section('content')

<div class="head-row">
    <div>
        <h1 class="section-title">👁️ Supervisor Dashboard</h1>
        <p class="section-sub">Role: <strong>{{ $user->role }}</strong> · {{ $user->name }}</p>
    </div>
    <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
        <a class="btn btn-ghost" href="{{ route('staff.employee') }}">Employee view</a>
        <form method="POST" action="{{ route('staff.logout') }}">@csrf<button type="submit" class="btn btn-ghost">Logout</button></form>
    </div>
</div>

<div class="panel" style="margin-bottom:1rem;">
    <h3 style="text-transform:none;letter-spacing:0;font-size:1rem;color:var(--ink);">Access guide</h3>
    <ul style="margin:0.5rem 0 0;padding-left:1.2rem;font-size:0.9rem;line-height:1.7;">
        <li>✅ Supervisor dashboard</li>
        <li>✅ Employee dashboard <span class="badge">role shown as {{ $user->role }}</span></li>
        <li>❌ Manager dashboard (cannot access)</li>
    </ul>
</div>

<div class="grid-3">
    <div class="stat-card">
        <div class="stat">{{ $counts['employees'] ?? 0 }}</div>
        <div class="stat-label">Employees</div>
    </div>
    <div class="stat-card tone-warn">
        <div class="stat">{{ $counts['managers'] ?? 0 }}</div>
        <div class="stat-label">Managers</div>
    </div>
    <div class="stat-card tone-purple">
        <div class="stat">{{ $counts['supervisors'] ?? 0 }}</div>
        <div class="stat-label">Supervisors</div>
    </div>
</div>

<div class="card" style="margin-top:1rem;max-width:36rem;">
    <p style="margin:0;color:var(--muted);font-size:0.88rem;line-height:1.55;">
        Hierarchy for this exam: <strong>Supervisor → Manager → Employee</strong>.
        Supervisors oversee counts and employee view; managers alone handle add/edit/delete of employees.
    </p>
</div>

@endsection
