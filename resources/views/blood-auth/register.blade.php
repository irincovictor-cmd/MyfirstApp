@extends('layouts.blood')
@section('title', 'Register')
@section('content')

<div class="form-page">
    <div class="form-card" style="padding:0;overflow:hidden;">
        <div style="background:var(--blood);color:#fff;padding:1.15rem 1.25rem;">
            <h1 style="margin:0;font-size:1.35rem;font-weight:700;">📝 Register</h1>
            <p style="margin:0.35rem 0 0;font-size:0.88rem;opacity:0.9;">Create user account</p>
        </div>

        <div style="padding:1.25rem 1.25rem 1.35rem;">
            <form method="POST" action="{{ route('blood.register.submit') }}">
                @csrf

                <div class="field">
                    <label for="name">Full name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Your name"
                    >
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
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
                        minlength="4"
                        autocomplete="new-password"
                        placeholder="Min. 4 characters"
                    >
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        minlength="4"
                        autocomplete="new-password"
                        placeholder="Repeat password"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create account</button>
                    <a href="{{ route('blood.login') }}" class="btn btn-ghost">Login</a>
                </div>
            </form>

            <p class="hint" style="margin-top:1rem;text-align:center;">
                Already registered?
                <a href="{{ route('blood.login') }}" style="color:var(--blood);font-weight:600;">Login</a>
            </p>
        </div>
    </div>
</div>

@endsection
