@extends('layouts.blood')
@section('title', 'Register Admin')
@section('content')
<div class="form-page">
    <h1 class="section-title">Register admin</h1>
    <p class="section-sub">Create an admin account for managing the blood donation system.</p>

    <div class="form-card">
        <form method="POST" action="{{ route('blood.admin.store') }}">
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
                <button class="btn btn-primary" type="submit">Create admin</button>
                <a class="btn btn-ghost" href="{{ route('blood.admin.dashboard') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
