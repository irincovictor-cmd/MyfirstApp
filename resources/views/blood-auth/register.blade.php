@extends('layouts.blood')
@section('title', 'Register')
@section('content')
<div class="form-page">
    <h1 class="section-title">Create user account</h1>
    <p class="section-sub">Regular users can become donors and submit blood requests.</p>

    <div class="form-card">
        <form method="POST" action="{{ route('blood.register.submit') }}">
            @csrf
            <div class="field">
                <label>Name</label>
                <input name="name" value="{{ old('name') }}" required autocomplete="name">
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required minlength="4" autocomplete="new-password">
            </div>
            <div class="field">
                <label>Confirm password</label>
                <input type="password" name="password_confirmation" required minlength="4" autocomplete="new-password">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Register</button>
                <a href="{{ route('blood.login') }}" class="btn btn-ghost">Already have an account?</a>
            </div>
        </form>
    </div>
</div>
@endsection
