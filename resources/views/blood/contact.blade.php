@extends('blood.layout')

@section('title', 'Contact')

@section('content')
<h1 class="section-title" style="margin-top:0;">Contact us</h1>
<p class="section-sub">Messages go to <code>tblcontactusquery</code> and show on the Admin dashboard.</p>

<div class="card" style="max-width:32rem;">
    <form method="POST" action="{{ route('blood.contact.store') }}">
        @csrf
        <label for="name">Name</label>
        <input id="name" name="name" value="{{ old('name') }}" required>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>

        <label for="subject">Subject</label>
        <input id="subject" name="subject" value="{{ old('subject') }}">

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Send message</button>
        </div>
    </form>
</div>
@endsection
