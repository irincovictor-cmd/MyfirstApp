@extends('layouts.blood')
@section('title', 'Login')
@section('content')

<div class="form-page">
    <div class="form-card" style="padding:0;overflow:hidden;">
        {{-- Header strip (sample layout, our colors) --}}
        <div style="background:var(--blood);color:#fff;padding:1.15rem 1.25rem;">
            <h1 style="margin:0;font-size:1.35rem;font-weight:700;">🔐 Login</h1>
            <p style="margin:0.35rem 0 0;font-size:0.88rem;opacity:0.9;">BloodLink account</p>
        </div>

        <div style="padding:1.25rem 1.25rem 1.35rem;">
            <form method="POST" action="{{ route('blood.login.submit') }}">
                @csrf

                <div class="field">
                    <label for="role">Type</label>
                    <select id="role" name="role" required>
                        <option value="user" @selected(old('role', 'user') === 'user')>User</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
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
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        value="1"
                        style="width:auto;"
                    >
                    <label for="remember" style="margin:0;font-weight:500;">Remember me</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="{{ route('blood.register') }}" class="btn btn-ghost">Register</a>
                </div>
            </form>

            <p class="hint" style="margin-top:1rem;text-align:center;">
                First admin? <a href="{{ route('blood.setup') }}" style="color:var(--blood);font-weight:600;">Setup</a>
            </p>
        </div>
    </div>
</div>

@endsection
