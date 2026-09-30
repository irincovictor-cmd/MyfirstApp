@extends('layouts.blood')
@section('title', 'Login')
@section('content')
<div class="form-page">
    <h1 class="section-title">Log in</h1>
    <p class="section-sub">Choose <strong>User</strong> for donors/requests, or <strong>Admin</strong> for the dashboard.</p>

    @if(session('error'))
        <div class="alert alert-error" style="text-align:left;max-width:28rem;margin:0 auto 1rem;">{{ session('error') }}</div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('blood.login.submit') }}">
            @csrf
            <div class="field">
                <label>Account type</label>
                <select name="role" required>
                    <option value="user" @selected(old('role', 'user') === 'user')>User (donor / request)</option>
                    <option value="admin" @selected(old('role') === 'admin')>Admin (dashboard)</option>
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
                <button type="submit" class="btn btn-primary">Log in</button>
                <a href="{{ route('blood.register') }}" class="btn btn-ghost">Create user account</a>
            </div>
        </form>
        <p class="hint" style="margin-top:1rem;">
            First admin? Register one at Admin → after logging in with an existing admin,
            or create via <code>/blood/admin/register</code> once an admin session exists.
            Default seed (if empty): run the seeder or register the first admin from the terminal notes.
        </p>
    </div>
</div>
@endsection
