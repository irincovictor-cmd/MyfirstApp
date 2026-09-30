@extends('layouts.blood')
@section('title', 'Login')
@section('content')
<div class="form-page">
    <h1 class="section-title">🔐 Login</h1>
    <p class="section-sub">User or Admin</p>

    <div class="form-card">
        <form method="POST" action="{{ route('blood.login.submit') }}">
            @csrf
            <div class="field">
                <label>Type</label>
                <select name="role" required>
                    <option value="user" @selected(old('role', 'user') === 'user')>User</option>
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                </select>
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required autocomplete="current-password">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="{{ route('blood.register') }}" class="btn btn-ghost">Register</a>
            </div>
        </form>
        <p class="hint" style="margin-top:0.85rem;">
            First admin? Open <code>/blood/setup-admin</code>
        </p>
    </div>
</div>
@endsection
