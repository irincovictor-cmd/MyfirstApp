@extends('layouts.blood')
@section('title', 'Staff Login')
@section('content')

<div class="form-page">
    <div class="form-card" style="padding:0;overflow:hidden;">
        <div style="background:var(--blood);color:#fff;padding:1.15rem 1.25rem;">
            <h1 style="margin:0;font-size:1.35rem;font-weight:700;">🔐 Staff Login</h1>
            <p style="margin:0.35rem 0 0;font-size:0.88rem;opacity:0.9;">Employee · Manager · Supervisor</p>
        </div>

        <div style="padding:1.25rem 1.25rem 1.35rem;">
            <form method="POST" action="{{ route('staff.login.submit') }}">
                @csrf

                <div class="field">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="employee" @selected(old('role', 'employee') === 'employee')>Employee</option>
                        <option value="manager" @selected(old('role') === 'manager')>Manager</option>
                        <option value="supervisor" @selected(old('role') === 'supervisor')>Supervisor</option>
                    </select>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="you@example.com"
                    >
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    >
                </div>

                <div class="field" style="display:flex;align-items:center;gap:0.45rem;">
                    <input id="remember" type="checkbox" name="remember" value="1" style="width:auto;">
                    <label for="remember" style="margin:0;font-weight:500;">Remember me</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>

            <p class="hint" style="margin-top:1rem;text-align:center;line-height:1.5;">
                Demo accounts (seed with tinker if missing):<br>
                <code>employee@example.com</code> / Employee123!<br>
                <code>manager@example.com</code> / Password123!<br>
                <code>supervisor@example.com</code> / Supervisor123!
            </p>
        </div>
    </div>
</div>

@endsection
