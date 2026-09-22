@extends('layouts.blood')
@section('title', 'Register Admin')
@section('content')
<div class="form-page">
    <h1 class="section-title">Register admin</h1>
    <p class="section-sub">admin/create · <code>tbladmin</code></p>
    <div class="form-card">
        <form method="POST" action="{{ route('blood.admin.store') }}">
            @csrf
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" required>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Password</label>
            <input type="password" name="password" required minlength="4">
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Create admin</button>
                <a class="btn btn-ghost" href="{{ route('blood.admin.dashboard') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
