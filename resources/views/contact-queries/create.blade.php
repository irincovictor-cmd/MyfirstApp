@extends('layouts.blood')
@section('title', 'Contact')
@section('content')
<div class="form-page">
    <h1 class="section-title">Contact us</h1>
    <p class="section-sub">Questions about donating, requesting blood, or the system? Send a message.</p>

    <div class="form-card">
        <form method="POST" action="{{ route('blood.contact.store') }}">
            @csrf

            <div class="field">
                <label for="name">Your name</label>
                <input id="name" name="name" value="{{ old('name') }}" required placeholder="Full name">
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com">
            </div>

            <div class="field">
                <label for="subject">Subject <span style="font-weight:400;color:var(--muted)">(optional)</span></label>
                <input id="subject" name="subject" value="{{ old('subject') }}" placeholder="What is this about?">
            </div>

            <div class="field">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required placeholder="Write your message here…">{{ old('message') }}</textarea>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Send message</button>
                <a class="btn btn-ghost" href="{{ route('blood.home') }}">Back to home</a>
            </div>
        </form>
    </div>
</div>
@endsection
