@extends('layouts.blood')
@section('title', isset($setup) && $setup ? 'Setup Admin' : 'Register Admin')
@section('content')
<div class="form-page">
    <h1 class="section-title">{{ isset($setup) && $setup ? 'Create first admin' : 'Register admin' }}</h1>
    <p class="section-sub">
        {{ isset($setup) && $setup
            ? 'No admin exists yet. Create the first admin account for BloodLink.'
            : 'Create another admin account for managing the blood donation system.' }}
    </p>

    <div class="form-card">
        <form method="POST" action="{{ isset($setup) && $setup ? route('blood.setup.submit') : route('blood.admin.store') }}">
            @csrf

            <div class="field">
                <label for="name">Full name</label>
                <input id="name" name="name" value="{{ old('name') }}" required placeholder="Admin name">
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="admin@example.com">
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required minlength="4" placeholder="Min. 4 characters">
                <p class="hint">Use at least 4 characters.</p>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">{{ isset($setup) && $setup ? 'Create & log in' : 'Create admin' }}</button>
                @unless(isset($setup) && $setup)
                    <a class="btn btn-ghost" href="{{ route('blood.admin.dashboard') }}">Cancel</a>
                @else
                    <a class="btn btn-ghost" href="{{ route('blood.login') }}">Back to login</a>
                @endunless
            </div>
        </form>
    </div>
</div>
@endsection
