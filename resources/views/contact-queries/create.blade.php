@extends('layouts.blood')
@section('title', 'Contact')
@section('content')
<div class="form-page">
    <h1 class="section-title">Contact us</h1>
    <p class="section-sub">contact-queries/create · <code>tblcontactusquery</code></p>
    <div class="form-card">
        <form method="POST" action="{{ route('blood.contact.store') }}">
            @csrf
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" required>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Subject</label>
            <input name="subject" value="{{ old('subject') }}">
            <label>Message</label>
            <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Send message</button>
            </div>
        </form>
    </div>
</div>
@endsection
