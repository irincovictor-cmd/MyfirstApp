@extends('layouts.blood')
@section('title', 'Contact')
@section('content')
<div class="form-page">
    <h1 class="section-title">✉️ Contact</h1>
    <p class="section-sub">Send a message</p>

    <div class="form-card">
        <form method="POST" action="{{ route('blood.contact.store') }}">
            @csrf
            <div class="field">
                <label for="name">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <label for="subject">Subject</label>
                <input id="subject" name="subject" value="{{ old('subject') }}">
            </div>
            <div class="field">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Send</button>
                <a class="btn btn-ghost" href="{{ route('blood.home') }}">Home</a>
            </div>
        </form>
    </div>
</div>
@endsection
