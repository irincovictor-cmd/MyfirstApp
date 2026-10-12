@extends('layouts.blood')
@section('title', 'Manager Dashboard')
@section('content')

<div class="head-row">
    <div>
        <h1 class="section-title">📋 Manager Dashboard</h1>
        <p class="section-sub">Role: <strong>{{ $user->role }}</strong> · {{ $user->name }} · Add / edit / delete employees</p>
    </div>
    <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
        <a class="btn btn-ghost" href="{{ route('staff.employee') }}">Employee view</a>
        <a class="btn btn-ghost" href="{{ route('staff.supervisor') }}">Supervisor view</a>
        <form method="POST" action="{{ route('staff.logout') }}">@csrf<button type="submit" class="btn btn-ghost">Logout</button></form>
    </div>
</div>

<div class="panel" style="margin-bottom:1rem;">
    <h3 style="text-transform:none;letter-spacing:0;font-size:1rem;color:var(--ink);">Access guide</h3>
    <p style="margin:0.35rem 0 0;color:var(--muted);font-size:0.88rem;">
        Manager can open <strong>Employee</strong> and <strong>Supervisor</strong> pages (shown as Role: Manager).
        This page is for managing employee accounts only.
    </p>
</div>

{{-- Add employee --}}
<div class="form-card" style="max-width:28rem;margin-bottom:1rem;">
    <h2 class="section-title" style="font-size:1rem;">+ Add employee</h2>
    <form method="POST" action="{{ route('staff.employee.store') }}">
        @csrf
        <div class="field">
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" required>
        </div>
        <div class="field">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" required minlength="4">
        </div>
        <button type="submit" class="btn btn-primary">Create employee</button>
    </form>
</div>

{{-- Employee list --}}
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $emp)
                <tr>
                    <td colspan="2" style="padding:0.4rem 0.7rem;">
                        <form method="POST" action="{{ route('staff.employee.update', $emp) }}" style="display:flex;flex-wrap:wrap;gap:0.35rem;align-items:center;">
                            @csrf
                            @method('PUT')
                            <input name="name" value="{{ $emp->name }}" required style="width:8rem;padding:0.3rem;font-size:0.8rem;">
                            <input type="email" name="email" value="{{ $emp->email }}" required style="width:11rem;padding:0.3rem;font-size:0.8rem;">
                            <input type="password" name="password" placeholder="New pass (optional)" style="width:8rem;padding:0.3rem;font-size:0.8rem;">
                            <button type="submit" class="btn btn-primary" style="padding:0.25rem 0.5rem;font-size:0.72rem;">Save</button>
                        </form>
                    </td>
                    <td></td>
                    <td>
                        <form method="POST" action="{{ route('staff.employee.destroy', $emp) }}" onsubmit="return confirm('Delete {{ $emp->email }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-ghost" style="padding:0.25rem 0.45rem;font-size:0.72rem;color:#9f1239;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;color:var(--muted);">No employees yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
