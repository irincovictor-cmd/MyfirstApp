@extends('blood.layout')

@section('title', 'Register Admin')

@section('content')
<h1 class="section-title" style="margin-top:0;">Register admin</h1>
<p class="section-sub">Creates a row in <code>tbladmin</code>.</p>

<div class="card" style="max-width:28rem;">
    <form method="POST" action="{{ route('blood.admin.store') }}">
        @csrf
        <label for="name">Name</label>
        <input id="name" name="name" value="{{ old('name') }}" required>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required minlength="4">

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Create admin</button>
            <a class="btn btn-ghost" href="{{ route('blood.admin.dashboard') }}">Back</a>
        </div>
    </form>
</div>
@endsection
